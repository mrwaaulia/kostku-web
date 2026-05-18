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
        Schema::create('kamars', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_kamar')->unique();
            $table->foreignId('kode_kost')->constrained('kosts')->onDelete('cascade');
            $table->string('tipe_kamar');
            $table->integer('harga');
            $table->enum('status', ['terisi', 'kosong'])->default('kosong');
            $table->text('fasilitas')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // $table->foreignId('penghuni_id')->constrained('penghunis')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kamars');
    }
};
