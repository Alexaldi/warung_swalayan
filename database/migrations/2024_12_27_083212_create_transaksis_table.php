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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('no_struk')->unique();
            $table->date('tgl_struk');
            $table->time('jam_belanja');
            $table->foreignId('id_kasir')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_member')->constrained('users')->onDelete('cascade');
            $table->integer('total_item');
            $table->integer('total_quantitas');
            $table->decimal('sub_total', 10, 2);
            $table->decimal('bayar', 10, 2);
            $table->decimal('kembalian', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
