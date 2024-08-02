<x-app-layout>
    {{-- Page Title --}}
    <x-page-title>Dashboard</x-page-title>

    <div class="row mb-3">
        {{-- menampilkan informasi jumlah data Pengguna --}}
        <div class="col-lg-6 col-xl-3">
            <a href="{{ route('admin.pengguna.index') }}" class="text-decoration-none">
                <div class="bg-white rounded-2 shadow-sm p-4 p-lg-4-2 mb-4">
                    <div class="d-flex align-items-center justify-content-start">
                        <div class="text-muted me-4">
                            <i class="ti ti-users fs-1 bg-warning text-white rounded-2 p-2"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1">Pengguna</p>
                            {{-- tampilkan data --}}
                            <h5 class="fw-bold mb-0" style="color: #697A8D;">{{ $totalUser }}</h5>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- menampilkan informasi jumlah data Kategori --}}
        <div class="col-lg-6 col-xl-3">
            <a href="{{ route('categories.index') }}" class="text-decoration-none">
                <div class="bg-white rounded-2 shadow-sm p-4 mb-4">
                    <div class="d-flex align-items-center justify-content-start">
                        <div class="me-4">
                            <i class="ti ti-category fs-1 bg-primary-2 text-white rounded-2 p-2"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1">Kategori</p>
                            {{-- tampilkan data --}}
                            <h5 class="fw-bold mb-0" style="color: #697A8D;">{{ $totalCategory }}</h5>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- menampilkan informasi jumlah data Product --}}
        <div class="col-lg-6 col-xl-3">
            <a href="{{ route('products.index') }}" class="text-decoration-none">
                <div class="bg-white rounded-2 shadow-sm p-4 p-lg-4-2 mb-4">
                    <div class="d-flex align-items-center justify-content-start">
                        <div class="me-4">
                            <i class="ti ti-copy fs-1 bg-success text-white rounded-2 p-2"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1">Obat</p>
                            {{-- tampilkan data --}}
                            <h5 class="fw-bold mb-0" style="color: #697A8D;">{{ $totalProduct }}</h5>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- menampilkan informasi jumlah data Transaction --}}
        <div class="col-lg-6 col-xl-3">
            <a href="{{ route('transactions.index') }}" class="text-decoration-none">
                <div class="bg-white rounded-2 shadow-sm p-4 p-lg-4-2 mb-4">
                    <div class="d-flex align-items-center justify-content-start">
                        <div class="text-muted me-4">
                            <i class="ti ti-folders fs-1 bg-info text-white rounded-2 p-2"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1">Transaksi</p>
                            {{-- tampilkan data --}}
                            <h5 class="fw-bold mb-0" style="color: #697A8D;">{{ $totalTransaction }}</h5>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- menampilkan informasi product terlaris --}}
    <div class="bg-white rounded-2 shadow-sm pt-4 px-4 pb-3 mb-5">
        {{-- judul --}}
        <h6 class="mb-0">
            <i class="ti ti-folder-star fs-5 align-text-top me-1"></i>
            5 Obat Terlaris
        </h6>

        <br>

        {{-- tabel tampil data --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" style="width:100%">
                <thead>
                    <th class="text-center">GAMBAR</th>
                    <th class="text-center">KODE</th>
                    <th class="text-center">NAMA</th>
                    <th class="text-center">HARGA</th>
                    <th class="text-center">TERJUAL</th>
                </thead>
                <tbody>
                    @forelse ($transactions as $transaction)
                        {{-- jika data ada, tampilkan data --}}
                        <tr>
                            <td width="50" class="text-center">
                                <img src="{{ asset('/storage/products/' . $transaction->product->image) }}"
                                    class="img-thumbnail rounded-4" width="80" alt="Images">
                            </td>
                            <td class="text-center" width="50">{{ $transaction->product->kode_obat }}</td>
                            <td width="200">{{ $transaction->product->name }}</td>
                            <td width="100" class="text-end">
                                {{ 'Rp' . number_format($transaction->product->price, 0, '', '.') }}</td>
                            <td width="80" class="text-center">{{ $transaction->transactions_sum_qty }}</td>
                        </tr>
                    @empty
                        {{-- jika data tidak ada, tampilkan pesan data tidak tersedia --}}
                        <tr>
                            <td colspan="6">
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
</x-app-layout>
