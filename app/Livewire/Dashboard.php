<?php

namespace App\Livewire;

use App\Models\Pembayaran;
use App\Models\Santri;
use App\Models\Tagihan;
use Livewire\Attributes\Title;
use Livewire\Component;
use DB;

class Dashboard extends Component
{
    #[Title('Dashboard')]
    public $title='Dashboard';
    public $jmlSantri,$jmlTagihan=0,$jmlPembayaran=0,$piutang=0;
    public function mount()
    {
        $this->title;
        $this->jmlSantri = Santri::count();
        $tagihan = Tagihan::select(DB::raw('SUM(jumlah) as totalTagihan'))->first()->totalTagihan ?? 0;
        $bayar = Pembayaran::select(DB::raw('SUM(totalBayar) as totalBayar'))->first()->totalBayar ?? 0;
        $this->jmlTagihan = number_format($tagihan);
        $this->jmlPembayaran = number_format($bayar);
        $sisa = (int) $tagihan - (int)$bayar;
        $this->piutang =number_format($sisa);
    }
    public function render()
    {
        return view('livewire.dashboard');
    }
}
