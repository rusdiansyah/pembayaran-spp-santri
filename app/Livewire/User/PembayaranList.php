<?php

namespace App\Livewire\User;

use App\Models\PembayaranDetail;
use App\Models\Santri;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

class PembayaranList extends Component
{
    #[Title('Pembayaran')]
    public $title = 'Pembayaran';
    public $search;
    public $santriId;
    public function mount()
    {
        $this->title;
        $santri = Santri::where('user_id', Auth::user()->id)->first();
        $this->santriId = $santri->id;
    }
    public function render()
    {
        $data = PembayaranDetail::whereHas('pembayaran',function($q){
            $q->where('santri_id',$this->santriId);
        })
        ->get();
        return view('livewire.user.pembayaran-list',[
            'data' => $data
        ]);
    }
}
