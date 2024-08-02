<x-app-layout>
    {{-- Page Title --}}
    <x-page-title>Edit Transaksi</x-page-title>

    <div class="bg-white rounded-2 shadow-sm p-4 mb-5">
        {{-- form edit data --}}
        <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="mb-3">
                    <div class="mb-3">
                        <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="date" class="form-control @error('date') is-invalid @enderror"
                            value="{{ old('date', $transaction->date) }}" autocomplete="off">
                        {{-- pesan error untuk date --}}
                        @error('date')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kasir <span class="text-danger">*</span></label>
                        <input type="text" name="kasir_name" class="form-control" value="{{ Auth::user()->name }}"
                            readonly>
                        {{-- pesan error untuk kasir --}}
                        @error('kasir_name')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Obat <span class="text-danger">*</span></label>
                        <select id="product" name="product"
                            class="form-select select2-single @error('product') is-invalid @enderror"
                            autocomplete="off">
                            <option disabled value="">- Pilih obat -</option>
                            @foreach ($products as $product)
                                <option {{ old('product', $transaction->product_id) == $product->id ? 'selected' : '' }}
                                    value="{{ $product->id }}"
                                    data-price="{{ number_format($product->price, 0, '', '.') }}"
                                    data-stok="{{ $product->stok }}">
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                        {{-- pesan error untuk product --}}
                        @error('product')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Harga <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" id="price" name="price"
                                class="form-control mask-number @error('price') is-invalid @enderror"
                                value="{{ old('price', number_format($transaction->product->price, 0, '', '.')) }}"
                                readonly>
                        </div>
                        {{-- pesan error untuk price --}}
                        @error('price')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Stok Tersedia <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" id="stok" name="stok"
                                class="form-control mask-number @error('stok') is-invalid @enderror"
                                value="{{ old('stok', $transaction->product->stok) }}" readonly>
                        </div>
                        {{-- pesan error untuk stok --}}
                        @error('stok')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Qty <span class="text-danger">*</span></label>
                        <input type="number" id="qty" name="qty"
                            class="form-control @error('qty') is-invalid @enderror"
                            value="{{ old('qty', $transaction->qty) }}" autocomplete="off">
                        {{-- pesan error untuk qty --}}
                        @error('qty')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Total <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" id="total" name="total"
                                class="form-control mask-number @error('total') is-invalid @enderror"
                                value="{{ old('total', number_format($transaction->total, 0, '', '.')) }}" readonly>
                        </div>
                        {{-- pesan error untuk total --}}
                        @error('total')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="d-grid gap-2 d-sm-flex justify-content-md-start pt-1">
                    {{-- button update data --}}
                    <button type="submit" class="btn btn-primary py-2 px-4">Update</button>
                    {{-- button kembali ke halaman index --}}
                    <a href="{{ route('transactions.index') }}" class="btn btn-danger py-2 px-4">Batal</a>
                </div>
        </form>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            // Menampilkan data product dari select box ke textfield
            $('#product').change(function() {
                // mengambil data dari selected option
                var price = $(this).children('option:selected').data('price');
                var stok = $(this).children('option:selected').data('stok');
                // tampilkan data
                $('#price').val(price);
                $('#stok').val(stok);
                // reset data
                $('#qty').val('');
                $('#total').val(0);
            });

            // menghitung total
            $('#qty').keyup(function() {
                // mengambil data dari form entri
                var price = $('#price').val().replace(/\./g, '');
                var qty = $('#qty').val();

                // mengecek input data
                // jika data product belum diisi
                if (price == "") {
                    // tampilkan pesan
                    $.notify({
                        title: '<h6 class="fw-bold mb-1"><i class="ti ti-circle-x-filled fs-5 align-text-top me-2"></i>Error!</h6>',
                        message: 'The Price field is required.',
                    }, {
                        type: 'danger',
                        delay: 500,
                    });
                    // reset input qty
                    $('#qty').val('');
                    // total stok kosong
                    var total = "";
                }
                // jika qty belum diisi
                else if (qty == "") {
                    // total stok kosong
                    var total = "";
                }
                // jika qty diisi <= 0
                else if (qty <= 0) {
                    // tampilkan pesan
                    $.notify({
                        title: '<h6 class="fw-bold mb-1"><i class="ti ti-circle-x-filled fs-5 align-text-top me-2"></i>Error!</h6>',
                        message: 'The Qty field must be filled with positive integers.'
                    }, {
                        type: 'danger',
                        delay: 500
                    });
                    // reset input qty
                    $('#qty').val('');
                    // total stok kosong
                    var total = "";
                }
                // jika data sudah diisi
                else {
                    // hitung total
                    var total = eval(price) * eval(qty);
                }

                // format number
                var result = total.toLocaleString('id-ID');
                // tampilkan total
                $('#total').val(result);
            });
        });
    </script>
</x-app-layout>
