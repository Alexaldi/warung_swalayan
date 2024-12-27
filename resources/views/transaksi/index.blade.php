<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Transaksi</title>
</head>
<body>
    <h1>Daftar Transaksi</h1>
    <table border="1">
        <thead>
            <tr>
                <th>No Struk</th>
                <th>Tanggal</th>
                <th>Jam Belanja</th>
                <th>Kasir</th>
                <th>Member</th>
                <th>Total Item</th>
                <th>Total Kuantitas</th>
                <th>Sub Total</th>
                <th>Bayar</th>
                <th>Kembalian</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi as $item)
                <tr>
                    <td>{{ $item->no_struk }}</td>
                    <td>{{ $item->tgl_struk }}</td>
                    <td>{{ $item->jam_belanja }}</td>
                    <td>{{ $item->kasir->name ?? 'N/A' }}</td> <!-- Menampilkan nama kasir -->
                    <td>{{ $item->member->name ?? 'N/A' }}</td> <!-- Menampilkan nama member -->
                    <td>{{ $item->total_item }}</td>
                    <td>{{ $item->total_quantitas }}</td>
                    <td>{{ number_format($item->sub_total, 2) }}</td>
                    <td>{{ number_format($item->bayar, 2) }}</td>
                    <td>{{ number_format($item->kembalian, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    {{ $transaksi->links() }}
</body>
</html>