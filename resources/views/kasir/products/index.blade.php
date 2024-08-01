<x-app-layout>
    {{-- Page Title --}}
    <x-page-title>Data Obat</x-page-title>

    <div class="bg-white rounded-2 shadow-sm p-4 mb-4">
        <div class="row">
            <div class="col-lg-7 col-xl-6">
                {{-- form pencarian --}}
                <form action="{{ route('kasir.products.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control form-search py-2"
                            value="{{ request('search') }}" placeholder="Cari obat..." autocomplete="off">
                        <button class="btn btn-primary py-2" type="submit">Cari</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2 shadow-sm pt-4 px-4 pb-3 mb-5">
        {{-- tabel tampil data --}}
        <div class="table-responsive mb-3">
            <table class="table table-bordered table-striped table-hover" style="width:100%">
                <thead>
                    <th class="text-center">NO</th>
                    <th class="text-center">KODE</th>
                    <th class="text-center">NAMA</th>
                    <th class="text-center">GAMBAR</th>
                    <th class="text-center">HARGA</th>
                    <th class="text-center">KATEGORI</th>
                    <th class="text-center">STOK</th>
                    <th class="text-center">SATUAN</th>
                    <th class="text-center">TANGGAL MASUK</th>
                    <th class="text-center">KADALUARSA</th>
                    <th class="text-center">KETERANGAN</th>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        {{-- jika data ada, tampilkan data --}}
                        <tr>
                            <td class="text-center">{{ ++$i }}</td>
                            <td class="text-center">{{ $product->kode_obat }}</td>
                            <td>{{ $product->name }}</td>
                            <td class="text-center">
                                <img src="{{ asset('/storage/products/' . $product->image) }}"
                                    class="img-thumbnail rounded-4" width="80" alt="Images">
                            </td>
                            <td class="text-end">{{ 'Rp' . number_format($product->price, 0, '', '.') }}
                            </td>
                            <td>{{ $product->category->name }}</td>
                            <td class="text-center">{{ $product->stok }}</td>
                            <td>{{ $product->satuan }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($product->tanggal_masuk)->translatedFormat('d F Y') }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($product->expired)->translatedFormat('d F Y') }}
                            </td>
                            <td class="text-center">
                                @php
                                    $currentDate = \Carbon\Carbon::now();
                                    $expiredDate = \Carbon\Carbon::parse($product->expired);
                                    $obatStatus = $product->stok > 0 ? 'Stok Tersedia' : 'Stok Habis';

                                    if ($expiredDate < $currentDate) {
                                        $obatStatus = 'Obat Kadaluarsa';
                                    }
                                @endphp
                                <span
                                    class="badge
                                    @if ($obatStatus == 'Obat Kadaluarsa') bg-danger
                                    @elseif ($obatStatus == 'Stok Habis') bg-warning
                                    @else bg-success @endif text-light">
                                    {{ $obatStatus }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        {{-- jika data tidak ada, tampilkan pesan data tidak tersedia --}}
                        <tr>
                            <td colspan="11">
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
        {{-- pagination --}}
        <div class="pagination-links">{{ $products->links() }}</div>
    </div>
</x-app-layout>
