<?php

namespace App\Http\Controllers;

use App\Models\Detail_Transaksi;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
class TransactionController extends Controller
{
    //* Menampilakan Semua Transaksi 
    public function index() : View
    {
        //? get all transactions with kasir and member relationships
        $transaksi = Transaksi::with(['kasir:id,name', 'member:id,name'])
            ->latest()
            ->paginate(10);
        //? render view with transactions
        return view('transaksi.index', compact('transaksi'));
    }

    public function show(string $id): View{
        //? specify the ID of the transaction you want to display
        $transaksi = Transaksi::with(['kasir:id,name', 'member:id,name', 'items'])
            ->findOrFail($id);
        
        //? modify items to include nama_barang and harga
        $transaksi->items->transform(function ($item) {
            $item->nama_barang = $item->produk->nama_barang;
            $item->harga_barang = $item->produk->harga;
            return $item;
        });

        //? render view with transaction and its details
        return view('transaksi.show', compact('transaksi'));
    }

    public function edit(string $id): View
    {
        //? get the transaction by ID with kasir, member, and items relationships
        $transaksi = Transaksi::with(['member:id,name'])
            ->findOrFail($id);

        //? modify items to include nama_barang and harga
        $transaksi->items->transform(function ($item) {
            $item->nama_barang = $item->produk->nama_barang;
            $item->harga_barang = $item->produk->harga;
            return $item;
        });

        //? get all kasir and member from users table
        $members = \App\Models\User::where('role', 'pelanggan')->pluck('name', 'id');

        //? render view with transaction, kasir, and member for editing
        return view('transaksi.edit', compact('transaksi','members'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        //? validate request
        $request->validate([
            'id_member' => 'required|exists:users,id',
        ]);

        //? get the transaction by ID
        $transaksi = Transaksi::findOrFail($id);
        //? update the transaction
        $transaksi->update($request->only('id_member'));
        //? redirect to the transaction list page
        return redirect()->route('transaksi.index');
    }


    public function create()
    {
        // Mengambil daftar member (pelanggan)
        $members = User::where('role', 'pelanggan')->get();

        // Mengambil daftar produk
        $products = Produk::with('kategori')->get();

        // Generate no struk
        $lastTransaction = Transaksi::latest()->first();
        $lastNumber = $lastTransaction ? intval(substr($lastTransaction->no_struk, 3)) : 0;
        $newNumber = $lastNumber + 1;
        $noStruk = 'TC-' . str_pad($newNumber, 6, '0', STR_PAD_LEFT);

        // Tanggal dan waktu dengan zona waktu Indonesia
        $currentDate = Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $currentTime = Carbon::now('Asia/Jakarta')->format('H:i:s');

        return view('transaksi.create', compact('members', 'products', 'noStruk', 'currentDate', 'currentTime'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'no_struk' => 'required|string|unique:transaksis,no_struk',
            'id_member' => 'required|exists:users,id',
            'items' => 'required|array|min:1',
            'items.*.kode_barang' => 'required|exists:produks,id',
            'items.*.kuantitas' => 'required|numeric|min:1',
            'bayar' => 'required|numeric|min:0',
        ]);

        // Mulai transaksi untuk memastikan integritas data
        DB::beginTransaction();
        try {
            // Simpan data transaksi
            Transaksi::create([
                'no_struk' => $request->no_struk,
                'tgl_struk' => $request->currentDate,
                'jam_belanja' => $request->currentTime,
                'id_kasir' => Auth::id(), // Sesuaikan dengan field di model
                'id_member' => $request->id_member,
                'total_item' => $request->totalItem,
                'total_quantitas' => $request->totalKuantitas, // Sesuaikan dengan field di model
                'sub_total' => $this->cleanNumberFormat($request->subTotal),
                'bayar' => $this->cleanNumberFormat($request->bayar),
                'kembalian' => $this->cleanNumberFormat($request->kembalian),
            ]);

            // Simpan detail transaksi
            foreach ($request->items as $item) {
                // Mengambil harga produk
                $product = Produk::findOrFail($item['kode_barang']);
                $hargaTotalBarang = $product->harga * $item['kuantitas'];

                // Simpan detail transaksi
                Detail_Transaksi::create([
                    'no_struk' => $request->no_struk,
                    'kode_barang' => $item['kode_barang'],
                    'kuantitas_barang' => $item['kuantitas'], 
                    'harga_total_barang' => $hargaTotalBarang,
                ]);

                // Update stok produk (opsional)
                $product->decrement('stok', $item['kuantitas']);
            }

            // Commit transaksi
            DB::commit();

            // Redirect atau response sukses
            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil disimpan.');

        } catch (\Exception $e) {
            // Rollback jika terjadi error
            DB::rollBack();
            
            // Log error untuk debugging
            Log::error('Transaksi Error: ' . $e->getMessage());
            
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    // Method helper untuk membersihkan format angka
    private function cleanNumberFormat($value)
    {
        // Hapus titik dan koma, konversi ke float
        return floatval(str_replace(['.', ','], ['', '.'], $value));
    }


}
