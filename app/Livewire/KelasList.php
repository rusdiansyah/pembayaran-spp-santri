<?php

namespace App\Livewire;

use App\Models\Kelas;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Throwable;
class KelasList extends Component
{
    use WithPagination;
    #[Title('Kelas')]
    public $title = 'Kelas';
    public $id, $nama, $tingkat,$wali_kelas;
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
        $data = Kelas::where('nama', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate($this->paginate);
        return view('livewire.kelas-list',[
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
        $this->tingkat = '';
        $this->wali_kelas = '';
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
        $data = Kelas::find($id);
        $this->id = $data->id;
        $this->nama = $data->nama;
        $this->tingkat = $data->tingkat;
        $this->wali_kelas = $data->wali_kelas;
    }
    public function save()
    {
        $this->validate([
            'nama' => 'required|unique:kelas,nama,' . $this->id,
            'tingkat' => 'required',
            'wali_kelas' => 'required'
        ]);
        Kelas::updateOrCreate(['id' => $this->id], [
            'nama' => $this->nama,
            'tingkat' => $this->tingkat,
            'wali_kelas' => $this->wali_kelas,
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
            Kelas::find($id)->delete();
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
