<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'nama_aplikasi',
        'nama_perusahaan',
        'alamat',
        'copyright',
        'favicon',
        'logo_login',
        'logo_home',
        'logo_laporan',
    ];
}
