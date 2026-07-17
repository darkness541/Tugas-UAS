<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered">
            <tr>
                <th width="35%">SKU (Kode Barang)</th>
                <td>{{ $item->sku }}</td>
            </tr>
            <tr>
                <th>Nama Barang</th>
                <td>{{ $item->name }}</td>
            </tr>
            <tr>
                <th>Kategori</th>
                <td>{{ $item->category->name ?? '-' }}</td>
            </tr>
            <tr>
                <th>Stok Saat Ini</th>
                <td>
                    {{ $item->current_stock }}
                    @if($item->current_stock <= $item->minimum_stock)
                        <span class="badge bg-danger ms-1">Low Stock</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Stok Minimum</th>
                <td>{{ $item->minimum_stock }}</td>
            </tr>
            <tr>
                <th>Harga (Rp)</th>
                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Dibuat Pada</th>
                <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <th>Terakhir Diperbarui</th>
                <td>{{ $item->updated_at->format('d/m/Y H:i') }}</td>
            </tr>
        </table>
    </div>
</div>
