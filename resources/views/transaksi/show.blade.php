<!DOCTYPE html>
<html>
<head>
    <title>Transaction Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .receipt {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .receipt-header, .receipt-footer {
            text-align: center;
        }
        .receipt-details {
            margin-top: 20px;
        }
        .receipt-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .receipt-details table, .receipt-details th, .receipt-details td {
            border: 1px solid #ddd;
        }
        .receipt-details th, .receipt-details td {
            padding: 8px;
            text-align: left;
        }
        .edit-button {
            display: block;
            width: 100%;
            margin-top: 20px;
            text-align: center;
        }
        .edit-button form {
            display: inline;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="receipt-header">
            <h2>Warung Swalayan</h2>
            <p>Jl. Contoh Alamat No. 123</p>
            <p>Telp: (021) 12345678</p>
        </div>
        <div class="receipt-details">
            <p><strong>Transaction ID:</strong> {{ $transaksi->id }}</p>
            <p><strong>No Struk:</strong> {{ $transaksi->no_struk }}</p>
            <p><strong>Date:</strong> {{ $transaksi->tgl_struk }}</p>
            <p><strong>Time:</strong> {{ $transaksi->jam_belanja }}</p>
            <p><strong>Cashier:</strong> {{ $transaksi->kasir->name }}</p>
            <p><strong>Member:</strong> {{ $transaksi->member->name }}</p>
            <p><strong>Total Items:</strong> {{ $transaksi->total_item }}</p>
            <p><strong>Total Quantity:</strong> {{ $transaksi->total_quantitas }}</p>
            <p><strong>Sub Total:</strong> {{ $transaksi->sub_total }}</p>
            <p><strong>Payment:</strong> {{ $transaksi->bayar }}</p>
            <p><strong>Change:</strong> {{ $transaksi->kembalian }}</p>
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksi->items as $item)
                    <tr>
                        <td>{{ $item->nama_barang }}</td>
                        <td>{{ $item->kuantitas_barang }}</td>
                        <td>{{ $item->harga_barang }}</td>
                        <td>{{ $item->harga_total_barang }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <p><strong>Total Amount:</strong> {{ $transaksi->total_amount }}</p>
        </div>
        <div class="receipt-footer">
            <p>Thank you for your purchase!</p>
        </div>
        <div class="edit-button">
            <form action="{{ route('transaksi.edit', $transaksi->id) }}" method="GET">
                <button type="submit">Edit Transaction</button>
            </form>
        </div>
    </div>
</body>
</html>