<?php

namespace App\Livewire\Master\Approved;

use App\Models\Projects\Master\Approval;
use Livewire\Attributes\On;
use Livewire\Component;

class JenisApproval extends Component
{
    public $approval;
    public $approvalId;
    public $jenis;

    #[On('refresh')]
    public function refresh()
    {
        $this->approval = Approval::getAllApproval();
    }
    
    public function render()
    {
        return view('livewire.master.approved.jenis-approval', ['approval' => $this->approval]);
    }

    public function mount()
    {
        $this->approval = Approval::getAllApproval();
    }

    // ========================================STORE, DELETE, EDIT==========================================    
    public function store()
    {
        $this->validate([
            'jenis' => 'required|string|max:50',
        ]);

        try {
            if ($this->approvalId) {
                Approval::update(['jenis' => $this->jenis], $this->approvalId);
                session()->flash('success', 'Approval Berhasil Diupdate!');
            } else {
                Approval::create(['jenis' => $this->jenis]);
                session()->flash('success', 'Approval Berhasil Dibuat!');
            }
            $this->js("alert('Approval Tersimpan')");

            $this->refresh();
        } catch (\Throwable $th) {
            session()->flash('error', 'Error: ' .$th->getMessage());
        }
    }

    public function edit($id)
    {
        $approvals = Approval::getApprovalId($id);

        if ($approvals) {
            $this->approvalId = $approvals->id;
            $this->jenis = $approvals->jenis;
        }
        $this->dispatch('show-edit-offcanvas');
    }

    public function delete($id)
    {
        Approval::delete($id);
        $this->js("alert('Approval Berhasil Dihapus')");
        $this->dispatch('refresh');
    }

    // ========================================HANDLE OFFCANVAS==========================================
    public function btnApproval_Clicked()
    {
        $this->approvalId = null;
        $this->jenis = null;

        $this->dispatch('show-edit-offcanvas');
    }
}
    

    

    

    


