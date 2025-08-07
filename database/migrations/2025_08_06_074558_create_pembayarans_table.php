<?php

use App\Models\Santri;
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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->string('nomorBayar');
            $table->date('tanggal');
            $table->foreignIdFor(Santri::class)->constrained();
            $table->string('keterangan')->nullable();
            $table->enum('jenisBayar',['Cash','Transfer','VA','Qris']);
            $table->string('buktiBayar')->nullable();
            $table->integer('totalBayar');
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
