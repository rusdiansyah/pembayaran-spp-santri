<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $fillable = [
        'santri_id',
        'periode',
        'jenis_tagihan_id',
        'jumlah',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    public function jenis_tagihan()
    {
        return $this->belongsTo(JenisTagihan::class);
    }
}
