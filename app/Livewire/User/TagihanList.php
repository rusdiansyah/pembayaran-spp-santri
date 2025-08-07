<?php

namespace App\Livewire\User;

use App\Models\PembayaranDetail;
use App\Models\Santri;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class TagihanList extends Component
{
    use WithPagination;
    #[Title('Tagihan')]
    public $title = 'Tagihan';
    public $santriId;
    public $paginate = 10;
    public $search;
    public function mount()
    {
        $this->title;
        $santri = Santri::where('user_id',Auth::user()->id)->first();
        $this->santriId = $santri->id;
    }
    public function render()
    {
        $data = Tagihan::where('santri_id',$this->santriId)
            ->latest()
            ->with(['santri', 'jenis_tagihan'])
            ->get()
            ->map(function ($tagihan) {
                $sisa = $tagihan->jumlah - $this->totalDibayar($tagihan->id, $this->santriId);
                return [
                    'id_tagihan' => $tagihan->id,
                    'periode' => $tagihan->periode,
                    'jenis_tagihan' => $tagihan->jenis_tagihan->nama,
                    'jumlah' => $tagihan->jumlah,
                    'dibayar' => $this->totalDibayar($tagihan->id, $this->santriId),
                    'tagihan' => $sisa,
                    'status' => $sisa==0 ? 'Lunas' : 'Belum Lunas',
                ];
            });
        return view('livewire.user.tagihan-list',[
            'data' => $data
        ]);
    }
    public function totalDibayar($tagihan_id, $santri_id)
    {
        $detail = PembayaranDetail::where('tagihan_id', $tagihan_id)
            ->whereHas('pembayaran', function ($q) use ($santri_id) {
                return $q->where('santri_id', $santri_id);
            })
            ->get();
        $total = 0;
        foreach ($detail as $row) {
            $total += (int)$row->jumlahBayar;
        }
        return $total;
    }
}
