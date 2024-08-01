<!DOCTYPE html>
<html lang="en">

<head>
    {{-- Required meta tags --}}
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    {{-- Title --}}
    <title>Laporan Data Transaksi pada
        {{ \Carbon\Carbon::parse(request('start_date'))->translatedFormat('d F Y') }} -
        {{ \Carbon\Carbon::parse(request('end_date'))->translatedFormat('d F Y') }}
    </title>

    {{-- custom style --}}
    <style type="text/css">
        table,
        th,
        td {
            border: 1px solid #dee2e6;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px 5px;
        }

        hr {
            color: #dee2e6;
        }
    </style>
</head>

<body>
    {{-- judul laporan --}}
    <div style="text-align: center">
        <h3>Laporan Data Transaksi pada
            {{ \Carbon\Carbon::parse(request('start_date'))->translatedFormat('d F Y') }} -
            {{ \Carbon\Carbon::parse(request('end_date'))->translatedFormat('d F Y') }}</h3>
    </div>

    <hr style="margin-bottom:20px">

    {{-- tabel tampil data --}}
    <table style="width:100%">
        <thead style="background-color: #6861ce; color: #ffffff">
            <th>NO</th>
            <th>TANGGAL</th>
            <th>KASIR</th>
            <th>OBAT</th>
            <th>HARGA</th>
            <th>QTY</th>
            <th>TOTAL</th>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @forelse ($transactions as $transaction)
                {{-- jika data ada, tampilkan data --}}
                <tr>
                    <td width="30" align="center">{{ $no++ }}</td>
                    <td width="100">{{ \Carbon\Carbon::parse($transaction->date)->translatedFormat('d F Y') }}</td>
                    <td width="130">{{ $transaction->kasir_name }}</td>
                    <td width="200">{{ $transaction->product->name }}</td>
                    <td width="70" align="right">
                        {{ 'Rp' . number_format($transaction->product->price, 0, '', '.') }}</td>
                    <td width="50" align="center">{{ $transaction->qty }}</td>
                    <td width="80" align="right">{{ 'Rp' . number_format($transaction->total, 0, '', '.') }}</td>
                </tr>
            @empty
                {{-- jika data tidak ada, tampilkan pesan data tidak tersedia --}}
                <tr>
                    <td align="center" colspan="7">No data available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Total Keseluruhan --}}
    @if ($totalOverall > 0)
        <div style="margin-top: 10px; text-align: right;">
            <strong>Total Keseluruhan: {{ 'Rp' . number_format($totalOverall, 0, '', '.') }}</strong>
        </div>
    @endif

    @php
        use Carbon\Carbon;

        // Set the locale to Indonesian
        Carbon::setLocale('id');

        // Set the timezone to WIB (Indonesia Western Time)
        $date = Carbon::now('Asia/Jakarta');
    @endphp

    <div style="margin-top: 50px; text-align: right">
        Indramayu, {{ $date->translatedFormat('d F Y') }}
    </div>
</body>

</html>
