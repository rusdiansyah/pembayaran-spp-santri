<?php

namespace App\Livewire;

use App\Models\Pembayaran;
use App\Models\PembayaranDetail;
use App\Models\Santri;
use App\Models\Tagihan;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use PhpParser\Node\Stmt\TryCatch;

class PembayaranCreate extends Component
{
    #[Title('Pembayaran')]
    public $title = 'Pembayaran';
    public $santriId, $nisn, $kelas, $jenisBayar, $totalBayar = 0;
    public $sisaBayar = [];
    public $bayar = [];
    public function mount()
    {
        $this->title;
        $this->santriId = '';
        $this->jenisBayar = 'Cash';
    }

    #[Computed()]
    public function listSantri()
    {
        return Santri::orderBy('nisn')->pluck('nama', 'id');
    }
    #[Computed()]
    public function listJenisBayar()
    {
        return [
            'Cash' => 'Cash',
            'Transfer' => 'Transfer',
            'QRIS' => 'QRIS',
            'VA' => 'VA',
        ];
    }
    public function render()
    {
        $this->sisaBayar = [];
        // $this->bayar = [];
        $data = Tagihan::where('santri_id', $this->santriId)
            ->orderBy('periode')
            ->get()
            ->map(function ($tagihan) {
                return [
                    'id_tagihan' => $tagihan->id,
                    'periode' => $tagihan->periode,
                    'jenis_tagihan' => $tagihan->jenis_tagihan->nama,
                    'jumlah' => $tagihan->jumlah - $this->totalDibayar($tagihan->id,$this->santriId),
                ];
            });
        $this->updateTotalBayar();

        return view('livewire.pembayaran-create', [
            'data' => $data
        ]);
    }

    public function totalDibayar($tagihan_id, $santri_id)
    {
        $detail = PembayaranDetail::where('tagihan_id',$tagihan_id)
        ->whereHas('pembayaran',function($q)use($santri_id){
            return $q->where('santri_id', $santri_id);
        })
        ->get();
        $total = 0;
        foreach($detail as $row)
        {
            $total +=(int)$row->jumlahBayar;
        }
        return $total;
    }

    public function updatedSantriId($id)
    {
        // dd('item');
        $data = Santri::where('id', $id)->first();
        if ($data) {
            $this->nisn = $data->nisn;
            $this->kelas = $data->kelas->nama;
        } else {
            $this->nisn = '';
            $this->kelas = '';
        }
    }

    public function updateBayar()
    {
        $this->updateTotalBayar();
    }

    public function updateTotalBayar()
    {
        $total = 0;
        foreach ($this->bayar as $index => $row) {
            $this->bayar[$index] =(int) $row;
            $total +=(int) $row;
        }
        $this->totalBayar = $total;
    }

    public function save()
    {
        // dd($this->all());

        $this->validate([
            'santriId' => 'required',
            'nisn' => 'required',
            'kelas' => 'required',
            'jenisBayar' => 'required',
            // 'totalBayar' => 'required|min:3',
        ]);
        $this->updateTotalBayar();
        $nomorBayar = $this->nisn . rand(1000, 9999);

        if ($this->totalBayar > 0) {
            $pembayaran = new Pembayaran();
            $pembayaran->nomorBayar = $nomorBayar;
            $pembayaran->tanggal = date('Y-m-d');
            $pembayaran->santri_id = $this->santriId;
            $pembayaran->totalBayar = $this->totalBayar;
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
            $this->santriId = '';
            $this->nisn = '';
            $this->kelas = '';
            $this->bayar = [];
            $this->totalBayar = 0;
        }else{
            $this->dispatch('swal', [
                'title' => 'Error!',
                'text' => 'Anda belum mengisi pembayaran',
                'icon' => 'error',
            ]);
        }
    }
}
