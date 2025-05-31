<?php

namespace App\Livewire\Approved\FormPengajuan;

use App\Models\Approval\rab;
use App\Models\Projects\Master\Approval;
use App\Models\Projects\Master\Head;
use App\Models\Projects\Master\Jobdesk;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class FormRab extends Component
{
    public $rabId;
    public $name_id, $email, $telepon, $jobdesk_id, $head_id, $id_jenis_approve;
    public $kebutuhan, $deskripsi, $uom, $quantity = 1, $unit_per_price = 0, $total_per_item;
    public $atasan = [], $jabatan = [], $jenisApprove = [];
    public $selectJobdesk, $selectHead, $jenis_rab;
    public $auth;



    public function render()
    {
        $this->auth = Auth::user()->user_id;
        return view('livewire.approved.form-pengajuan.form-rab');
    }

    public function mount()
    {
        $this->jabatan = Jobdesk::getAllJob();
        $this->jenisApprove = Approval::getAllApproval(); // Ambil semua jenis approve
        $this->atasan = Head::getHeadByJobdesk($this->selectJobdesk);
        
    }
    // ==============================================================================STORE====================================================
    public function store()
    {
        try {
            if ($this->rabId) {
                DB::table('rabs')->where('id', $this->rabId)->update([
                    'name_id' => $this->auth,
                    'email' => Auth::user()->user_email,
                    'telepon' => $this->telepon,
                    'jobdesk_id' => $this->selectJobdesk,
                    'head_id' => $this->selectHead,
                    'id_jenis_approve' => $this->jenis_rab,
                    'updated_at' => now(),
                ]);
                $this->js("alert('Data RAB berhasil diupdate!')");
            } else {
                DB::table('rabs')->insert([
                    'name_id' => $this->auth,
                    'email' => Auth::user()->user_email,
                    'telepon' => $this->telepon,
                    'jobdesk_id' => $this->selectJobdesk,
                    'head_id' => $this->selectHead,
                    'id_jenis_approve' => $this->jenis_rab,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $this->js("alert('Data RAB berhasil disimpan!')");
            }
            $this->dispatch('close-offcanvas'); //offcanvas tutup otomatis
            $this->resetForm();
        } catch (\Throwable $th) {
            $this->js("alert('Data RAB gagal disimpan!')");
        }      
    }

    // ===========================================HANDLE CLOSE OFFCANVAS and RESET FORM=========================================
    public function btnCloseOffcanvas()
    {
        $this->resetForm();
        $this->dispatch('close-offcanvas');
    }

    public function resetForm()
    {
        $this->reset([
            'rabId', 'name_id', 'email', 'telepon', 'selectJobdesk', 'selectHead', 
            'jenis_rab'
        ]);
        $this->atasan = [];
        $this->resetValidation();
    }

    // ===========================================DEPENDENT DROPDOWN=================================================
    public function loadHead()
    {
        if ($this->selectJobdesk) {
            $this->atasan = Head::getHeadByJobdesk($this->selectJobdesk);
        }
    }

    
}

// ===========================================COUNT TOTAL PER ITEM=========================================
    // public function totalItem($qty, $price)
    // {
    //     return $this->total_per_item = $qty * $price;
    // }
    

// {
//     public $kebutuhan, $jobdesk_id, $head_id, $id_jenis_approve, $deskripsi, $uom, $quantity = 1, $unit_per_price = 0;
//     public $total_per_item;
//     public $rabId;
//     public $rabs;
//     public $selectJobdesk, $selectHead, $jenis_rab;
//     public $atasan = [], $jabatan = [], $jenisApprove = [];


//     public function render()
//     {
//         return view('livewire.approved.form-pengajuan.form-rab');
//     }

//     public function mount()
//     {
//         $this->jabatan = rab::getAllRab(); // Ambil semua jabatan
//         $this->jenisApprove = Approval::getAllApproval(); // Ambil semua jenis approve
//         $this->atasan = []; // Inisialisasi atasan sebagai array kosong

//         // $this->jabatan = rab::getAllRab();
//         // $this->jenisApprove = Approval::getAllApproval();
//         // $this->atasan = Head::getHeadByJobdesk($this->selectJobdesk);
//     }

//     //=========================================STORE=========================================
//     public function store()
//     {
//         // $this->validate([
//         //     'jobdesk_id' => 'required',
//         //     'head_id' => 'required',
//         //     'id_jenis_approve' => 'required',
//         //     'kebutuhan' => 'required',
//         //     'deskripsi' => 'required',
//         //     'uom' => 'required',
//         //     'quantity' => 'required|numeric|min:1',
//         //     'unit_per_price' => 'required|numeric|min:0',
//         // ]);

//         try {
//             if ($this->rabId) {
//                 $this->total_per_item = $this->quantity * $this->unit_per_price;
//                 rab::update([
//                     'jobdesk_id' => $this->selectJobdesk,
//                     'head_id' => $this->selectHead,
//                     'id_jenis_approve' => $this->jenis_rab,
//                     'kebutuhan' => $this->kebutuhan,
//                     'deskripsi' => $this->deskripsi,
//                     'uom' => $this->uom,
//                     'quantity' => $this->quantity,
//                     'unit_per_price' => $this->unit_per_price,
//                     'total_price' => $this->total_per_item,
//                 ], $this->rabId);
//                 $this->js("alert('Data RAB berhasil diupdate!');");
//             } else {

//                 $this->total_per_item = $this->quantity * $this->unit_per_price;
//                 rab::create([
//                     'jobdesk_id' => $this->selectJobdesk,
//                     'head_id' => $this->selectHead,
//                     'id_jenis_approve' => $this->jenis_rab,
//                     'kebutuhan' => $this->kebutuhan,
//                     'deskripsi' => $this->deskripsi,
//                     'uom' => $this->uom,
//                     'quantity' => $this->quantity,
//                     'unit_per_price' => $this->unit_per_price,
//                     'total_price' => $this->total_per_item,
//                 ]);
//                 $this->js("alert('Data RAB berhasil disimpan!');");
//             }
//             $this->dispatch('close-offcanvas'); //offcanvas tutup otomatis
//             $this->dispatch('rabUpdated'); //load otomatis
//             $this->resetForm(); //reset otomatis
//         } catch (\Throwable $th) {
//             $this->js("alert('Data RAB gagal disimpan!');");
//         }
//     }

//     #[On('edit')]
//     public function edit($id)
//     {
//         // get data for form edit
//         $rabs = rab::getAllRab($id);

//         $this->rabId = $rabs->id;
//         $this->selectJobdesk = $rabs->jobdesk_id;
//         $this->selectHead = $rabs->head_id;
//         $this->jenis_rab = $rabs->id_jenis_approve;
//         $this->kebutuhan = $rabs->kebutuhan;
//         $this->deskripsi = $rabs->deskripsi;
//         $this->uom = $rabs->uom;
//         $this->quantity = $rabs->quantity;
//         $this->unit_per_price = $rabs->unit_per_price;

//         $this->dispatch('show-edit-offcanvas-rab');
//     }
//     //=========================================COUNT TOTAL PER ITEM=========================================
//     public function totalItem($qty, $price)
//     {
//         return $this->total_per_item = $qty * $price;
//     }

//     // =========================================HANDLE CLOSE OFFCANVAS=========================================
//         public function btnCloseOffcanvas()
//         {
//             $this->resetForm();
//             $this->dispatch('close-offcanvas');
//         }

//         public function resetForm()
//         {
//             $this->kebutuhan = '';
//             $this->deskripsi = '';                      
//             $this->uom = '';
//             $this->quantity = ''; 
//             $this->unit_per_price = '';
//             $this->rabId = '';
//         }
    
//     // =====================================DEPENDENT DROPDOWN=================================================
//     public function loadHead()
//     {
//          if ($this->jobdesk_id) {
//             $this->atasan = Head::getHeadByJobdesk($this->jobdesk_id);
//         }

//         // if ($this->jobdesk_id) {
//         //     $this->atasan = Head::getHeadByJobdesk($this->jobdesk_id);
//         // }
//     }
// }
