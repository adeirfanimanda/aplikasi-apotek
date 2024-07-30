<?php

namespace App\Http\Controllers;

use App\Models\Kasir;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        // jumlah data yang ditampilkan per paginasi halaman
        $pagination = 10;
        // get data search
        $search = $request->search;

        if ($search) {
            // menampilkan pencarian data
            $transactions = Transaction::select('id', 'date', 'kasir_id', 'product_id', 'qty', 'total')->with('kasir:id,name', 'product:id,name,price')
                ->whereAny(['date', 'qty', 'total'], 'LIKE', '%' . $search . '%')
                ->orWhereHas('kasir', function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search . '%');
                })
                ->orWhereHas('product', function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search . '%');
                })
                ->paginate($pagination)
                ->withQueryString();
        } else {
            // menampilkan semua data
            $transactions = Transaction::select('id', 'date', 'kasir_id', 'product_id', 'qty', 'total')->with('kasir:id,name', 'product:id,name,price')
                ->latest()
                ->paginate($pagination);
        }

        // tampilkan data ke view
        return view('transactions.index', compact('transactions'))->with('i', ($request->input('page', 1) - 1) * $pagination);
    }

    public function create()
    {
        // get data kasir
        $kasirs = Kasir::get(['id', 'name']);
        // get data product
        $products = Product::get(['id', 'name', 'price', 'stok']);

        // tampilkan form add data
        return view('transactions.create', compact('kasirs', 'products'));
    }

    public function store(Request $request)
    {
        // validasi form
        $request->validate([
            'date'     => 'required',
            'kasir' => 'required|exists:kasirs,id',
            'product'  => 'required|exists:products,id',
            'qty'      => 'required',
            'total'    => 'required'
        ]);

        // Ambil data produk
        $product = Product::findOrFail($request->product);

        // Periksa apakah stok cukup
        if ($product->stok < $request->qty) {
            return redirect()->back()->withErrors(['qty' => 'Jumlah yang diminta melebihi stok yang tersedia.']);
        }

        // create data
        Transaction::create([
            'date'        => $request->date,
            'kasir_id' => $request->kasir,
            'product_id'  => $request->product,
            'qty'         => $request->qty,
            'total'       => str_replace('.', '', $request->total)
        ]);

        // Kurangi stok produk
        $product->stok -= $request->qty;
        $product->save();

        // redirect ke halaman index dan tampilkan pesan berhasil simpan data
        return redirect()->route('transactions.index')->with(['success' => 'The new transaction has been saved.']);
    }

    public function edit(string $id)
    {
        // get data transaction by ID
        $transaction = Transaction::findOrFail($id);
        // get data kasir
        $kasirs = Kasir::get(['id', 'name']);
        // get data product
        $products = Product::get(['id', 'name', 'price', 'stok']);

        // tampilkan form edit data
        return view('transactions.edit', compact('transaction', 'kasirs', 'products'));
    }

    public function update(Request $request, $id)
    {
        // validasi form
        $request->validate([
            'date'     => 'required',
            'kasir' => 'required|exists:kasirs,id',
            'product'  => 'required|exists:products,id',
            'qty'      => 'required',
            'total'    => 'required'
        ]);

        // get data by ID
        $transaction = Transaction::findOrFail($id);

        // hitung perubahan stok
        $oldQty = $transaction->qty;
        $newQty = $request->qty;
        $product = Product::findOrFail($request->product);

        // hitung stok baru setelah perubahan
        $updatedStok = $product->stok + $oldQty - $newQty;

        // cek apakah stok cukup
        if ($updatedStok < 0) {
            return redirect()->back()->withErrors(['qty' => 'Jumlah yang diminta melebihi stok yang tersedia.']);
        }

        // update stok produk
        $product->stok = $updatedStok;
        $product->save();

        // update data
        $transaction->update([
            'date'        => $request->date,
            'kasir_id' => $request->kasir,
            'product_id'  => $request->product,
            'qty'         => $newQty,
            'total'       => str_replace('.', '', $request->total)
        ]);

        // redirect ke halaman index dan tampilkan pesan berhasil ubah data
        return redirect()->route('transactions.index')->with(['success' => 'The transaction has been updated.']);
    }

    public function destroy($id)
    {
        // get data by ID
        $transaction = Transaction::findOrFail($id);

        // delete data
        $transaction->delete();

        // redirect ke halaman index dan tampilkan pesan berhasil hapus data
        return redirect()->route('transactions.index')->with(['success' => 'The transaction has been deleted!']);
    }
}
