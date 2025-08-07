<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Lupa Password')]
class LupaPassword extends Component
{
    #[Layout('components.layouts.auth')]

    #[Validate('required')]
    public $email;
    public function render()
    {
        return view('livewire.lupa-password');
    }

    public function save()
    {
        $this->validate();
    }
}
