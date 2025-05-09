<?php
// KODE FIKS DIPAKE UNTUK FITUR UPLOAD RULE
namespace App\Livewire\Approved\Pengajuan;

use App\Models\Approval\Ketentuan;
use Livewire\Component;

class ShowSubmit extends Component
{
    public $rules;

    public function render()
    {
        $this->getKetentuan();
        return view('livewire.approved.pengajuan.show-submit');
    }

    public function getKetentuan()
    {
        $this->rules = Ketentuan::getAll();
    }
}
