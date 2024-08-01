<x-app-layout>
    {{-- Page Title --}}
    <x-page-title>Data Pengguna</x-page-title>

    <div class="bg-white rounded-2 shadow-sm p-4 mb-4">
        <div class="row">
            <div class="d-grid d-lg-block col-lg-5 col-xl-6 mb-4 mb-lg-0">
                {{-- button form add data --}}
                <a href="{{ route('admin.pengguna.create') }}" class="btn btn-primary py-2 px-3">
                    <i class="ti ti-plus me-2"></i>Tambah Pengguna
                </a>
            </div>
            <div class="col-lg-7 col-xl-6">
                {{-- form pencarian --}}
                <form action="{{ route('admin.pengguna.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control form-search py-2"
                            value="{{ request('search') }}" placeholder="Cari pengguna..." autocomplete="off">
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
                    <th class="text-center">NAMA</th>
                    <th class="text-center">EMAIL</th>
                    <th class="text-center">ROLE</th>
                    <th class="text-center">AKSI</th>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        {{-- jika data ada, tampilkan data --}}
                        <tr>
                            <td width="10" class="text-center">{{ $loop->iteration }}</td>
                            <td width="150">{{ $user->name }}</td>
                            <td width="150">{{ $user->email }}</td>
                            <td width="10" class="text-center">
                                <span class="badge bg-primary">{{ $user->roles }}</span>
                            </td>
                            <td width="10" class="text-center">
                                {{-- button form edit data --}}
                                <a href="{{ route('admin.pengguna.edit', $user->id) }}"
                                    class="btn btn-primary btn-sm m-1" data-bs-tooltip="tooltip" data-bs-title="Edit">
                                    <i class="ti ti-edit"></i>
                                </a>
                                {{-- button modal hapus data --}}
                                <button type="button" class="btn btn-danger btn-sm m-1" data-bs-toggle="modal"
                                    data-bs-target="#modalDelete{{ $user->id }}" data-bs-tooltip="tooltip"
                                    data-bs-title="Hapus">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </td>
                        </tr>

                        {{-- Modal hapus data --}}
                        <div class="modal fade" id="modalDelete{{ $user->id }}" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDeleteLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">
                                            <i class="ti ti-trash me-2"></i> Konfirmasi
                                        </h1>
                                    </div>
                                    <div class="modal-body">
                                        {{-- informasi data yang akan dihapus --}}
                                        <p class="mb-2">
                                            Anda yakin ingin menghapus pengguna dengan nama <span
                                                class="fw-bold mb-2">{{ $user->name }}</span>?
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary py-2 px-4"
                                            data-bs-dismiss="modal">Batal</button>
                                        {{-- button hapus data --}}
                                        <form action="{{ route('admin.pengguna.destroy', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger py-2 px-4">
                                                Ya, Hapus!
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        {{-- jika data tidak ada, tampilkan pesan data tidak tersedia --}}
                        <tr>
                            <td colspan="5">
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
        <div class="pagination-links">{{ $users->links() }}</div>
    </div>
</x-app-layout>
