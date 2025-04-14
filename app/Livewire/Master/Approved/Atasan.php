<?php

namespace App\Livewire\Master\Approved;

use App\Models\Projects\Master\Head;
use App\Models\Projects\Master\Jobdesk;
use Livewire\Attributes\On;
use Livewire\Component;

class Atasan extends Component
{
    public $head;
    public $jobdesk;
    public $atasan;
    public $headId;
    public $name, $jobdesk_id;


    public function render()
    {
        return view('livewire.master.approved.atasan', ['head' => $this->head]);
    }

    public function mount()
    {
        $this->jobdesk = Jobdesk::getAllJob();
        $this->head = Head::getAllHead();
    }

// ======================================STORE(CREATE & UPDATE), DELETE, EDIT==================================================
    public function store()
    {
        $this->validate([
            'jobdesk_id' => 'required',
            'name' => 'required|string|max:255',
        ]);

        try {
            if ($this->headId) {
                Head::update([
                    'jobdesk_id' => $this->jobdesk_id,
                    'name' => $this->name
                ], $this->headId);
                session()->flash('success', 'Atasan Berhasil Diubah!');
            } else {
                Head::create([
                    'jobdesk_id' => $this->jobdesk_id,
                    'name' => $this->name
                ]);
                session()->flash('success', 'Atasan Berhasil Dibuat!');
            }
            $this->js("alert('Atasan Disimpan!')");
            $this->dispatch('refresh');
        } catch (\Throwable $th) {
            session()->flash('error', 'Error: ' .$th->getMessage());
        }
    }

    public function edit($id)
    {
        $atasan = Head::getHeadById($id);

        if ($atasan) {
            $this->headId = $atasan->id;
            $this->name = $atasan->name;
        }
        $this->dispatch('show-edit-offcanvas');
    }

    public function delete($id)
    {
        Head::delete($id);
        $this->js("alert('Atasan Tersimpan!')");
        $this->dispatch('refresh');
    }

// ======================================CLICK HANDLE===============================================
    public function btnHead_Clicked()
    {
        $this->dispatch('show-create-offcanvas');
    }

// ========================================LOAD OTOMATIS================================================
     #[On('refresh')]
     public function refresh() {
        $this->head = Head::getAllHead();
     }
}
