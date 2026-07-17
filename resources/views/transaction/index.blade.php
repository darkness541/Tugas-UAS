<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        <div class="row mb-3">
            <div class="col-md-6">
                <a class="btn btn-primary" href="{{ route('transaction.create') }}" role="button">Catat Transaksi</a>
            </div>
            <div class="col-md-6">
                <form action="{{ route('transaction.index') }}" method="GET" class="d-flex justify-content-end">
                    <select name="type" class="form-select w-auto me-2" onchange="this.form.submit()">
                        <option value="">-- Semua Jenis --</option>
                        <option value="in" {{ $selected_type == 'in' ? 'selected' : '' }}>Barang Masuk (Inbound)</option>
                        <option value="out" {{ $selected_type == 'out' ? 'selected' : '' }}>Barang Keluar (Outbound)</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th scope="col">Tgl Transaksi</th>
                        <th scope="col">Referensi</th>
                        <th scope="col">Jenis</th>
                        <th scope="col">Barang</th>
                        <th scope="col">Kuantitas</th>
                        <th scope="col">Pencatat</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->transaction_date->format('d/m/Y H:i') }}</td>
                            <td>{{ $transaction->reference_number ?: '-' }}</td>
                            <td>
                                @if($transaction->type == 'in')
                                    <span class="badge bg-success">Masuk</span>
                                @else
                                    <span class="badge bg-danger">Keluar</span>
                                @endif
                            </td>
                            <td>{{ $transaction->item->name }}</td>
                            <td>
                                {{ $transaction->type == 'in' ? '+' : '-' }}{{ $transaction->quantity }}
                            </td>
                            <td>{{ $transaction->user->name }}</td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm btn-detail"
                                    data-route="{{ route('transaction.show', $transaction) }}">
                                    <i class='bx bx-show'></i> Detail
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    @push('modals')
        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Resi Transaksi</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modal-detail">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endpush

    @push('scripts')
        <script>
            $('#data-table').on('click', '.btn-detail', function() {
                Swal.fire({
                    title: 'Memuat...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $('#modal-detail').load($(this).data('route'), function(response, status, xhr) {
                    if (status == "success") {
                        setTimeout(() => {
                            Swal.close();
                            $('#detailModal').modal('show');
                        }, 1000);
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: "Gagal memuat data",
                            icon: "error"
                        });
                    }
                });
            })
        </script>
    @endpush

</x-app>
