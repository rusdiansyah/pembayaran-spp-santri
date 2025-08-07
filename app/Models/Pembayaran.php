<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = [
        'nomorBayar',
        'tanggal',
        'santri_id',
        'keterangan',
        'jenisBayar',
        'buktiBayar',
        'totalBayar',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    public function detail()
    {
        return $this->hasMany(PembayaranDetail::class,'pembayaran_id');
    }
}
