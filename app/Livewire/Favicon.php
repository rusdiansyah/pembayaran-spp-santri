<?php

namespace App\Livewire;

use App\Models\Setting;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class Favicon extends Component
{
    use WithFileUploads;
    #[Title('Favicon')]
    public $title = 'Favicon';
    public $id=1,$favicon;

    public function mount()
    {
        $this->title;
        $data = Setting::find($this->id);
        if($data)
        {
            $this->favicon = $data->favicon;
        }else{
            $this->favicon = '';
        }
    }
    public function render()
    {
        return view('livewire.favicon');
    }

    public function save()
    {
        $this->validate([
            'favicon' => 'required|max:1024',
        ]);
        $path = $this->favicon->store('favicon', 'public');
        Setting::where('id',$this->id)
        ->update([
            'favicon' => $path,
        ]);
        $this->dispatch('swal',[
            'title' => 'Success!',
            'text' => 'Data berhasil disimpan',
            'icon' => 'success',
        ]);
        $this->favicon = '';
        // $this->redirect('/setting/favicon');
    }
}
