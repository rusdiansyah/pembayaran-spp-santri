<?php

namespace App\Livewire;

use App\Models\TahunAjaran;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Throwable;

class TahunAjaranList extends Component
{
    use WithPagination;
    #[Title('Tahun Ajaran')]
    public $title = 'Tahun Ajaran';
    public $id, $nama, $isActive;
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
        $data = TahunAjaran::where('nama', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate($this->paginate);
        return view('livewire.tahun-ajaran-list', [
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
        $this->isActive = (bool) false;
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
        $data = TahunAjaran::find($id);
        $this->id = $data->id;
        $this->nama = $data->nama;
        $this->isActive = (bool) $data->isActive;
    }
    public function save()
    {
        $this->validate([
            'nama' => 'required|min:3|unique:tahun_ajarans,nama,' . $this->id
        ]);
        TahunAjaran::updateOrCreate(['id' => $this->id], [
            'nama' => $this->nama,
            'isActive' => $this->isActive,
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
            TahunAjaran::find($id)->delete();
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
