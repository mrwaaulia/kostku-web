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
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('skor_pembayaran', ['Baik', 'Perlu Perhatian', 'Buruk'])->default('Baik');
            $table->enum('skor_sikap', ['Baik', 'Perlu Perhatian', 'Buruk'])->default('Baik');
            $table->enum('skor_perawatan_fasilitas', ['Baik', 'Perlu Perhatian', 'Buruk'])->default('Baik');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
