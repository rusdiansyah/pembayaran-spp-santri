<?php

namespace App\Livewire;

use App\Models\Setting as ModelsSetting;
use Livewire\Attributes\Title;
use Livewire\Component;

class Setting extends Component
{
    #[Title('Identitas')]
    public $title = 'Identitas';
    public $id=1,$nama_aplikasi,$nama_perusahaan,$copyright,$alamat,$favicon,$logo_login,$logo_home,$logo_laporan;

    public function mount()
    {
        $this->title;
        $data = ModelsSetting::find($this->id);
        if($data)
        {
            $this->nama_aplikasi = $data->nama_aplikasi;
            $this->nama_perusahaan = $data->nama_perusahaan;
            $this->copyright = $data->copyright;
            $this->alamat = $data->alamat;
        }else{
            $this->nama_aplikasi = '';
            $this->nama_perusahaan = '';
            $this->copyright = '';
            $this->alamat = '';
        }
    }

    public function render()
    {
        return view('livewire.setting');
    }

    public function save()
    {
        $this->validate([
            'nama_aplikasi' => 'required|min:5',
            'nama_perusahaan' => 'required|min:5',
            'copyright' => 'required|min:5',
            'alamat' => 'required|min:5',
            // 'favicon' => 'required|min:5',
            // 'logo_login' => 'required|min:5',
            // 'logo_home' => 'required|min:5',
            // 'logo_laporan' => 'required|min:5',
        ]);
        // dd($this->all());
        $x = ModelsSetting::find($this->id);
        if(!$x)
        {
            $x = new ModelsSetting;
        }
        $x->nama_aplikasi = $this->nama_aplikasi;
        $x->nama_perusahaan = $this->nama_perusahaan;
        $x->copyright = $this->copyright;
        $x->alamat = $this->alamat;
        $x->save();

        $this->dispatch('swal',[
            'title' => 'Success!',
            'text' => 'Data berhasil disimpan',
            'icon' => 'success',
        ]);
        // $this->redirect('/setting/identitas');
    }
}
