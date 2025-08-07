<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;


class Dashboard extends Component
{
    #[Title('Dashboard')]
    public $title='Dashboard';
    public function mount()
    {
        $this->title;
    }
    public function render()
    {
        return view('livewire.dashboard');
    }
}
