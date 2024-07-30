<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Kasir;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // menampilkan jumlah data category
        $totalCategory = Category::count();
        // menampilkan jumlah data product
        $totalProduct = Product::count();
        // menampilkan jumlah data kasir
        $totalKasir = Kasir::count();
        // menampilkan jumlah data transaction
        $totalTransaction = Transaction::count();

        // menampilkan data 5 product terlaris
        $transactions = Transaction::select('product_id', DB::raw('sum(qty) as transactions_sum_qty'))->with('product:id,name,kode_obat,price,image')
            ->groupBy('product_id')
            ->orderBy('transactions_sum_qty', 'desc')
            ->take(5)
            ->get();

        // tampilkan data ke view
        return view('dashboard.index', compact('totalCategory', 'totalProduct', 'totalKasir', 'totalTransaction', 'transactions'));
    }
}
