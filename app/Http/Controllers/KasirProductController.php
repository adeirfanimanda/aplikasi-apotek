<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class KasirProductController extends Controller
{
    public function index(Request $request)
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
        return view('kasir.products.index', compact('products'))->with('i', ($request->input('page', 1) - 1) * $pagination);
    }
}
