<x-app-layout>
    {{-- Page Title --}}
    <x-page-title>Edit Pengguna</x-page-title>

    <div class="bg-white rounded-2 shadow-sm p-4 mb-4">
        {{-- Formulir Edit Pengguna --}}
        <form action="{{ route('admin.pengguna.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nama <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="roles" class="form-label">Role <span class="text-danger">*</span></label>
                <select name="roles" id="roles" class="form-select @error('roles') is-invalid @enderror" required>
                    <option value="" disabled selected>- Pilih Role -</option>
                    <option value="admin" {{ old('roles', $user->roles ?? '') == 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>
                    <option value="kasir" {{ old('roles', $user->roles ?? '') == 'kasir' ? 'selected' : '' }}>
                        Kasir
                    </option>
                </select>
                @error('roles')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Kata Sandi</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                    placeholder="Isi jika ingin mengubah kata sandi">
                @error('password')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation"
                    class="form-control @error('password_confirmation') is-invalid @enderror">
                @error('password_confirmation')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-grid gap-2 d-sm-flex justify-content-md-start pt-1">
                <button type="submit" class="btn btn-primary py-2 px-4">Simpan</button>
                <a href="{{ route('admin.pengguna.index') }}" class="btn btn-danger py-2 px-4">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
