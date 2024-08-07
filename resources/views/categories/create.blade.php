<x-app-layout>
    {{-- Page Title --}}
    <x-page-title>Tambah Bentuk Kesediaan</x-page-title>

    <div class="bg-white rounded-2 shadow-sm p-4 mb-5">
        {{-- form add data --}}
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="mb-3">
                    <label class="form-label">Nama <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" autocomplete="off">
                    {{-- pesan error untuk name --}}
                    @error('name')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="d-grid gap-2 d-sm-flex justify-content-md-start pt-1">
                {{-- button simpan data --}}
                <button type="submit" class="btn btn-primary py-2 px-4">Simpan</button>
                {{-- button kembali ke halaman index --}}
                <a href="{{ route('categories.index') }}" class="btn btn-danger py-2 px-4">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
