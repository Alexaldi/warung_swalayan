<div class="container">
    <h1>Edit Transaksi</h1>
    <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="id_member">Pelanggan</label>
            <select name="id_member" id="id_member" class="form-control">
                @foreach($members as $id => $name)
                    <option value="{{ $id }}" 
                        {{ $transaksi->id_member == $id ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Transaksi</button>
    </form>
</div>