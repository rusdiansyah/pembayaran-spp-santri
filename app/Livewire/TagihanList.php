<?php

namespace App\Livewire;

use App\Models\JenisTagihan;
use App\Models\Kelas;
use App\Models\Santri;
use App\Models\Tagihan;
use App\Models\TahunAjaran;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Throwable;

class TagihanList extends Component
{
    use WithPagination;
    #[Title('Tagihan')]
    public $title = 'Tagihan';
    public $id, $siswa_id, $periode, $jenis_tagihan_id, $jumlah;
    public $tahun_ajaran_id;
    public $postAdd = false;
    public $isStatus;
    public $paginate = 10;
    public $search;
    public $filterTahunAjaran, $filterJenisTagihan, $filterPeriode;
    public $tahunSaatIni;
    public $daftarTahun = [];
    public $bulanTerpilih;
    public $tahunTerpilih;
    public function mount()
    {
        $this->title;
        $this->isStatus = 'create';


        $this->tahunSaatIni = Carbon::now()->year;
        $this->daftarTahun = [
            $this->tahunSaatIni + 1,
            $this->tahunSaatIni,
            $this->tahunSaatIni - 1,
            $this->tahunSaatIni - 2,
        ];
        $this->tahunTerpilih = $this->tahunSaatIni;
        $this->bulanTerpilih = date('m');
        $this->tahun_ajaran_id = TahunAjaran::Aktif()->id;
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
    #[Computed()]
    public function listBulan()
    {
        return [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];
    }
    public function render()
    {
        $data = Tagihan::when($this->filterTahunAjaran, function ($q) {
            $q->whereHas('santri', function ($q) {
                return $q->where('tahun_ajaran_id', $this->filterTahunAjaran);
            });
        })
            ->when($this->filterJenisTagihan, function ($q) {
                return $q->where('jenis_tagihan_id', $this->filterJenisTagihan);
            })
            ->when($this->filterPeriode, function ($q) {
                return $q->where('periode', $this->filterPeriode);
            })
            ->latest()
            ->with(['santri', 'jenis_tagihan'])
            ->paginate($this->paginate);
        return view('livewire.tagihan-list', [
            'data' => $data
        ]);
    }
    public function udaptedSearch()
    {
        $this->resetPage();
    }
    public function blankForm()
    {
        // $this->tahun_ajaran_id = '';
        $this->jenis_tagihan_id = '';
        $this->jumlah = 0;
    }
    public function addPost()
    {
        $this->postAdd = true;
        $this->isStatus = 'create';
        $this->blankForm();
    }
    public function close()
    {
        $this->postAdd = false;
    }
    public function edit($id)
    {
        $this->isStatus = 'edit';
        $data = Tagihan::find($id);
        $this->id = $data->id;
        $this->tahun_ajaran_id = $data->tahun_ajaran_id;
        $this->jenis_tagihan_id = $data->jenis_tagihan_id;
        $this->jumlah = $data->jumlah;
    }
    public function save()
    {
        $this->validate([
            'tahun_ajaran_id' => 'required',
            'jenis_tagihan_id' => 'required',
            'bulanTerpilih' => 'required',
            'tahunTerpilih' => 'required',
            'jumlah' => 'required|min:6',
        ]);
        $periode = $this->bulanTerpilih . ' ' . $this->tahunTerpilih;
        // dd($periode);
        $santriAngkatan = Santri::where('tahun_ajaran_id', $this->tahun_ajaran_id)->get();
        if ($santriAngkatan->count() > 0) {


            foreach ($santriAngkatan as $row) {
                $tagihan = Tagihan::where('santri_id', $row->id)
                    ->where('jenis_tagihan_id', $this->jenis_tagihan_id)
                    ->where('periode', $periode)
                    ->first();
                if (!$tagihan) {
                    $tagihan = new Tagihan();
                    $tagihan->santri_id = $row->id;
                    $tagihan->jenis_tagihan_id = $this->jenis_tagihan_id;
                    $tagihan->periode = $periode;
                }
                $tagihan->jumlah = $this->jumlah;
                $tagihan->save();
            }
            $this->dispatch('swal', [
                'title' => 'Success!',
                'text' => 'Data berhasil ' . ($this->isStatus == 'create' ? 'disimpan' : 'diedit'),
                'icon' => 'success',
            ]);
            if ($this->isStatus == 'create') {
                $this->addPost();
            }
            $this->dispatch('close-modal');
        } else {
            $this->dispatch('swal', [
                'title' => 'Error!',
                'text' => 'Tidak ada Santri di Tahun Angkatan terpilih',
                'icon' => 'error',
            ]);
        }
    }
    public function cofirmDelete($id)
    {
        $this->dispatch('confirm', id: $id);
    }
    #[On('delete')]
    public function delete($id)
    {
        try {
            Tagihan::find($id)->delete();
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
}
