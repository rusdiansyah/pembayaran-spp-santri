<?php

namespace App\Livewire;

use App\Models\JenisTagihan;
use App\Models\PembayaranDetail as ModelsPembayaranDetail;
use App\Models\Tagihan;
use App\Models\TahunAjaran;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class PembayaranDetail extends Component
{
    use WithPagination;
    #[Title('Pembayaran Detail')]
    public $title = 'Pembayaran Detail';
    public $paginate = 10;
    public $search;
    public $filterTahunAjaran, $filterJenisTagihan, $filterPeriode,$filterTanggal;
    public function mount()
    {
        $this->title;
    }
    #[Computed()]
    public function listTahunAjaran()
    {
        return TahunAjaran::latest()->get();
    }
    #[Computed()]
    public function listJenisTagihan()
    {
        return JenisTagihan::latest()->get();
    }
    #[Computed()]
    public function listPeriode()
    {
        return Tagihan::groupBy('periode')
            ->orderBy('periode')
            ->pluck('periode');
    }
    public function render()
    {
        $data = ModelsPembayaranDetail::when($this->filterJenisTagihan, function ($q) {
            $q->whereHas('tagihan', function ($q) {
                return $q->where('jenis_tagihan_id', $this->filterJenisTagihan);
            });
        })
            ->when($this->filterPeriode, function ($q) {
                $q->whereHas('tagihan', function ($q) {
                    return $q->where('periode', $this->filterPeriode);
                });
            })
            ->when($this->filterTahunAjaran, function ($q) {
                $q->whereHas('pembayaran.santri', function ($q) {
                    return $q->where('tahun_ajaran_id', $this->filterTahunAjaran);
                });
            })
            ->when($this->search, function ($q) {
                $q->whereHas('pembayaran.santri', function ($q) {
                    return $q->where('nama', 'like','%'.$this->search.'%');
                });
            })
            ->when($this->filterTanggal, function ($q) {
                $q->whereHas('pembayaran', function ($q) {
                    return $q->where('tanggal', $this->filterTanggal);
                });
            })
            ->with(['pembayaran', 'tagihan'])
            ->paginate($this->paginate);
        return view('livewire.pembayaran-detail', [
            'data' => $data
        ]);
    }
}
