<?php

namespace App\Livewire\Approved\FormPengajuan;

use App\Models\Approval\Cuti;
use App\Models\Approval\Izin;
use App\Models\Approval\Ketentuan;
use App\Models\Approval\Reimburse;
use Illuminate\Support\Facades\Auth;
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
    public $auth;
    public $c;
    public $approvalShow;


    public function render()
    {
        $this->auth = Auth::user()->user_id;
        $this->getRule();
        $this->loadCuti();
        // dd($this->getData());
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
    }

    public function getData()
    {
        $c = Cuti::getAllByAuth($this->auth);
        // return $c;
        // $i = Izin::getAllByAuth($this->auth);
        // $r = Reimburse::getAllByAuth($this->auth);
    }
    public function detailCuti($id)
    {
        $this->dispatch('show-detail', id: $id); // memanggil method `detailCuti` di DetailForm
        $this->dispatch('show-modal-cuti');      // untuk memunculkan modal
    }

// ============================================GET APPROVAL BY ID===================================================
    #[On('showApprovalById')]    
    public function showApprovalById($id)
    {
        try {
            $this->approvalShow = Cuti::getById($id);

            // kolom file_up berupa string jadi pake koma
             $this->approvalShow->file_up = explode(',', $this->approvalShow->file_up);

             $this->dispatch('show-view-cuti-offcanvas');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
