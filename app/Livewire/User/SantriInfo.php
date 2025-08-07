<?php

namespace App\Livewire\User;

use App\Models\Santri;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

class SantriInfo extends Component
{
    #[Title('Info Santri')]
    public $title = 'Info Santri';
    public $id, $nisn, $nama, $jenis_kelamin, $tempat_lahir, $tanggal_lahir;
    public $alamat, $nama_wali, $no_telp_wali, $tahun_ajaran, $kelas;
    public $email;

    public function mount()
    {
        $data = Santri::where('user_id',Auth::user()->id)->first();
        $this->nisn = $data->nisn ?? '';
        $this->nama = $data->nama ?? '';
        $this->jenis_kelamin = $data->jenis_kelamin=='L' ? 'Laki-laki' : 'Perempuan';
        $this->tempat_lahir = $data->tempat_lahir ?? '';
        $this->tanggal_lahir = date('d-m-Y',strtotime($data->tanggal_lahir)) ?? '';
        $this->alamat = $data->alamat ?? '';
        $this->nama_wali = $data->nama_wali ?? '';
        $this->no_telp_wali = $data->no_telp_wali ?? '';
        $this->tahun_ajaran = $data->tahun_ajaran->nama ?? '';
        $this->kelas = $data->kelas->nama ?? '';
        $this->email = $data->user->email ?? '';
    }
    public function render()
    {
        return view('livewire.user.santri-info');
    }
}
