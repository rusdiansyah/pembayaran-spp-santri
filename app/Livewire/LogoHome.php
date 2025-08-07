<?php

namespace App\Livewire;

use App\Models\Setting;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class LogoHome extends Component
{
    use WithFileUploads;
    #[Title('Logo Home')]
    public $title = 'Logo Home';
    public $id=1,$logo_home,$logo_home_old;

    public function mount()
    {
        $this->title;
        $data = Setting::find($this->id);
        if($data)
        {
            $this->logo_home_old = $data->logo_home;
        }else{
            $this->logo_home_old = '';
        }
    }
    public function render()
    {
        return view('livewire.logo-home');
    }

    public function save()
    {
        $this->validate([
            'logo_home' => 'required|max:2048',
        ]);
        $path = $this->logo_home->store('logo_home', 'public');
        Setting::where('id',$this->id)
        ->update([
            'logo_home' => $path,
        ]);
        $this->dispatch('swal',[
            'title' => 'Success!',
            'text' => 'Data berhasil disimpan',
            'icon' => 'success',
        ]);
        // $this->logo_home = '';
        $this->redirect('/setting/logo_home');
    }
}
