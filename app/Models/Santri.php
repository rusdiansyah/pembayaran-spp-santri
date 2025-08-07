<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Santri extends Model
{
    protected $fillable = [
        'nisn',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'nama_wali',
        'no_telp_wali',
        'tahun_ajaran_id',
        'kelas_id',
        'user_id',
    ];

    public function scopeTagihan()
    {
        $tagihan = Tagihan::select(DB::raw('SUM(jumlah) as tTagihan'))
        ->where('santri_id',$this->id)->first();
        $dibayar = PembayaranDetail::select(DB::raw('SUM(jumlahBayar) as tBayar'))
        ->whereHas('pembayaran',function($q){
            return $q->where('santri_id',$this->id);
        })
        ->first();
        $sisa = (int) $tagihan->tTagihan - (int) $dibayar->tBayar;
        return $sisa;
    }

    public function tahun_ajaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
