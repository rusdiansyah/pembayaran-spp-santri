<?php

namespace App\Livewire;

use App\Models\Setting;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class LogoLogin extends Component
{
    use WithFileUploads;
    #[Title('Background Login')]
    public $title = 'Background Login';
    public $id=1,$logo_login,$logo_login_old;

    public function mount()
    {
        $this->title;
        $data = Setting::find($this->id);
        if($data)
        {
            $this->logo_login_old = $data->logo_login;
        }else{
            $this->logo_login_old = '';
        }
    }
    public function render()
    {
        return view('livewire.logo-login');
    }

    public function save()
    {
        $this->validate([
            'logo_login' => 'required|max:1024',
        ]);
        $path = $this->logo_login->store('logo_login', 'public');
        Setting::where('id',$this->id)
        ->update([
            'logo_login' => $path,
        ]);
        $this->dispatch('swal',[
            'title' => 'Success!',
            'text' => 'Data berhasil disimpan',
            'icon' => 'success',
        ]);
        $this->logo_login = '';
        // $this->redirect('/setting/logo_login');
    }
}
