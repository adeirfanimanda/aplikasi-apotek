<x-app-layout>
    {{-- Page Title --}}
    <x-page-title>Tambah Pengguna</x-page-title>

    <div class="bg-white rounded-2 shadow-sm p-4 mb-4">
        <form action="{{ route('admin.pengguna.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name"
                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email"
                        class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Kata Sandi <span class="text-danger">*</span></label>
                    <input type="password" name="password" id="password"
                        class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi <span
                            class="text-danger">*</span></label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                        required>
                </div>

                <div class="mb-3">
                    <label for="roles" class="form-label">Role <span class="text-danger">*</span></label>
                    <select name="roles" id="roles" class="form-select @error('roles') is-invalid @enderror"
                        required>
                        <option value="" disabled selected>- Pilih Role -</option>
                        <option value="admin">Admin</option>
                        <option value="kasir">Kasir</option>
                    </select>
                    @error('roles')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-grid gap-2 d-sm-flex justify-content-md-start pt-1">
                <button type="submit" class="btn btn-primary py-2 px-4">Simpan</button>
                <a href="{{ route('admin.pengguna.index') }}" class="btn btn-danger py-2 px-4">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
