<?php

namespace App\Livewire\Approved\FormPengajuan;

use App\Models\Approval\Ketentuan;
use Livewire\Component;

class ShowApproval extends Component
{
    public $rules;

    public function render()
    {
        $this->getRule();
        return view('livewire.approved.form-pengajuan.show-approval');
    }
// =======================================GET KETENTUAN===============================================================
    public function getRule()
    {
        $this->rules = Ketentuan::getAll();
    }

// ============================================HANDLE OFFCANVAS CREATE=====================================
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
