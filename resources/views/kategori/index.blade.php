<div class="container">
    <h1>Daftar Kategori</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kategoris as $index => $category)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $category->nama_kategori }}</td>
                <td>
                    <a href="{{ route('kategori.edit', $category->id) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('kategori.destroy', $category->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="container">
    <a href="{{ route('kategori.create') }}" class="btn btn-success">Tambah Kategori</a>
</div>
