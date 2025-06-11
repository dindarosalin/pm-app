<?php

namespace App\Livewire\Layouts;
use Livewire\Component;

class Sidebar extends Component
{
    public $projectId;

    public function mount()
    {
        // Mengambil ID project dari URL
        $this->projectId = request()->route('projectId');
    }

    public function render()
    {
        // dd($this->projectId);
        return view('livewire.layouts.sidebar', [
            'projectId' => $this->projectId
        ]);
    }


    public function btnCuti_Clicked()
    {
        $this->dispatch('show-create-offcanvas-cuti');
    }
    public function btnIzin_Clicked()
    {
        $this->dispatch('show-create-offcanvas-izin');
    }
    public function btnRab_Clicked()
    {
        $this->dispatch('show-create-offcanvas-rab');
    }
    public function btnReimburse_Clicked()
    {
        $this->dispatch('show-create-offcanvas-reimburse');
    }
    public function btnPengadaan_Clicked()
    {
        $this->dispatch('show-create-offcanvas-proyek');
    }
}
