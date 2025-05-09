<?php

namespace App\Livewire\Master\Approved;

use App\Models\Master\Jobdesk as MasterJobdesk;
use App\Models\Projects\Master\Jobdesk as ProjectsMasterJobdesk;
use Livewire\Attributes\On;
use Livewire\Component;

class Jobdesk extends Component
{
    public $jobdesk;
    public $jobId;
    public $job;

    #[On('refresh')]
    public function refresh()
    {
        $this->jobdesk = Jobdesk::getAllJob();
    }
    
    public function render()
    {
        return view('livewire.master.approved.jobdesk', ['jobdesk' => $this->jobdesk]);
    }

    public function mount()
    {
        $this->jobdesk = Jobdesk::getAllJob();
    }

// ========================================STORE, DELETE, EDIT==========================================
    public function store()
    {
        $this->validate([
            'job' => 'required|string|max:255',
        ]);

        try {
            if ($this->jobId) {
                Jobdesk::update(['job' => $this->job], $this->jobId);
                session()->flash('success', 'Jabatan Berhasil Diupdate!');
            } else {
                Jobdesk::create(['job' => $this->job]);
                session()->flash('success', 'Jabatan Berhasil Dibuat!');
            }
            $this->js("alert('Jabatan Tersimpan')");

            $this->refresh();
        } catch (\Throwable $th) {
            session()->flash('error', 'Error: ' .$th->getMessage());
        }
    }

    public function edit($id)
    {
        $jobs = Jobdesk::getJobId($id);
        
        if ($jobs) {
            $this->jobId = $jobs->id;
            $this->job = $jobs->job;
        }
        $this->dispatch('show-edit-offcanvas');
    }

    public function delete($id)
    {
        Jobdesk::delete($id);
        $this->js("alert('Jabatan Terhapus!')");
        $this->dispatch('refresh');
    }

// ========================================HANDLE OFF CANVAS===============================================
    public function btnJob_Clicked()
    {
        $this->dispatch('show-create-offcanvas');
    }
}
