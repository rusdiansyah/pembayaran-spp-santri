<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Register')]
class Register extends Component
{
    #[Layout('components.layouts.auth')]

    public $id,$name,$email;
    public $password,$password_confirmation;

    public function render()
    {
        return view('livewire.register');
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $this->id,
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6',
        ]);
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'role_id' => 2, //user
            'password' => Hash::make($this->password),
        ]);
        $this->dispatch('swal',[
            'title' => 'Success!',
            'text' => 'Data berhasil disimpan',
            'icon' => 'success',
        ]);
        $this->redirect(Login::class);
    }
}
