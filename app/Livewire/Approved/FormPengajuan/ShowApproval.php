<?php

namespace App\Livewire\Approved\FormPengajuan;

use App\Livewire\Master\Approved\Atasan;
use App\Models\Projects\Master\Jobdesk;
use App\Models\Approval\Cuti;
use App\Models\Approval\Izin;
use App\Models\Approval\Ketentuan;
use App\Models\Approval\PengadaanProyek;
use App\Models\Approval\rab;
use App\Models\Approval\Reimburse;
use App\Models\Projects\Master\Approval;
use App\Models\Projects\Master\Head;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ShowApproval extends Component
{
    public $rules;
    public $formId, $typeForm, $data;
    public $cutis, $izins;
    // cuti
    public $cutiId, $tanggal_pengajuan;
    public $cuti; //data cuti dari database
    public $id_jenis_approve, $jenis;
    public $auth;
    public $c;

    public $izinId, $tgl_ajuan;
    public $izin; //data izin dari database
    public $i;
    public $approvalShow;


    public function render()
    {
        $this->auth = Auth::user()->user_id;
        $this->getRule();
        $this->loadCuti();
        $this->loadIzin();
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

        } elseif($typeForm === 'izin') {
            $data = Izin::getIzinById($formId);
            if (!$data) {
                $this->js("alert('Data tidak ditemukan')");
                return;
            }

            $this->izinId = $data->id;
            $this->id_jenis_approve = $data->id_jenis_approve;
            $this->tgl_ajuan = $data->tgl_ajuan;

            $this->dispatch('show-detail.izin');
        } 
        
    }

    // ==========================================GET CUTI==============================================
    public function loadCuti()
    {
        $this->cutis = Cuti::getCuti();
    }

    public function loadIzin()
    {
        $this->izins = Izin::getIzin();
    }
    // ==========================================DETAIL=================================================
    public function mount()
    {
        $this->cuti = Cuti::getAll();
        $this->izin = Izin::getAllIzin();
    }

    public function getData()
    {
        $c = Cuti::getAllByAuth($this->auth);
        $i = Izin::getAllByAuth($this->auth);
        // return $c;
        // $i = Izin::getAllByAuth($this->auth);
        // $r = Reimburse::getAllByAuth($this->auth);
    }
    // public function detailCuti($id)
    // {
    //     $this->dispatch('show-detail', id: $id); // memanggil method `detailCuti` di DetailForm
    //     $this->dispatch('show-modal-cuti');      // untuk memunculkan modal
    // }

// ============================================GET APPROVAL BY ID===================================================
   #[On('showApprovalById')]
   public function showApprovalById($id, $jenis)
   {
        try {
            $this->jenis = $jenis;

            
            if ($jenis === 'cuti') {
                $this->approvalShow = Cuti::getById($id);
                $this->approvalShow->job_description = Jobdesk::getJobId($this->approvalShow->jobdesk_id)->job;
                $this->approvalShow->head_description = Head::getHeadById($this->approvalShow->head_id)->name;
                $this->approvalShow->approval_description = Approval::getApprovalId($this->approvalShow->id_jenis_approve)->jenis;

                if (isset($this->approvalShow->file_up)) {
                    $this->approvalShow->file_up = explode(',', $this->approvalShow->file_up);
                }

                $this->dispatch('show-view-cuti-offcanvas');

            } elseif ($jenis === 'izin') {
                $this->approvalShow = Izin::getIzinById($id);
                $this->approvalShow->job_description = Jobdesk::getJobId($this->approvalShow->jobdesk_id)->job;
                $this->approvalShow->head_description = Head::getHeadById($this->approvalShow->head_id)->name;
                $this->approvalShow->approval_description = Approval::getApprovalId($this->approvalShow->id_jenis_approve)->jenis;

                if (isset($this->approvalShow->file_izin)) {
                    $this->approvalShow->file_izin = explode(',', $this->approvalShow->file_izin);
                }

                $this->dispatch('show-view-izin-offcanvas');
            } elseif ($jenis === 'reimburse') {
                $this->approvalShow = Reimburse::getreimburseById($id);
            } elseif ($jenis === 'rab') {
                $this->approvalShow = rab::getRabById($id);
            } elseif ($jenis === 'pengadaan') {
                $this->approvalShow = PengadaanProyek::getPengadaanProyekById($id);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
   
}


 // #[On('showApprovalById')]    
    // public function showApprovalById($id, $jenis)
    // {
    //     try {
    //         if ($jenis === 'cuti') {
    //             $this->approvalShow = Cuti::getById($id);
    //             $this->approvalShow->job_description = Jobdesk::getJobId($this->approvalShow->jobdesk_id)->job;
    //             $this->approvalShow->head_description = Head::getHeadById($this->approvalShow->head_id)->name;
    //             $this->approvalShow->approval_description = Approval::getApprovalId($this->approvalShow->id_jenis_approve)->jenis;

    //              if (isset($this->approvalShow->file_up)) {
    //             $this->approvalShow->file_up = explode(',', $this->approvalShow->file_up);
    //         }

    //         $this->dispatch('show-view-cuti-offcanvas');

    //         } elseif ($jenis === 'izin') {
    //             $this->approvalShow = Izin::getIzinById($id);
    //             // dd($this->approvalShow);
    //             $this->approvalShow->job_description = Jobdesk::getJobId($this->approvalShow->jobdesk_id)->job;
    //             $this->approvalShow->head_description = Head::getHeadById($this->approvalShow->head_id)->name;
    //             $this->approvalShow->approval_description = Approval::getApprovalId($this->approvalShow->id_jenis_approve)->jenis;

    //             if (isset($this->approvalShow->file_izin)) {
    //             $this->approvalShow->file_izin = explode(',', $this->approvalShow->file_izin);
    //         }

    //         $this->dispatch('show-view-izin-offcanvas');
    //         } elseif ($jenis === 'reimburse') {
    //             $this->approvalShow = Reimburse::getreimburseById($id);
    //         } elseif ($jenis === 'rab') {
    //             $this->approvalShow = rab::getRabById($id);
    //         } elseif ($jenis === 'pengadaan') {
    //             $this->approvalShow = PengadaanProyek::getPengadaanProyekById($id);
    //         }

    //         // SHOW FILE CUTI
    //         // $this->approvalShow->file_up = explode(',', $this->approvalShow->file_up);
    //         // $this->dispatch('show-view-cuti-offcanvas');

    //         // SHOW FILE IZIN
    //         // $this->approvalShow->file_izin = explode(',', $this->approvalShow->file_izin);
    //         // $this->dispatch('show-view-izin-offcanvas');
    //     } catch (\Throwable $th) {
    //         throw $th;
    //     }
    // }

// KODE ASLI
        // try {
        //     // $this->approvalShow = Cuti::getById($id);
        //     $this->approvalShow = Cuti::getById($id);
        //     $this->approvalShow->job_description = Jobdesk::getJobId($this->approvalShow->jobdesk_id)->job;
        //     $this->approvalShow->head_description = Head::getHeadById($this->approvalShow->head_id)->name;
        //     $this->approvalShow->approval_description = Approval::getApprovalId($this->approvalShow->id_jenis_approve)->jenis;
            
        //     // Process file uploads (split by comma)
        //     $this->approvalShow->file_up = explode(',', $this->approvalShow->file_up);
            
        //     // Trigger event to show the offcanvas
        //     $this->dispatch('show-view-cuti-offcanvas');
        // } catch (\Throwable $th) {
        //     throw $th;
        // }
    // }