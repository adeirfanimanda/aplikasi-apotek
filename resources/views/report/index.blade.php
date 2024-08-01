<x-app-layout>
    {{-- Page Title --}}
    <x-page-title>Laporan Transaksi</x-page-title>

    <div class="bg-white rounded-2 shadow-sm p-4 mb-4">
        {{-- info form --}}
        <div class="alert alert-primary mb-5" role="alert">
            <i class="ti ti-calendar-search fs-5 me-2"></i>Filter berdasarkan tanggal transaksi
        </div>
        {{-- form filter data --}}
        <form action="{{ route('report.filter') }}" method="GET" class="needs-validation" novalidate>
            <div class="row">
                <div class="col-lg-4 col-xl-3 mb-4 mb-lg-0">
                    <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                    <input type="date" name="start_date"
                        class="form-control @error('start_date') is-invalid @enderror"
                        value="{{ old('start_date', request('start_date')) }}" autocomplete="off">
                    {{-- pesan error untuk start date --}}
                    @error('start_date')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-lg-4 col-xl-3">
                    <label class="form-label">Tanggal Akhir <span class="text-danger">*</span></label>
                    <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror"
                        value="{{ old('end_date', request('end_date')) }}" autocomplete="off">
                    {{-- pesan error untuk end date --}}
                    @error('end_date')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <br>

            <div class="d-grid gap-3 d-sm-flex justify-content-md-start pt-1">
                {{-- button tampil data laporan --}}
                <button type="submit" class="btn btn-primary py-2 px-4">
                    Show<i class="ti ti-chevron-right align-middle ms-2"></i>
                </button>
            </div>
        </form>
    </div>

    @if (request(['start_date', 'end_date']))
        <div class="bg-white rounded-2 shadow-sm p-4 mb-5">
            <div class="d-flex flex-column flex-lg-row mb-4">
                <div class="flex-grow-1 d-flex align-items-center">
                    {{-- judul laporan --}}
                    <h6 class="mb-0">
                        <i class="ti ti-file-text fs-5 align-text-top me-1"></i>
                        Laporan Data Transaksi pada
                        {{ \Carbon\Carbon::parse(request('start_date'))->translatedFormat('d F Y') }} -
                        {{ \Carbon\Carbon::parse(request('end_date'))->translatedFormat('d F Y') }}
                    </h6>
                </div>
                <div class="d-grid gap-3 d-sm-flex mt-3 mt-lg-0">
                    {{-- button cetak laporan (export PDF) --}}
                    <a href="{{ route('report.print', [request('start_date'), request('end_date')]) }}" target="_blank"
                        class="btn btn-warning py-2 px-3">
                        <i class="ti ti-printer me-2"></i>Print
                    </a>
                </div>
            </div>

            <hr class="mb-4">

            {{-- tabel tampil data --}}
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" style="width:100%">
                    <thead>
                        <th class="text-center">NO</th>
                        <th class="text-center">TANGGAL</th>
                        <th class="text-center">KASIR</th>
                        <th class="text-center">OBAT</th>
                        <th class="text-center">HARGA</th>
                        <th class="text-center">QTY</th>
                        <th class="text-center">TOTAL</th>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @forelse ($transactions as $transaction)
                            {{-- jika data ada, tampilkan data --}}
                            <tr>
                                <td width="30" class="text-center">{{ $no++ }}</td>
                                <td width="100">
                                    {{ \Carbon\Carbon::parse($transaction->date)->translatedFormat('d F Y') }}
                                </td>
                                <td width="130">{{ $transaction->kasir_name }}</td>
                                <td width="170">{{ $transaction->product->name }}</td>
                                <td width="70" class="text-end">
                                    {{ 'Rp' . number_format($transaction->product->price, 0, '', '.') }}</td>
                                <td width="50" class="text-center">{{ $transaction->qty }}</td>
                                <td width="80" class="text-end">
                                    {{ 'Rp' . number_format($transaction->total, 0, '', '.') }}
                                </td>
                            </tr>
                        @empty
                            {{-- jika data tidak ada, tampilkan pesan data tidak tersedia --}}
                            <tr>
                                <td colspan="7">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <i class="ti ti-info-circle fs-5 me-2"></i>
                                        <div>No data available.</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</x-app-layout>
