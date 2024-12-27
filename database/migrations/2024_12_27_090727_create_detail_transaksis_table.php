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
            $table->string('kode_barang');
            $table->integer('kuantitas_barang');
            $table->decimal('harga_total_barang', 10, 2);
            $table->timestamps();
            // Jika Anda ingin menambahkan foreign key constraint
            $table->foreign('no_struk')->references('no_struk')->on('transaksis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksis');
    }
};
