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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->string('id_pembayaran')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('tanggal_pembayaran');
            $table->integer('nominal');
            $table->enum('tipe_pembayaran', ['lunas', 'cicilan'])->default('lunas');
            $table->integer('jumlah_cicilan')->default(1);
            $table->enum('status', ['belum_bayar', 'lunas'])->default('belum_bayar');
            $table->string('snap_token')->nullable(); // Token dari Midtrans
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
