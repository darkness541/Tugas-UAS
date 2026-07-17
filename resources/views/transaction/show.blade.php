<div class="row">
    <div class="col-md-12">
        <h4 class="text-center mb-4">
            @if($transaction->type == 'in')
                <span class="text-success"><i class="bi bi-arrow-down-circle"></i> BUKTI BARANG MASUK</span>
            @else
                <span class="text-danger"><i class="bi bi-arrow-up-circle"></i> BUKTI BARANG KELUAR</span>
            @endif
        </h4>
        
        <table class="table table-bordered">
            <tr>
                <th width="35%" class="bg-light">ID Transaksi</th>
                <td>#{{ $transaction->id }}</td>
            </tr>
            <tr>
                <th class="bg-light">Waktu Transaksi</th>
                <td>{{ $transaction->transaction_date->format('l, d F Y H:i') }}</td>
            </tr>
            <tr>
                <th class="bg-light">Nomor Referensi</th>
                <td>{{ $transaction->reference_number ?: '-' }}</td>
            </tr>
            <tr>
                <th class="bg-light">Barang</th>
                <td><strong>[{{ $transaction->item->sku }}]</strong> {{ $transaction->item->name }}</td>
            </tr>
            <tr>
                <th class="bg-light">Kuantitas</th>
                <td>
                    <h5 class="mb-0 {{ $transaction->type == 'in' ? 'text-success' : 'text-danger' }}">
                        {{ $transaction->type == 'in' ? '+' : '-' }}{{ $transaction->quantity }}
                    </h5>
                </td>
            </tr>
            @if($transaction->type == 'in')
            <tr>
                <th class="bg-light">Supplier</th>
                <td>{{ $transaction->supplier->name ?? '-' }}</td>
            </tr>
            @endif
            <tr>
                <th class="bg-light">Pencatat (Petugas)</th>
                <td>{{ $transaction->user->name }}</td>
            </tr>
            <tr>
                <th class="bg-light">Catatan</th>
                <td>{{ $transaction->notes ?: '-' }}</td>
            </tr>
        </table>
    </div>
</div>
