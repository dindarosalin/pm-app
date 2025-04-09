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
}
