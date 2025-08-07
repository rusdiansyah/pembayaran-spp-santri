<?php

namespace App\Livewire;

use App\Models\JenisTagihan;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Throwable;

class JenisTagihanList extends Component
{
    use WithPagination;
    #[Title('Jenis Tagihan')]
    public $title = 'Jenis Tagihan';
    public $id, $nama, $deskripsi;
    public $postAdd = false;
    public $isStatus;
    public $paginate = 10;
    public $search;

    public function mount()
    {
        $this->title;
        $this->isStatus = 'create';
    }
    public function render()
    {
        $data = JenisTagihan::where('nama', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate($this->paginate);
        return view('livewire.jenis-tagihan-list',[
            'data' => $data
        ]);
    }
    public function udaptedSearch()
    {
        $this->resetPage();
    }
    public function blankForm()
    {
        $this->nama = '';
        $this->deskripsi = '';
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
        $data = JenisTagihan::find($id);
        $this->id = $data->id;
        $this->nama = $data->nama;
        $this->deskripsi = $data->deskripsi;
    }
    public function save()
    {
        $this->validate([
            'nama' => 'required|unique:jenis_tagihans,nama,' . $this->id,
            'deskripsi' => 'required',
        ]);
        JenisTagihan::updateOrCreate(['id' => $this->id], [
            'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
        ]);
        $this->dispatch('swal', [
            'title' => 'Success!',
            'text' => 'Data berhasil ' . ($this->isStatus == 'create' ? 'disimpan' : 'diedit'),
            'icon' => 'success',
        ]);
        if ($this->isStatus == 'create') {
            $this->addPost();
        }
        $this->dispatch('close-modal');
    }

    public function cofirmDelete($id)
    {
        $this->dispatch('confirm', id: $id);
    }
    #[On('delete')]
    public function delete($id)
    {
        try {
            JenisTagihan::find($id)->delete();
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
