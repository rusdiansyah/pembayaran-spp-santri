<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Login')]
class Login extends Component
{
    #[Layout('components.layouts.auth')]
    #[Validate('required|email')]
    public $email;
    #[Validate('required|min:5')]
    public $password;
    public function render()
    {
        return view('livewire.login');
    }

    public function login()
    {
        $this->validate();

        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials)) {

            if (Auth::user()->role->nama == 'Admin') {
                return $this->redirect('dashboard');
            } elseif (Auth::user()->role->nama == 'Santri') {
                return $this->redirect('user/dashboard');
            } else {
                Auth::logout();
                return redirect('/');
            }
        }

        session()->flash('error', 'Invalid credentials!');
    }
}
