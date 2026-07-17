<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <div class="row">
            <div class="col-md-8">
                <form action="{{ route('transaction.store') }}" method="post">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label required">Jenis Transaksi</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" id="type_in" value="in" {{ old('type') == 'in' ? 'checked' : '' }} required>
                                <label class="form-check-label text-success fw-bold" for="type_in">
                                    <i class="bi bi-box-arrow-in-down"></i> Barang Masuk (In)
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" id="type_out" value="out" {{ old('type') == 'out' ? 'checked' : '' }}>
                                <label class="form-check-label text-danger fw-bold" for="type_out">
                                    <i class="bi bi-box-arrow-up"></i> Barang Keluar (Out)
                                </label>
                            </div>
                        </div>
                        @error('type')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3" id="supplier_container" style="display: none;">
                        <label for="supplier_id" class="form-label required">Supplier</label>
                        <select class="form-select select2-default @error('supplier_id') is-invalid @enderror" id="supplier_id" name="supplier_id">
                            <option value="">Pilih Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" @selected(old('supplier_id') == $supplier->id)>{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Wajib diisi untuk Barang Masuk.</small>
                    </div>

                    <div class="mb-3">
                        <label for="item_id" class="form-label required">Barang (Item)</label>
                        <select class="form-select select2-default @error('item_id') is-invalid @enderror" id="item_id" name="item_id" required>
                            <option value="">Pilih Barang</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}" data-stock="{{ $item->current_stock }}" @selected(old('item_id') == $item->id)>
                                    [{{ $item->sku }}] {{ $item->name }} (Sisa: {{ $item->current_stock }})
                                </option>
                            @endforeach
                        </select>
                        @error('item_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="quantity" class="form-label required">Kuantitas</label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity"
                                name="quantity" value="{{ old('quantity', 1) }}" min="1" required>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="transaction_date" class="form-label required">Tanggal Transaksi</label>
                            <input type="datetime-local" class="form-control @error('transaction_date') is-invalid @enderror" id="transaction_date"
                                name="transaction_date" value="{{ old('transaction_date', now()->format('Y-m-d\TH:i')) }}" required>
                            @error('transaction_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="reference_number" class="form-label">Nomor Referensi/Faktur</label>
                        <input type="text" class="form-control @error('reference_number') is-invalid @enderror" id="reference_number"
                            name="reference_number" value="{{ old('reference_number') }}" placeholder="Opsional">
                        @error('reference_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan Tambahan</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <button class="btn btn-primary" type="submit">Catat Transaksi</button>
                        <a href="{{ route('transaction.index') }}" class="btn btn-danger">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            function toggleSupplier() {
                if ($('#type_in').is(':checked')) {
                    $('#supplier_container').slideDown();
                    $('#supplier_id').attr('required', true);
                } else {
                    $('#supplier_container').slideUp();
                    $('#supplier_id').attr('required', false);
                    $('#supplier_id').val('').trigger('change');
                }
            }

            // On load
            toggleSupplier();

            // On change
            $('input[name="type"]').change(function() {
                toggleSupplier();
            });
        });
    </script>
    @endpush
</x-app>
