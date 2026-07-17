<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-3"><i class='bx bx-filter-alt text-primary me-2'></i> Filter Laporan</h5>
            
            <form action="{{ route('report.index') }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small text-muted fw-bold">Dari Tanggal</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted fw-bold">Sampai Tanggal</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted fw-bold">Jenis Transaksi</label>
                        <select name="type" class="form-select">
                            <option value="">Semua Jenis</option>
                            <option value="in" {{ $selectedType == 'in' ? 'selected' : '' }}>Barang Masuk (In)</option>
                            <option value="out" {{ $selectedType == 'out' ? 'selected' : '' }}>Barang Keluar (Out)</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class='bx bx-search me-1'></i> Tampilkan Data
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Widgets -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card border-0 bg-success bg-opacity-10 shadow-sm">
                <div class="card-body">
                    <h6 class="text-success fw-bold"><i class='bx bx-down-arrow-circle me-1'></i> Total Barang Masuk</h6>
                    <h3 class="mb-0 text-success">{{ number_format($totalIn, 0, ',', '.') }} <small class="fs-6">Item</small></h3>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 bg-danger bg-opacity-10 shadow-sm">
                <div class="card-body">
                    <h6 class="text-danger fw-bold"><i class='bx bx-up-arrow-circle me-1'></i> Total Barang Keluar</h6>
                    <h3 class="mb-0 text-danger">{{ number_format($totalOut, 0, ',', '.') }} <small class="fs-6">Item</small></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Hasil Laporan Mutasi Stok</h5>
            
            <a href="{{ route('report.print', request()->all()) }}" target="_blank" class="btn btn-success">
                <i class='bx bx-printer me-1'></i> Cetak PDF/Print
            </a>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-3">Tgl & Waktu</th>
                            <th>No. Referensi</th>
                            <th>Barang (SKU)</th>
                            <th class="text-center">Jenis</th>
                            <th class="text-center">Kuantitas</th>
                            <th>Keterangan Tambahan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $t)
                            <tr>
                                <td class="ps-3">{{ \Carbon\Carbon::parse($t->transaction_date)->format('d/m/Y H:i') }}</td>
                                <td>{{ $t->reference_number ?: '-' }}</td>
                                <td>
                                    <strong>{{ $t->item->name }}</strong><br>
                                    <small class="text-muted">{{ $t->item->sku }}</small>
                                </td>
                                <td class="text-center">
                                    @if($t->type == 'in')
                                        <span class="badge bg-success">IN</span>
                                    @else
                                        <span class="badge bg-danger">OUT</span>
                                    @endif
                                </td>
                                <td class="text-center fw-bold {{ $t->type == 'in' ? 'text-success' : 'text-danger' }}">
                                    {{ $t->type == 'in' ? '+' : '-' }}{{ $t->quantity }}
                                </td>
                                <td>
                                    @if($t->type == 'in' && $t->supplier)
                                        <small class="d-block text-muted">Dari: {{ $t->supplier->name }}</small>
                                    @endif
                                    @if($t->notes)
                                        <small>{{ Str::limit($t->notes, 30) }}</small>
                                    @endif
                                    <div class="small text-muted mt-1">Dicatat oleh: {{ $t->user->name }}</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class='bx bx-folder-open fs-1 mb-2'></i>
                                    <p class="mb-0">Tidak ada data transaksi pada rentang waktu yang dipilih.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app>
