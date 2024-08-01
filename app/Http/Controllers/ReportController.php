<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // tampilkan view
        return view('report.index');
    }

    public function filter(Request $request)
    {
        // validasi form
        $request->validate([
            'start_date' => 'required',
            'end_date'   => 'required|date|after_or_equal:start_date'
        ]);

        // data filter
        $startDate = $request->start_date;
        $endDate   = $request->end_date;

        // menampilkan data berdasarkan filter
        $transactions = Transaction::with('product:id,name,price')
            ->whereBetween('date', [$startDate, $endDate])
            ->oldest()
            ->get();

        // tampilkan data ke view
        return view('report.index', compact('transactions'));
    }

    public function print($startDate, $endDate)
    {
        // menampilkan data berdasarkan filter
        $transactions = Transaction::with('product:id,name,price')
            ->whereBetween('date', [$startDate, $endDate])
            ->oldest()
            ->get();

        // Hitung total keseluruhan
        $totalOverall = $transactions->sum('total');

        // load view PDF
        $pdf = Pdf::loadview('report.print', compact('transactions', 'totalOverall'))->setPaper('a4', 'landscape');
        // tampilkan ke browser
        return $pdf->stream('Transaksi.pdf');
    }
}
