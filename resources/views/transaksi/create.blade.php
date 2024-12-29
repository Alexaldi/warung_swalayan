<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Transaksi Baru</title>
    <!-- Bootstrap CSS untuk styling form -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-4">
        <!-- Card utama yang membungkus form transaksi -->
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Tambah Transaksi Baru</h4>
            </div>
            <div class="card-body">
                <!-- Form transaksi dengan route ke method store -->
                <form action="{{ route('transaksi.store') }}" method="POST" id="transactionForm">
                    @csrf
                    <!-- Hidden input untuk menyimpan nomor struk -->
                    <input type="hidden" name="no_struk" value="{{ $noStruk }}">

                    <!-- Bagian informasi struk dan kasir -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">No. Struk</label>
                            <!-- Field no struk readonly karena di-generate sistem -->
                            <input type="text" class="form-control" value="{{ $noStruk }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kasir</label>
                            <!-- Field kasir readonly, diambil dari user yang login -->
                            <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                        </div>
                    </div>

                    <!-- Bagian tanggal dan waktu transaksi -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Tanggal</label>
                            <!-- Field tanggal readonly, di-set oleh sistem -->
                            <input type="text" class="form-control" name="currentDate" value="{{ $currentDate }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jam</label>
                            <!-- Field jam readonly, di-set oleh sistem -->
                            <input type="text" class="form-control" name="currentTime" value="{{ $currentTime }}" readonly>
                        </div>
                    </div>

                    <!-- Dropdown pemilihan member -->
                    <div class="mb-4">
                        <label class="form-label">Member</label>
                        <select name="id_member" class="form-select" required>
                            <option value="">Pilih Member</option>
                            <!-- Loop untuk menampilkan semua member -->
                            @foreach($members as $member)
                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Container untuk item-item produk -->
                    <div id="itemsContainer">
                        <!-- Template row item produk -->
                        <div class="item-row mb-4">
                            <div class="row g-3 align-items-center">
                                <!-- Dropdown pemilihan produk -->
                                <div class="col-md-3">
                                    <label class="form-label">Produk</label>
                                    <select name="items[0][kode_barang]" class="form-select product-select" required>
                                        <option value="">Pilih Produk</option>
                                        <!-- Loop untuk menampilkan semua produk -->
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" 
                                                    data-harga="{{ $product->harga }}"
                                                    data-stok="{{ $product->stok }}">
                                                {{ $product->nama_barang }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Field harga produk (readonly) -->
                                <div class="col-md-2">
                                    <label class="form-label">Harga</label>
                                    <input type="text" class="form-control harga" value="" readonly>
                                </div>
                                <!-- Field kuantitas -->
                                <div class="col-md-2">
                                    <label class="form-label">Kuantitas</label>
                                    <input type="number" name="items[0][kuantitas]" class="form-control quantity" min="1" disabled required>
                                </div>
                                <!-- Field subtotal (readonly) -->
                                <div class="col-md-2">
                                    <label class="form-label">Subtotal</label>
                                    <input type="text" class="form-control subtotal" readonly>
                                </div>
                                <!-- Tombol hapus item -->
                                <div class="col-md-1">
                                    <label class="form-label">&nbsp;</label>
                                    <button type="button" class="btn btn-danger remove-item d-none w-100">Hapus</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol untuk menambah item baru -->
                    <button type="button" class="btn btn-success mb-4 me-2" id="addItem">
                        <i class="bi bi-plus-circle"></i> Tambah Item
                    </button>

                    <!-- Bagian total-total transaksi -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Total Item</label>
                            <input type="text" id="totalItem" name="totalItem" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Total Kuantitas</label>
                            <input type="text" id="totalKuantitas" name="totalKuantitas" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Sub Total</label>
                            <input type="text" id="subTotal" name="subTotal" class="form-control" readonly>
                        </div>
                    </div>

                    <!-- Bagian pembayaran -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Bayar</label>
                            <input type="number" name="bayar" id="bayar" class="form-control" required>
                            <!-- Alert untuk pembayaran kurang -->
                            <div id="bayarAlert" class="alert alert-danger mt-2 d-none">
                                Pembayaran kurang dari total belanja
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kembalian</label>
                            <input type="text" name='kembalian' id="kembalian" class="form-control" readonly>
                        </div>
                    </div>

                    <!-- Tombol submit transaksi -->
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Transaksi
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Dependencies JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    
    <!-- Script untuk menangani logika form -->
    <script>
    // Counter untuk menghitung jumlah item
    let itemCount = 1;
    
    // Handler untuk tombol tambah item
    $('#addItem').click(function () {
        // Clone row item pertama
        const newRow = $('.item-row').first().clone();
        // Update nama field untuk item baru
        newRow.find('select').attr('name', `items[${itemCount}][kode_barang]`).val('');
        newRow.find('.quantity').attr('name', `items[${itemCount}][kuantitas]`).val('').prop('disabled', true);
        newRow.find('.subtotal').val('');

        // Tambahkan row baru ke container
        $('#itemsContainer').append(newRow);
        itemCount++;
        toggleRemoveButton();
        calculateTotals();
    });

    // Handler untuk tombol hapus item
    $(document).on('click', '.remove-item', function () {
        if ($('.item-row').length > 1) {
            $(this).closest('.item-row').remove();
            itemCount--;
            toggleRemoveButton();
            calculateTotals();
        }
    });

    // Handler untuk perubahan produk yang dipilih
    $(document).on('change', '.product-select', function () {
        const row = $(this).closest('.item-row');
        const product = $(this).find('option:selected');
        const harga = product.data('harga') || 0;

        // Update harga di row
        row.find('.harga').val(harga.toLocaleString('id-ID'));

        // Enable/disable input kuantitas
        const productSelected = !!product.val();
        row.find('.quantity').prop('disabled', !productSelected).val('');
        row.find('.subtotal').val('');
        calculateTotals();
    });

    // Handler untuk input kuantitas
    $(document).on('input', '.quantity', function () {
        const row = $(this).closest('.item-row');
        const product = row.find('.product-select option:selected');
        const quantity = parseFloat($(this).val()) || 0;

        // Hitung subtotal jika produk dipilih dan kuantitas valid
        if (product.val() && quantity) {
            const harga = parseFloat(product.data('harga'));
            const subtotal = harga * quantity;
            row.find('.subtotal').val(subtotal.toLocaleString('id-ID'));
            calculateTotals();
        }
    });

    // Handler untuk input pembayaran
    $('#bayar').on('input', function () {
        const bayar = parseFloat($(this).val()) || 0;
        const subTotal = parseFloat($('#subTotal').val().replace(/\D/g, '')) || 0;
        const alertEl = $('#bayarAlert');
    
        if (bayar > 0) {
            // Hitung dan tampilkan kembalian
            const kembalian = bayar - subTotal;
            
            // Tampilkan alert jika pembayaran kurang
            if (bayar < subTotal) {
                $(this).addClass('is-invalid');
                alertEl.removeClass('d-none');
                $('#kembalian').val('');
            } else {
                const kembalian = bayar - subTotal;
                $('#kembalian').val(kembalian.toLocaleString('id-ID'));
                $(this).removeClass('is-invalid');
                $(this).attr('placeholder', 'Masukkan jumlah pembayaran');
                alertEl.addClass('d-none');
            }
        } else {
            $('#kembalian').val('');
            $(this).removeClass('is-invalid');
            alertEl.addClass('d-none');
        }
    });

    // Fungsi untuk menghitung total-total
    function calculateTotals() {
        let totalItem = $('.item-row').length;
        let totalKuantitas = 0;
        let subTotal = 0;

        // Hitung total dari setiap row
        $('.item-row').each(function () {
            const quantity = parseFloat($(this).find('.quantity').val()) || 0;
            const subtotalStr = $(this).find('.subtotal').val();
            const subtotal = parseFloat(subtotalStr.replace(/\D/g, '')) || 0;

            totalKuantitas += quantity;
            subTotal += subtotal;
        });

        // Update field total
        $('#totalItem').val(totalItem);
        $('#totalKuantitas').val(totalKuantitas);
        $('#subTotal').val(subTotal.toLocaleString('id-ID'));
    }

    // Fungsi untuk toggle tombol hapus
    function toggleRemoveButton() {
        $('.remove-item').toggleClass('d-none', $('.item-row').length <= 1);
    }

    // Inisialisasi tombol hapus
    toggleRemoveButton();
    </script>
</body>
</html>