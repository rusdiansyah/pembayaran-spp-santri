<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class PhotoUser extends Component
{
    use WithFileUploads;
    #[Title('User Setting')]
    public $title = 'User Setting';
    public $name,$email,$role;
    public $id,$photo,$photo_old;
    public $password,$password_confirmation;
    public $activeTab='profile';

    public function mount()
    {
        $this->title;
        $this->id = Auth::user()->id;
        $this->photo_old = Auth::user()->photo;
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->role = Auth::user()->role->nama;
    }
    public function render()
    {
        return view('livewire.photo-user');
    }

    public function setActiveTab($tab)
    {
        // dd($tab);
        $this->activeTab = $tab;
    }

    public function save()
    {
        $this->validate([
            'photo' => 'required|max:4096',
        ]);
        $path = $this->photo->store('photo', 'public');
        User::where('id',$this->id)
        ->update([
            'photo' => $path,
        ]);
        // $this->dispatch('swal',[
        //     'title' => 'Success!',
        //     'text' => 'Data berhasil disimpan',
        //     'icon' => 'success',
        // ]);
        // $this->logo_home = '';
        $this->redirect('/photouser');
    }
    public function saveProfile()
    {
        $this->validate([
            'name' => 'required',
        ]);
        User::where('id',$this->id)
        ->update([
            'name' => $this->name,
        ]);
        $this->dispatch('swal',[
            'title' => 'Success!',
            'text' => 'Data berhasil disimpan',
            'icon' => 'success',
        ]);
    }
    public function savePassword()
    {
        $this->validate([
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required',
        ]);
        User::where('id',$this->id)
        ->update([
            'password' => Hash::make($this->password),
        ]);
        $this->dispatch('swal',[
            'title' => 'Success!',
            'text' => 'Data berhasil diedit',
            'icon' => 'success',
        ]);
    }
}
