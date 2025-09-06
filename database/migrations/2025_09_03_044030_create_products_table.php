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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->text('deskripsi_barang')->nullable();
            $table->decimal('harga_barang', 15, 2);
            $table->string('foto')->nullable();
            $table->unsignedBigInteger('traveler_id'); // relasi ke user traveler
            $table->enum('status', ['validasi', 'disetujui', 'ditolak'])->default('validasi');
            $table->timestamps();

            $table->foreign('traveler_id')->references('id')->on('users')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
