<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        // jumlah data yang ditampilkan per paginasi halaman
        $pagination = 10;

        if ($request->search) {
            // menampilkan pencarian data
            $products = Product::select('id', 'category_id', 'name', 'price', 'image', 'kode_obat', 'tanggal_masuk', 'stok', 'satuan', 'expired')
                ->with('category:id,name')
                ->whereAny(['kode_obat', 'name', 'price', 'satuan'], 'LIKE', '%' . $request->search . '%')
                ->paginate($pagination)
                ->withQueryString();
        } else {
            // menampilkan semua data
            $products = Product::select('id', 'category_id', 'name', 'price', 'image', 'kode_obat', 'tanggal_masuk', 'stok', 'satuan', 'expired')
                ->with('category:id,name')
                ->latest()
                ->paginate($pagination);
        }

        // tampilkan data ke view
        return view('products.index', compact('products'))->with('i', ($request->input('page', 1) - 1) * $pagination);
    }

    public function create(): View
    {
        // get data kategori
        $categories = Category::get(['id', 'name']);

        // tampilkan form add data
        return view('products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        // validasi form
        $request->validate([
            'kode_obat'     => 'required|max:255',
            'name'        => 'required|max:255',
            'description' => 'max:255',
            'image'       => 'required|image|mimes:jpeg,jpg,png|max: 1024',
            'price'       => 'required',
            'category'    => 'required|exists:categories,id',
            'stok'          => 'required|integer',
            'satuan'        => 'required|max:255',
            'tanggal_masuk' => 'required|date',
            'expired'       => 'required|date'
        ]);

        // upload image
        $image = $request->file('image');
        $image->storeAs('public/products', $image->hashName());

        // create data
        Product::create([
            'category_id' => $request->category,
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => str_replace('.', '', $request->price),
            'image'       => $image->hashName(),
            'kode_obat'     => $request->kode_obat,
            'tanggal_masuk' => $request->tanggal_masuk,
            'stok'          => $request->stok,
            'satuan'        => $request->satuan,
            'expired'       => $request->expired
        ]);

        // redirect ke halaman index dan tampilkan pesan berhasil simpan data
        return redirect()->route('products.index')->with(['success' => 'The new product has been saved.']);
    }

    public function show(string $id): View
    {
        // get data by ID
        $product = Product::findOrFail($id);

        // tampilkan form detail data
        return view('products.show', compact('product'));
    }

    public function edit(string $id): View
    {
        // get data product by ID
        $product = Product::findOrFail($id);
        // get data kategori
        $categories = Category::get(['id', 'name']);

        // tampilkan form edit data
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        // validasi form
        $request->validate([
            'kode_obat'     => 'required|max:255',
            'name'        => 'required|max:255',
            'description' => 'max:255',
            'image'       => 'image|mimes:jpeg,jpg,png|max: 1024',
            'price'       => 'required',
            'category'    => 'required|exists:categories,id',
            'stok'          => 'required|integer',
            'satuan'        => 'required|max:255',
            'tanggal_masuk' => 'required|date',
            'expired'       => 'required|date'
        ]);

        // get data by ID
        $product = Product::findOrFail($id);

        // cek jika image diubah
        if ($request->hasFile('image')) {
            // upload image baru
            $image = $request->file('image');
            $image->storeAs('public/products', $image->hashName());

            // delete image lama
            Storage::delete('public/products/' . $product->image);

            // update data
            $product->update([
                'category_id' => $request->category,
                'name'        => $request->name,
                'description' => $request->description,
                'price'       => str_replace('.', '', $request->price),
                'image'       => $image->hashName(),
                'kode_obat'     => $request->kode_obat,
                'tanggal_masuk' => $request->tanggal_masuk,
                'stok'          => $request->stok,
                'satuan'        => $request->satuan,
                'expired'       => $request->expired
            ]);
        }
        // jika image tidak diubah
        else {
            // update data
            $product->update([
                'category_id' => $request->category,
                'name'        => $request->name,
                'description' => $request->description,
                'price'       => str_replace('.', '', $request->price),
                'kode_obat'     => $request->kode_obat,
                'tanggal_masuk' => $request->tanggal_masuk,
                'stok'          => $request->stok,
                'satuan'        => $request->satuan,
                'expired'       => $request->expired
            ]);
        }

        // redirect ke halaman index dan tampilkan pesan berhasil ubah data
        return redirect()->route('products.index')->with(['success' => 'The product has been updated.']);
    }

    public function destroy($id): RedirectResponse
    {
        // get data by ID
        $product = Product::findOrFail($id);

        // delete image
        Storage::delete('public/products/' . $product->image);

        // delete data
        $product->delete();

        // redirect ke halaman index dan tampilkan pesan berhasil hapus data
        return redirect()->route('products.index')->with(['success' => 'The product has been deleted!']);
    }
}
