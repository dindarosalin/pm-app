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
    public $rab_id, $kebutuhan, $deskripsi, $uom, $quantity = 1, $unit_price = 0, $total_per_item;
    public $rabDetailId;
    public $details = [];
    public $atasan = [], $jabatan = [], $jenisApprove = [];
    public $selectJobdesk, $selectHead, $jenis_rab;
    public $auth;



    public function render()
    {
        $this->auth = Auth::user()->user_id;

        // load details jika rabId sudah ada
        if ($this->rabId) {
            $this->details = rab::getDetailsByRabId($this->rabId);
        }
        return view('livewire.approved.form-pengajuan.form-rab');
    }

    public function mount($rabId = null)
    {
        $this->rabId = $rabId;

         // ✅ TAMBAHKAN: Inisialisasi data user
        if (!$rabId) {
            $this->name_id = Auth::user()->user_id;
            $this->email = Auth::user()->user_email;
            $this->auth = Auth::user()->user_id;
        }

        // load dropdown 
        $this->jabatan = Jobdesk::getAllJob();
        $this->jenisApprove = Approval::getAllApproval();

        // jika edit mode, load data RAB
        if ($this->rabId) {
            $this->loadRabData();
        }

        // load atasan by jobdesk 
        if ($this->selectJobdesk) {
            $this->loadHead();
        }
    }
    
    public function loadRabData()
    {
        $rab = rab::edit($this->rabId);

        if ($rab) {
            $this->name_id = $rab->name_id;
            $this->email = $rab->email;
            $this->telepon = $rab->telepon;
            $this->jobdesk_id = $rab->jobdesk_id;     // ✅ Set property yang benar
            $this->head_id = $rab->head_id;           // ✅ Set property yang benar
            $this->id_jenis_approve = $rab->id_jenis_approve; 

            // Set juga untuk dropdown selection
            $this->selectJobdesk = $rab->jobdesk_id;
            $this->selectHead = $rab->head_id;
            $this->jenis_rab = $rab->id_jenis_approve;

            // load atasan setelah jobdesk di set
            $this->loadHead();

            // load details
            $this->details = rab::getDetailsByRabId($this->rabId);
        } else {
            session()->flash('error', 'RAB tidak ditemukan.');
        }
    }
    // public function mount()
    // {
    //     $this->jabatan = Jobdesk::getAllJob();
    //     $this->jenisApprove = Approval::getAllApproval(); // Ambil semua jenis approve
    //     $this->atasan = Head::getHeadByJobdesk($this->selectJobdesk);

        // DATA RAB DETAIL
        // $rab = rab::getIdRab($rabId);
        // if ($rab) {
        //     $this->rabId = $rab->id;
        //     $this->details = rab::getAllRabDetail($this->rabId);
        // } else {
        //     session()->flash('error', 'RAB not found.');
        // }
    // }
    // ==============================================================================STORE====================================================
    public function store()
    {
        // dd($this->all());
        // $this->validate([
        //     'telepon' => 'required',
        //     'selectJobdesk' => 'required',
        //     'selectHead' => 'required',
        //     'jenis_rab' => 'required',
        // ]);

        try {
            
    
        $storeData = [
            'name_id' => $this->auth,
            'email' => Auth::user()->user_email,
            'telepon' => $this->telepon,
            'selectJobdesk' => $this->selectJobdesk,
            'selectHead' => $this->selectHead,
            'jenis_rab' => $this->jenis_rab,
            
        ];

        if ($this->rabId) {
            // Update existing RAB
            $affected = DB::table('rabs')
                ->where('id', $this->rabId)
                ->update($storeData);
                
            if ($affected > 0) {
                $this->js("alert('Data RAB berhasil diupdate!')");
            } else {
                $this->js("alert('Tidak ada data yang diupdate, periksa ID!')");
                return;
            }
        } else {
            // Create new RAB
            $storeData['created_at'] = now();
            
            // Menggunakan insert biasa jika tidak perlu ID
            $inserted = DB::table('rabs')->insert($storeData);
            
            // Atau gunakan insertGetId jika perlu ID
            // $this->rabId = DB::table('rabs')->insertGetId($storeData);
            
            if ($inserted) {
                $this->js("alert('Data RAB berhasil disimpan!')");
            } else {
                throw new \Exception('Gagal insert data');
            }
        }

        $this->dispatch('close-offcanvas');
        } catch (\Throwable $th) {
            $this->js("alert('Data RAB gagal disimpan! ". $th->getMessage() ."')");
        }
    }
    
    // public function store()
    // {
    //     try {
    //         if ($this->rabId) {
    //             DB::table('rabs')->where('id', $this->rabId)->update([
    //                 'name_id' => $this->auth,
    //                 'email' => Auth::user()->user_email,
    //                 'telepon' => $this->telepon,
    //                 'jobdesk_id' => $this->selectJobdesk,
    //                 'head_id' => $this->selectHead,
    //                 'id_jenis_approve' => $this->jenis_rab,
    //                 'updated_at' => now(),
    //             ]);
    //             $this->js("alert('Data RAB berhasil diupdate!')");
    //         } else {
    //             $rabId = DB::table('rabs')->insertGetId([
    //                 'name_id' => $this->auth,
    //                 'email' => Auth::user()->user_email,
    //                 'telepon' => $this->telepon,
    //                 'jobdesk_id' => $this->selectJobdesk,
    //                 'head_id' => $this->selectHead,
    //                 'id_jenis_approve' => $this->jenis_rab,
    //                 'created_at' => now(),
    //                 'updated_at' => now(),
    //             ]);
    //         }

            //  // 2. Simpan detail RAB jika ada data detail
            // if ($this->kebutuhan || $this->deskripsi) {
            //     $this->total_per_item = $this->totalItem($this->quantity, $this->unit_price);
                
            //     if ($this->rabDetailId) {
            //         rab::updateRabDetail([
            //             'rab_id' => $this->rabId,
            //             'kebutuhan' => $this->kebutuhan,
            //             'deskripsi' => $this->deskripsi,
            //             'uom' => $this->uom,
            //             'quantity' => $this->quantity,
            //             'unit_price' => $this->unit_price,
            //             'total_per_item' => $this->total_per_item,
            //         ], $this->rabDetailId);
            //     } else {
            //         rab::createRabDetail([
            //             'rab_id' => $this->rabId,
            //             'kebutuhan' => $this->kebutuhan,
            //             'deskripsi' => $this->deskripsi,
            //             'uom' => $this->uom,
            //             'quantity' => $this->quantity,
            //             'unit_price' => $this->unit_price,
            //             'total_per_item' => $this->total_per_item,
            //         ]);
            //     }
            // }
    //         $this->js("alert('Data RAB berhasil disimpan!')");
    //         $this->dispatch('close-offcanvas'); //offcanvas tutup otomatis
    //         $this->resetForm();
    //     } catch (\Throwable $th) {
    //         $this->js("alert('Data RAB gagal disimpan!')");
    //     }      
    // }

    // ===========================================RAB DETAIL========================================================
    public function storeDetail()
    {
        $this->validate([
            'kebutuhan' => 'required',
            'deskripsi' => 'required',
            'uom' => 'required',
            'quantity' => 'required|numeric|min:1',
            'unit_price' => 'required|numeric|min:0',
        ]);

        if (!$this->rabId) {
            $this->js("alert('Simpan RAB terlebih dahulu sebelum menambahkan detail!')");
            return;
        }

        try {
            $this->calculateTotalPerItem();

            $detailData = [
                'rab_id' => $this->rabId,
                'kebutuhan' => $this->kebutuhan,
                'deskripsi' => $this->deskripsi,
                'uom' => $this->uom,
                'quantity' => $this->quantity,
                'unit_price' => $this->unit_price,
                'total_per_item' => $this->total_per_item,
            ];

            if ($this->rabDetailId) {
                // update existing RAB Detail
                rab::updateRabDetail($detailData, $this->rabDetailId);
                $this->js("alert('Data RAB Detail berhasil diupdate!')");
            } else {
                // create new RAB Detail
                rab::createRabDetail($detailData);
                $this->js("alert('Data RAB Detail berhasil disimpan!')");
            }

            $this->resetDetailForm();
            $this->details = rab::getDetailsByRabId($this->rabId);
            $this->dispatch('close-detail-offcanvas'); // offcanvas tutup otomatis

        } catch (\Throwable $th) {
            $this->js("alert('Data Detail RAB gagal disimpan! " . $th->getMessage() . "')");
        }
        
    }

    public function editRabDetail($detailId)
    {
        $detail = collect($this->details)->firstWhere('id', $detailId);

        if ($detail) {
            $this->rabDetailId = $detail->id;
            $this->rabId = $detail->rab_id;
            $this->kebutuhan = $detail->kebutuhan;
            $this->deskripsi = $detail->deskripsi;
            $this->uom = $detail->uom;
            $this->quantity = $detail->quantity;
            $this->unit_price = $detail->unit_price;

            // Hitung total per item
            $this->calculateTotalPerItem();
        }
    }
    
    public function deleteRabDetail($detailId)
    {
        try {
            rab::deleteRabDetail($detailId);
             $this->details = rab::getDetailsByRabId($this->rabId); // refresh details
             $this->js("alert('Data RAB Detail berhasil dihapus!')");
        } catch (\Throwable $th) {
            $this->js("alert('Data RAB Detail gagal dihapus!')");
        }
    }

    // ===========================================HANDLE CLOSE OFFCANVAS and RESET FORM=========================================
    public function btnCloseOffcanvas()
    {
        $this->resetForm();;
        $this->dispatch('close-offcanvas');
    }

    public function resetForm()
    {
        $this->reset([
            'rabId', 'name_id', 'email', 'telepon', 'selectJobdesk', 'selectHead', 
            'jenis_rab'
        ]);
        $this->resetDetailForm();
        $this->atasan = [];
        $this->details = [];
        $this->resetValidation();
    }

    public function resetDetailForm()
    {
        $this->reset([
            'rabDetailId', 'kebutuhan', 'deskripsi', 'uom', 'quantity', 'unit_price', 'total_per_item'
        ]);
        $this->quantity = 1; // reset quantity to default value 
        $this->unit_price = 0;
        $this->resetValidation();
    }

    // ===========================================DEPENDENT DROPDOWN=================================================
    public function loadHead()
    {
        if ($this->selectJobdesk) {
            $this->atasan = Head::getHeadByJobdesk($this->selectJobdesk);
        } else {
            $this->atasan = []; // reset atasan jika jobdesk tidak dipilih
            $this->selectHead = null; // reset selectHead juga
        }
    }

    // event listener untuk perubahan dropdown
    public function updatedSelectJobdesk()
    {
        $this->selectHead = null; //reset head selection
        $this->loadHead();
    }

