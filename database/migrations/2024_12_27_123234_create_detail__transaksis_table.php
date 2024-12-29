<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('no_struk'); // Menggunakan no_struk sebagai foreign key
            $table->unsignedBigInteger('kode_barang'); // Menggunakan kode_barang sebagai foreign key
            $table->integer('kuantitas_barang');
            $table->decimal('harga_total_barang', 10, 2);
            $table->timestamps();
            // Menambahkan foreign key constraint
            $table->foreign('no_struk')->references('no_struk')->on('transaksis')->onDelete('cascade');
            $table->foreign('kode_barang')->references('id')->on('produks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail__transaksis');
    }
};
