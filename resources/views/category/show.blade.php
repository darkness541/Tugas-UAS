<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered">
            <tr>
                <th width="30%">Nama Kategori</th>
                <td>{{ $category->name }}</td>
            </tr>
            <tr>
                <th>Deskripsi</th>
                <td>{{ $category->description ?: '-' }}</td>
            </tr>
        </table>
    </div>
</div>