// ===========================================COUNT TOTAL PER ITEM=========================================
    public function calculateTotalPerItem()
    {
        $this->total_per_item = $this->quantity * $this->unit_price;
    }

    // update total per item saat quantity atau unit price berubah
    public function updateQuantity()
    {
        $this->calculateTotalPerItem();
    }

    public function updateUnitPrice()
    {
        $this->calculateTotalPerItem();
    }

    public function getTotalRabPrice()
    {
        if ($this->rabId) {
            return rab::getTotalPrice($this->rabId);
        }
        return 0; // jika rabId belum ada, total harga adalah 0
    }

// ============================================LISTENERS==========================================
    #[On('edit-rab')]
    public function editRab($rabId)
    {
        $this->rabId = $rabId;
        $this->loadRabData(); 
    }

    #[On('new-rab')]
    public function newRab()
    {
        $this->resetForm();
        $this->rabId = null;
    }
}

// public function totalItem($qty, $price)
    // {
    //     return $this->total_per_item = $qty * $price;
    // }


//                     'total_per_item' => $this->total_per_item,
//                 ]);
//                 $this->js("alert('Data RAB Detail berhasil disimpan!')");
//             }
//             $this->dispatch('close-offcanvas'); //offcanvas tutup otomatis
//             $this->resetForm();
//         } catch (\Throwable $th) {
//             $this->js("alert('Data RAB Detail gagal disimpan!')");
//         }
//     }

//     public function totalItem($qty, $price)
//     {
//         return $this->total_per_item = $qty * $price;
//     }

// }

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
