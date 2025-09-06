<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Penitip
            $table->string('transaction_id'); // ID Transaksi
            $table->decimal('amount', 12, 2); // Total transaksi
            $table->string('payment_method'); // BRI, Mandiri, dll
            $table->string('status'); // Selesai, Proses, Dibatalkan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('refunds');
    }
};
