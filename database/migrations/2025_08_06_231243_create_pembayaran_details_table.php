<?php

use App\Models\JenisTagihan;
use App\Models\Pembayaran;
use App\Models\Tagihan;
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
        Schema::create('pembayaran_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Pembayaran::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Tagihan::class)->constrained();
            $table->integer('jumlahBayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_details');
    }
};
