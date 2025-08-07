<?php

namespace App\Livewire;

use App\Models\Role as ModelsRole;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Throwable;

class Role extends Component
{
    use WithPagination;
    #[Title('Role User')]
    public $title = 'Role User';
    public $id, $nama;
    public $postAdd = false;
    public $isStatus;
    public $paginate = 10;

    public $search;
    public $selectAll = false;
    public $selectedId = [];
    // public $data;

    public function mount()
    {
        $this->title;
        $this->isStatus = 'create';
    }

    public function render()
    {
        $data = ModelsRole::where('nama', 'like', '%' . $this->search . '%')
            ->paginate($this->paginate);
        return view('livewire.role', [
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
        $data = ModelsRole::find($id);
        $this->id = $data->id;
        $this->nama = $data->nama;
    }


    public function save()
    {
        $this->validate([
            'nama' => 'required|min:3|unique:roles,nama,' . $this->id
        ]);
        ModelsRole::updateOrCreate(['id' => $this->id], [
            'nama' => $this->nama,
        ]);
        if ($this->isStatus == 'create') {
            $this->dispatch('swal', [
                'title' => 'Success!',
                'text' => 'Data berhasil disimpan',
                'icon' => 'success',
            ]);
            $this->addPost();
        } else {
            $this->dispatch('swal', [
                'title' => 'Success!',
                'text' => 'Data berhasil diedit',
                'icon' => 'success',
            ]);
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
            ModelsRole::find($id)->delete();
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

    public function toggleSelectAll()
    {
        $data = ModelsRole::where('nama', 'like', '%' . $this->search . '%')
            ->paginate($this->paginate)
            ->items();
        $this->selectedId = $this->selectAll
            ? collect($data)->pluck('id')->toArray()
            : [];
    }

    // Sinkronkan selectedId saat data berubah (misalnya, pencarian atau paginasi)
    public function toggleSelectId($value)
    {
        // dd($value);
        $data = ModelsRole::where('nama', 'like', '%' . $this->search . '%')
            ->paginate($this->paginate)
            ->items(); // Ambil hanya item dari halaman saat ini
        $allIds = collect($data)->pluck('id')->toArray();
        $this->selectAll = $this->selectedId === $allIds;
    }

    public function resetSelection()
    {
        $this->selectedId = [];
        $this->selectAll = false;
    }


    public function updatingPage()
    {
        $this->resetSelection(); // Reset seleksi saat halaman berubah
    }

    public function deleteSelected()
    {
        try {
            ModelsRole::whereIn('id', $this->selectedId)->delete();
            $this->selectedId = [];
            $this->selectAll = false;
            $this->dispatch('swal', [
                'title' => 'Success!',
                'text' => 'Data terpilih berhasil dihapus',
                'icon' => 'success',
            ]);
            $this->resetPage();
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
