<?php

namespace App\Livewire\Approved\FormPengajuan;

use App\Models\Approval\Cuti;
use App\Models\Approval\Ketentuan;
use Livewire\Attributes\On;
use Livewire\Component;

class ShowApproval extends Component
{
    public $rules;
    public $formId, $typeForm, $data;
    public $cutis;
    // cuti
    public $cutiId, $id_jenis_approve, $tanggal_pengajuan;
    public $cuti; //data cuti dari database
    

    public function render()
    {
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

    // =============================================LOGIKA GET DATA FORM=========================================================
    #[On('show-form')]
    public function showForm($formId, $typeForm)
    {
        if($typeForm === 'cuti') {
            $data = Cuti::getById($formId);
            if (!$data) {
                $this->js("alert('Data tidak ditemukan')");
                return;
            }

            $this->cutiId = $data->id;
            $this->id_jenis_approve = $data->id_jenis_approve;
            $this->tanggal_pengajuan = $data->tanggal_pengajuan;

            $this->dispatch('show-detail.cuti');
        }
    }

    // ==========================================GET CUTI==============================================
    public function loadCuti()
    {
        $this->cutis = Cuti::getCuti();
    }

    // ==========================================DETAIL=================================================
    public function mount()
    {
        $this->cuti = Cuti::getAll();
         $this->getRule();
        $this->loadCuti();
    }

    public function detailCuti($id)
{
    $this->dispatch('show-detail', id: $id); // memanggil method `detailCuti` di DetailForm
    $this->dispatch('show-modal-cuti');      // untuk memunculkan modal
}
}
