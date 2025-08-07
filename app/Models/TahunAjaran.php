<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $fillable = [
        'nama',
        'isActive',
    ];

    public function scopeAktif()
    {
        return $this->where('isActive',1)->first();
    }
}
