<?php

namespace App\Livewire;

use App\Models\JenisTagihan;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Models\TahunAjaran;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Throwable;
class PembayaranList extends Component
{
    use WithPagination;
    #[Title('Pembayaran')]
    public $title = 'Pembayaran';
    public $paginate = 10;
    public $isValid = [];
    public $search;
    public $filterTahunAjaran, $filterJenisTagihan, $filterPeriode;
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
        $data = Pembayaran::when($this->filterTahunAjaran, function ($q) {
            $q->whereHas('santri', function ($q) {
                return $q->where('tahun_ajaran_id', $this->filterTahunAjaran);
            });
        })
        ->when($this->search,function($q){
            $q->whereHas('santri', function ($q) {
                return $q->where('nama', 'like','%'.$this->search.'%');
            });
        })
            ->when($this->filterJenisTagihan, function ($q) {
                $q->whereHas('detail', function ($q) {
                    return $q->where('jenis_tagihan_id', $this->filterJenisTagihan);
                });
            })
            // ->when($this->filterPeriode, function ($q) {
            //     return $q->where('periode', $this->filterPeriode);
            // })
            ->latest()
            ->with(['santri', 'detail'])
            ->paginate($this->paginate);
        foreach($data as $row)
        {
            $this->isValid[$row->id] = (bool) $row->isValid ?? '';
        }
        return view('livewire.pembayaran-list', [
            'data' => $data
        ]);
    }
    public function udaptedSearch()
    {
        $this->resetPage();
    }

    public function addPost()
    {
        return $this->redirectRoute('pembayaranCreate');
    }
    public function cofirmDelete($id)
    {
        $this->dispatch('confirm', id: $id);
    }
    #[On('delete')]
    public function delete($id)
    {
        try {
            Pembayaran::find($id)->delete();
            $this->dispatch('swal', [
                'title' => 'Success!',
                'text' => 'Data berhasil dihapus',
                'icon' => 'success',
            ]);
        } catch (Throwable $e) {
            report($e);
            $this->dispatch('swal', [
                'title' => 'Error!',
                'text' => 'Data tidak dapat dihapus',
                'icon' => 'Error',
            ]);
            return false;
        }
    }

    public function saveValid($id)
    {
        // dd($this->isValid[$id]);
        Pembayaran::where('id',$id)
        ->update([
            'isValid' => (bool) $this->isValid[$id],
        ]);
        // dd($id);
    }
}
