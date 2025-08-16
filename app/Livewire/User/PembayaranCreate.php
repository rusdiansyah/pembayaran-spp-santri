<?php

namespace App\Livewire\User;

use App\Models\Pembayaran;
use App\Models\PembayaranDetail;
use App\Models\Santri;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class PembayaranCreate extends Component
{
    use WithFileUploads;
    #[Title('Pembayaran')]
    public $title = 'Pembayaran';
    public $santriId,$nama, $nisn, $kelas, $jenisBayar, $totalBayar = 0;
    public $buktiBayar;
    public $sisaBayar = [];
    public $bayar = [];
    public function mount()
    {
        $this->title;
        $santri = Santri::where('user_id', Auth::user()->id)->first();
        $this->santriId = $santri->id ?? '';
        $this->nama = $santri->nama ?? '';
        $this->nisn = $santri->nisn ?? '';
        $this->kelas = $santri->kelas->nama ?? '';

        $this->jenisBayar = 'Cash';
    }
    #[Computed()]
    public function listJenisBayar()
    {
        return [
            'Transfer' => 'Transfer',
        ];
    }
    public function render()
    {
        $this->sisaBayar = [];
        $data = Tagihan::where('santri_id', $this->santriId)
            ->orderBy('periode')
            ->get()
            ->map(function ($tagihan) {
                return [
                    'id_tagihan' => $tagihan->id,
                    'periode' => $tagihan->periode,
                    'jenis_tagihan' => $tagihan->jenis_tagihan->nama,
                    'jumlah' => $tagihan->jumlah - $this->totalDibayar($tagihan->id, $this->santriId),
                ];
            });
        $this->updateTotalBayar();
        return view('livewire.user.pembayaran-create',[
            'data' => $data
        ]);
    }
    public function updateTotalBayar()
    {
        $total = 0;
        foreach ($this->bayar as $index => $row) {
            $this->bayar[$index] = (int) $row;
            $total += (int) $row;
        }
        $this->totalBayar = $total;
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

    public function updateBayar()
    {
        $this->updateTotalBayar();
    }


    public function save()
    {
        // dd($this->all());

        $this->validate([
            'santriId' => 'required',
            'nisn' => 'required',
            'kelas' => 'required',
            'jenisBayar' => 'required',
            'buktiBayar' => 'required|image',
        ]);
        $this->updateTotalBayar();
        $nomorBayar = $this->nisn . rand(1000, 9999);
        $path = $this->buktiBayar->store('buktiBayar', 'public');

        if ($this->totalBayar > 0) {
            $pembayaran = new Pembayaran();
            $pembayaran->nomorBayar = $nomorBayar;
            $pembayaran->tanggal = date('Y-m-d');
            $pembayaran->santri_id = $this->santriId;
            $pembayaran->totalBayar = $this->totalBayar;
            $pembayaran->isValid = (bool) false;
            $pembayaran->buktiBayar = $path;
            $pembayaran->save();
            // dd($this->bayar);
            foreach ($this->bayar as $index => $row) {
                // dd($index);
                if ($row > 0) {
                    $detail = new PembayaranDetail();
                    $detail->pembayaran_id = $pembayaran->id;
                    $detail->tagihan_id = $index;
                    $detail->jumlahBayar = $row;
                    $detail->save();
                }
            }
            $this->dispatch('swal', [
                'title' => 'Success!',
                'text' => 'Data berhasil disimpan',
                'icon' => 'success',
            ]);
            $this->bayar = [];
            $this->totalBayar = 0;
        } else {
            $this->dispatch('swal', [
                'title' => 'Error!',
                'text' => 'Anda belum mengisi pembayaran',
                'icon' => 'error',
            ]);
        }
    }
}
