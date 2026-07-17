<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered">
            <tr>
                <th width="30%">Nama Supplier</th>
                <td>{{ $supplier->name }}</td>
            </tr>
            <tr>
                <th>Kontak (PIC)</th>
                <td>{{ $supplier->contact_person ?: '-' }}</td>
            </tr>
            <tr>
                <th>Telepon</th>
                <td>{{ $supplier->phone ?: '-' }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $supplier->address ?: '-' }}</td>
            </tr>
        </table>
    </div>
</div>
