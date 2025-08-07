<?php

namespace App\Livewire;

use App\Models\Kelas;
use App\Models\Role;
use App\Models\Santri;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Throwable;

class SantriList extends Component
{
    use WithPagination;
    #[Title('Santri')]
    public $title = 'Santri';
    public $id, $nisn, $nama, $jenis_kelamin, $tempat_lahir, $tanggal_lahir;
    public $alamat, $nama_wali, $no_telp_wali, $tahun_ajaran_id, $kelas_id, $user_id;
    public $email;
    public $postAdd = false;
    public $isStatus;
    public $paginate = 10;
    public $search;
    public $filterTahunAjaran, $filterJenisKelamin;

    public function mount()
    {
        $this->title;
        $this->isStatus = 'create';
        $this->tahun_ajaran_id = TahunAjaran::Aktif()->id;
    }
    #[Computed()]
    public function listJenisKelamin()
    {
        return [
            'L' => 'Laki-laki',
            'P' => 'Perempuan',
        ];
    }
    #[Computed()]
    public function listTahunAjaran()
    {
        return TahunAjaran::latest()->get();
    }
    #[Computed()]
    public function listKelas()
    {
        return Kelas::latest()->get();
    }
    public function render()
    {
        $data = Santri::whereAny(['nisn', 'nama'], 'like', '%' . $this->search . '%')
            ->when($this->filterTahunAjaran, function ($q) {
                return $q->where('tahun_ajaran_id', $this->filterTahunAjaran);
            })
            ->when($this->filterJenisKelamin, function ($q) {
                return $q->where('jenis_kelamin', $this->filterJenisKelamin);
            })
            ->latest()
            ->paginate($this->paginate);
        return view('livewire.santri-list', [
            'data' => $data
        ]);
    }
    public function udaptedSearch()
    {
        $this->resetPage();
    }
    public function blankForm()
    {
        $this->nisn = '';
        $this->nama = '';
        $this->jenis_kelamin = '';
        $this->tempat_lahir = '';
        $this->tanggal_lahir = '';
        $this->alamat = '';
        $this->nama_wali = '';
        $this->no_telp_wali = '';
        // $this->tahun_ajaran_id = '';
        $this->kelas_id = '';
        $this->email = '';
    }
    public function addPost()
    {
        $this->postAdd = true;
        $this->isStatus = 'create';
        $this->blankForm();
    }
    public function close()
    {
        $this->postAdd = false;
    }
    public function edit($id)
    {
        $this->isStatus = 'edit';
        $data = Santri::find($id);
        $this->id = $data->id;
        $this->nisn = $data->nisn;
        $this->nama = $data->nama;
        $this->jenis_kelamin = $data->jenis_kelamin;
        $this->tempat_lahir = $data->tempat_lahir;
        $this->tanggal_lahir = $data->tanggal_lahir;
        $this->alamat = $data->alamat;
        $this->nama_wali = $data->nama_wali;
        $this->no_telp_wali = $data->no_telp_wali;
        $this->tahun_ajaran_id = $data->tahun_ajaran_id;
        $this->kelas_id = $data->kelas_id;
        $this->email = $data->user->email;
    }
    public function save()
    {
        $this->validate([
            'nisn' => 'required|unique:santris,nisn,' . $this->id,
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'email' => 'required|email',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'nama_wali' => 'required',
            'no_telp_wali' => 'required',
            'kelas_id' => 'required',
            'tahun_ajaran_id' => 'required',
        ]);
        $role = Role::where('id',2)->first();
        if(!$role)
        {
            $this->dispatch('swal', [
                'title' => 'Error!',
                'text' => 'Belum ada Role Santri ',
                'icon' => 'Error',
            ]);
            return false;
        }
        $user = User::where('email', $this->email)->first();
        if (!$user) {
            $user = new user();
            $user->name = $this->nama;
            $user->email = $this->email;
            $user->role_id = 2;
            $user->password = Hash::make('password');
            $user->save();
        }
        Santri::updateOrCreate(['id' => $this->id], [
            'nisn' => $this->nisn,
            'nama' => $this->nama,
            'jenis_kelamin' => $this->jenis_kelamin,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'alamat' => $this->alamat,
            'nama_wali' => $this->nama_wali,
            'no_telp_wali' => $this->no_telp_wali,
            'kelas_id' => $this->kelas_id,
            'tahun_ajaran_id' => $this->tahun_ajaran_id,
            'user_id' => $user->id,
        ]);
        $this->dispatch('swal', [
            'title' => 'Success!',
            'text' => 'Data berhasil ' . ($this->isStatus == 'create' ? 'disimpan' : 'diedit'),
            'icon' => 'success',
        ]);
        if ($this->isStatus == 'create') {
            $this->addPost();
        }
        $this->dispatch('close-modal');
    }
    public function cofirmDelete($id)
    {
        $this->dispatch('confirm', id: $id);
    }
    #[On('delete')]
    public function delete($id)
    {
        try {
            Santri::find($id)->delete();
            $this->dispatch('swal', [
                'title' => 'Success!',
                'text' => 'Data berhasil dihapus',
                'icon' => 'success',
            ]);
        } catch (Throwable $e) {
            report($e);
            $this->dispatch('swal', [
                'title' => 'Error!',
                'text' => 'Data tidak dapat dihapus',
                'icon' => 'Error',
            ]);
            return false;
        }
    }
}
