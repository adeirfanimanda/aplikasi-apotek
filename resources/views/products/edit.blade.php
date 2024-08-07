<x-app-layout>
    {{-- Page Title --}}
    <x-page-title>Edit Obat</x-page-title>

    <div class="bg-white rounded-2 shadow-sm p-4 mb-5">
        {{-- form edit data --}}
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-7">
                    <div class="mb-3 pe-xl-3">
                        <label class="form-label">Kode <span class="text-danger">*</span></label>
                        <input type="text" name="kode_obat"
                            class="form-control @error('kode_obat') is-invalid @enderror"
                            value="{{ old('kode_obat', $product->kode_obat) }}" autocomplete="off">
                        {{-- pesan error untuk kode_obat --}}
                        @error('kode_obat')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3 pe-xl-3">
                        <label class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $product->name) }}" autocomplete="off">
                        {{-- pesan error untuk name --}}
                        @error('name')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3 pe-xl-3">
                        <label class="form-label">Harga <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" name="price"
                                class="form-control mask-number @error('price') is-invalid @enderror"
                                value="{{ old('price', number_format($product->price, 0, '', '.')) }}"
                                autocomplete="off">
                        </div>
                        {{-- pesan error untuk price --}}
                        @error('price')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3 pe-xl-3">
                        <label class="form-label">Bentuk Kesediaan <span class="text-danger">*</span></label>
                        <select name="category"
                            class="form-select select2-single @error('category') is-invalid @enderror"
                            autocomplete="off">
                            <option disabled value="">- Pilih bentuk kesediaan -</option>
                            @foreach ($categories as $category)
                                <option {{ old('category', $product->category_id) == $category->id ? 'selected' : '' }}
                                    value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        {{-- pesan error untuk category --}}
                        @error('category')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3 pe-xl-3">
                        <label class="form-label">Stok <span class="text-danger">*</span></label>
                        <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror"
                            value="{{ old('stok', $product->stok) }}" autocomplete="off">
                        {{-- pesan error untuk stok --}}
                        @error('stok')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3 pe-xl-3">
                        <label class="form-label">Golongan <span class="text-danger">*</span></label>
                        <select name="satuan" class="form-select @error('satuan') is-invalid @enderror"
                            autocomplete="off">
                            <option selected disabled value="">- Pilih golongan -</option>
                            <option value="Tablet" {{ old('satuan', $product->satuan) == 'Tablet' ? 'selected' : '' }}>
                                Tablet</option>
                            <option value="Strip" {{ old('satuan', $product->satuan) == 'Strip' ? 'selected' : '' }}>
                                Strip</option>
                            <option value="Sirup Botol"
                                {{ old('satuan', $product->satuan) == 'Sirup Botol' ? 'selected' : '' }}>
                                Sirup Botol</option>
                            <option value="Salep Tube"
                                {{ old('satuan', $product->satuan) == 'Salep Tube' ? 'selected' : '' }}>
                                Salep Tube
                            </option>
                            <option value="Tetes Mata Botol"
                                {{ old('satuan', $product->satuan) == 'Tetes Mata Botol' ? 'selected' : '' }}>
                                Tetes Mata Botol</option>
                            <option value="Alat" {{ old('satuan', $product->satuan) == 'Alat' ? 'selected' : '' }}>
                                Alat</option>
                            <option value="Pcs" {{ old('satuan', $product->satuan) == 'Pcs' ? 'selected' : '' }}>
                                Pcs
                            </option>
                        </select>
                        {{-- pesan error untuk satuan --}}
                        @error('satuan')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3 pe-xl-3">
                        <label class="form-label">Tanggal Masuk <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_masuk"
                            class="form-control @error('tanggal_masuk') is-invalid @enderror"
                            value="{{ old('tanggal_masuk', $product->tanggal_masuk) }}" autocomplete="off">
                        {{-- pesan error untuk tanggal_masuk --}}
                        @error('tanggal_masuk')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3 pe-xl-3">
                        <label class="form-label">Kadaluarsa <span class="text-danger">*</span></label>
                        <input type="date" name="expired" class="form-control @error('expired') is-invalid @enderror"
                            value="{{ old('expired', $product->expired) }}" autocomplete="off">
                        {{-- pesan error untuk expired --}}
                        @error('expired')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="mb-3 ps-xl-3">
                        <label class="form-label">Gambar</label>
                        <input type="file" accept=".jpg, .jpeg, .png" name="image" id="image"
                            class="form-control @error('image') is-invalid @enderror" autocomplete="off">
                        {{-- pesan error untuk image --}}
                        @error('image')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                        {{-- view image --}}
                        <div class="mt-4">
                            <img id="imagePreview" src="{{ asset('/storage/products/' . $product->image) }}"
                                class="img-thumbnail rounded-4 shadow-sm" width="50%" alt="Image">
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2 d-sm-flex justify-content-md-start pt-1">
                {{-- button update data --}}
                <button type="submit" class="btn btn-primary py-2 px-4">Update</button>
                {{-- button kembali ke halaman index --}}
                <a href="{{ route('products.index') }}" class="btn btn-danger py-2 px-4">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
