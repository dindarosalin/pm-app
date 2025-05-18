<?php

namespace App\Livewire\Approved\FormPengajuan;

use App\Models\Approval\Cuti;
use App\Models\Approval\Izin;
use App\Models\Approval\PengadaanProyek;
use App\Models\Approval\rab;
use App\Models\Approval\Reimburse;
use Livewire\Attributes\On;
use Livewire\Component;

class DetailForm extends Component
{
    public $cuti;
    public $selectedCuti;

    public function mount($cuti)
    {
        $this->cuti = $cuti;
    }

    public function render()
    {
        return view('livewire.approved.form-pengajuan.detail-form');
    }

     #[On('show-detail')]
    public function detailCuti($id)
    {
        $this->selectedCuti = Cuti::detailCuti($id);
        $this->dispatch('show-modal-cuti');
    }
}
//     public $formType;
//     public $formId;
//     public $data;

//     public function mount($formType, $formId)
//     {
//         $this->formType = $formType;
//         $this->formId = $formId;

//         // Load the data based on the form type and ID
//         switch ($formType) {
//             case 'cuti':
//                 $this->data = Cuti::getById($formId);
//                 break;
//             case 'izin':
//                 $this->data = Izin::getIzinById($formId); // Load data for Izin
//                 break;
//             case 'rab':
//                 $this->data = rab::getRabById($formId); // Load data for RAB
//                 break;
//             case 'reimburse':
//                 $this->data = Reimburse::getreimburseById($formId); // Load data for RAB
//                 break;
//             case 'pengadaan':
//                 $this->data = PengadaanProyek::getPengadaanProyekById($formId); // Load data for RAB
//                 break;
//             default:
//                 $this->data = null;
//         }
       
        
//     }


    
// }
