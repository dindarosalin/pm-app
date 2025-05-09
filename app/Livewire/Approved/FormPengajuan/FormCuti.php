<?php

namespace App\Livewire\Approved\FormPengajuan;

use App\Livewire\Master\Approved\Atasan;
use App\Models\Approval\Cuti as ApprovalCuti;
use App\Models\Projects\Master\Head;
use App\Models\Projects\Master\Jobdesk;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class FormCuti extends Component
{
    use WithFileUploads;

    // public $cutiId;
    // public $name, $selectJobdesk, $selectHead, $email, $no_telepon, $jenis_cuti, $detail;
    // public $tanggal_mulai, $tanggal_akhir, $tanggal_pengajuan, $akumulasi = 0;
    // public $nama_kontak_darurat, $telp_darurat, $hubungan_darurat, $alamat;
    // public $nama_delegasi, $detail_delegasi;
    // public $atasan = [], $jabatan = [];
    // public $newAttachment, $file_up;

    public $cutiId;
    public $name, $jobdesk_id, $head_id, $email, $no_telepon, $jenis_cuti, $detail,
           $tanggal_mulai, $tanggal_akhir, $tanggal_pengajuan, $nama_kontak_darurat, 
           $telp_darurat, $alamat, $hubungan_darurat, $nama_delegasi, $detail_delegasi;
    public $cutis = [];
    public $atasan = [], $jabatan = [];
    public $akumulasi = 0;
    public $selectJobdesk, $selectHead;

    // protected $rules = [
    //     'name' => 'required|string|max:255',
    //     'selectJobdesk' => 'required',
    //     'selectHead' => 'required',
    //     'email' => 'required|email|max:255',
    //     'no_telepon' => 'required|string|regex:/^[0-9]+$/|max:15',
    //     'jenis_cuti' => 'required|string|max:255',
    //     'detail' => 'required|string|max:1000',
    //     'tanggal_mulai' => 'required|date|before_or_equal:tanggal_akhir',
    //     'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
    //     'tanggal_pengajuan' => 'required|date',
    //     'nama_kontak_darurat' => 'required|string|max:255',
    //     'telp_darurat' => 'required|string|regex:/^[0-9]+$/|max:15',
    //     'hubungan_darurat' => 'required|string|max:255',
    //     'alamat' => 'required|string|max:1000',
    //     'nama_delegasi' => 'required|string|max:255',
    //     'detail_delegasi' => 'required|string|max:1000',
    //     'file_up' => 'nullable|mimes:pdf|max:2048',
    // ];

    #[Rule('required|mimes:pdf|max:2048',
    onUpdate: 'sometimes|mimes:pdf|max:2048')]
    public $newAttachment; //simpan file baru
    public $file_up; // simpan path file

    public function mount()
    {
        $this->jabatan = Jobdesk::getAllJob();
        $this->tanggal_pengajuan = now()->format('Y-m-d');
        $this->atasan = Head::getHeadByJobdesk($this->selectJobdesk);
    }

    public function render()
    {
        return view('livewire.approved.form-pengajuan.form-cuti');
    }

    public function store()
    {
        // $this->validate([
        //     'name' => 'required|string|max:255',
        //     'jobdesk_id' => 'required',
        //     'head_id' => 'required',
        //     'email' => 'required|email|max:255',
        //     'no_telepon' => 'required|string|regex:/^[0-9]+$/|max:15',
        //     'jenis_cuti' => 'required|string|max:255',
        //     'detail' => 'required|string|max:1000',
        //     'tanggal_mulai' => 'required|date|before_or_equal:tanggal_akhir',
        //     'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
        //     'tanggal_pengajuan' => 'required|date',
        //     'nama_kontak_darurat' => 'required|string|max:255',
        //     'telp_darurat' => 'required|string|regex:/^[0-9]+$/|max:15',
        //     'hubungan_darurat' => 'required|string|max:255',
        //     'alamat' => 'required|string|max:1000',
        //     'nama_delegasi' => 'required|string|max:255',
        //     'detail_delegasi' => 'required|string|max:1000',
        //     'newAttachment' => $this->cutiId ? 'sometimes|mimes:pdf|max:2048' : 'required|mimes:pdf|max:2048',
        // ]);

        try {
            $filePath = $this->file_up;

            if ($this->newAttachment) {
                if ($this->cutiId && $this->file_up) {
                    Storage::delete($this->file_up);
                }
                $filePath = $this->newAttachment->store('cutis', 'public');
            }

            if ($this->cutiId) {
                DB::table('cutis')
                    ->where('id', $this->cutiId)
                    ->update([
                        'name' => $this->name,
                        'jobdesk_id' => $this->selectJobdesk,
                        'head_id' => $this->selectHead,
                        'email' => $this->email,
                        'no_telepon' => $this->no_telepon,
                        'jenis_cuti' => $this->jenis_cuti,
                        'detail' => $this->detail,
                        'tanggal_mulai' => $this->tanggal_mulai,
                        'tanggal_akhir' => $this->tanggal_akhir,
                        'akumulasi' => $this->akumulasi,
                        'tanggal_pengajuan' => $this->tanggal_pengajuan,
                        'nama_kontak_darurat' => $this->nama_kontak_darurat,
                        'telp_darurat' => $this->telp_darurat,
                        'hubungan_darurat' => $this->hubungan_darurat,
                        'alamat' => $this->alamat,
                        'nama_delegasi' => $this->nama_delegasi,
                        'detail_delegasi' => $this->detail_delegasi,
                        'file_up' => $filePath,
                        'updated_at' => now(),
                    ]);
            } else {
                // dd($this->all());
                DB::table('cutis')->insert([
                    'name' => $this->name,
                    'jobdesk_id' => $this->jobdesk_id,
                    'head_id' => $this->head_id,
                    'email' => $this->email,
                    'no_telepon' => $this->no_telepon,
                    'jenis_cuti' => $this->jenis_cuti,
                    'detail' => $this->detail,
                    'tanggal_mulai' => $this->tanggal_mulai,
                    'tanggal_akhir' => $this->tanggal_akhir,
                    'akumulasi' => $this->akumulasi,
                    'tanggal_pengajuan' => $this->tanggal_pengajuan,
                    'nama_kontak_darurat' => $this->nama_kontak_darurat,
                    'telp_darurat' => $this->telp_darurat,
                    'hubungan_darurat' => $this->hubungan_darurat,
                    'alamat' => $this->alamat,
                    'nama_delegasi' => $this->nama_delegasi,
                    'detail_delegasi' => $this->detail_delegasi,
                    'file_up' => $filePath,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $this->dispatch('close-offcanvas');
            // $this->dispatch('ruleUpdated');
            $this->resetForm();
        } catch (\Throwable $th) {
            throw $th;
            $this->js("alert('Tidak Tersimpan')");
        }
    }

        // dd('masuk?');
        // $this->validate();

        // try {
        //     // Handle file upload
        //     $filePath = $this->file_up;
        //     if ($this->newAttachment) {
        //         if ($this->cutiId && $this->file_up) {
        //             Storage::delete($this->file_up);
        //         }
        //         $filePath = $this->newAttachment->store('cutis', 'public');
        //     }

        //     $data = [
        //         'name' => $this->name,
        //         'jobdesk_id' => $this->selectJobdesk,
        //         'head_id' => $this->selectHead,
        //         'email' => $this->email,
        //         'no_telepon' => $this->no_telepon,
        //         'jenis_cuti' => $this->jenis_cuti,
        //         'detail' => $this->detail,
        //         'tanggal_mulai' => $this->tanggal_mulai,
        //         'tanggal_akhir' => $this->tanggal_akhir,
        //         'tanggal_pengajuan' => $this->tanggal_pengajuan,
        //         'nama_kontak_darurat' => $this->nama_kontak_darurat,
        //         'telp_darurat' => $this->telp_darurat,
        //         'hubungan_darurat' => $this->hubungan_darurat,
        //         'alamat' => $this->alamat,
        //         'nama_delegasi' => $this->nama_delegasi,
        //         'detail_delegasi' => $this->detail_delegasi,
        //         'file_up' => $filePath,
        //     ];

            // dd('kok remek');

    //         if ($this->cutiId) {
    //             ApprovalCuti::updateCuti($this->cutiId, $data);
    //             $message = 'Data cuti berhasil diperbarui!';
    //         } else {
    //             ApprovalCuti::createCuti($data);
    //             $message = 'Pengajuan cuti berhasil dibuat!';
    //         }

    //         $this->dispatch('close-offcanvas');
    //         $this->dispatch('cuti-updated');
    //         $this->resetForm();
    //         $this->dispatch('show-notification', message: $message);
            
    //     } catch (\Exception $e) {
    //         $this->dispatch('show-notification', 
    //             message: 'Gagal menyimpan data: ' . $e->getMessage(), 
    //             type: 'error'
    //         );
    //     }
    // }

    #[On('edit')]
    public function edit($id)
    {
        $cutis = ApprovalCuti::getById($id);
        
        $this->cutiId = $cutis->id;
        $this->name = $cutis->name;
        $this->jobdesk_id = $cutis->jobdesk_id;
        $this->head_id = $cutis->head_id;
        $this->email = $cutis->email;
        $this->no_telepon = $cutis->no_telepon;
        $this->jenis_cuti = $cutis->jenis_cuti;
        $this->detail = $cutis->detail;
        $this->tanggal_mulai = $cutis->tanggal_mulai;
        $this->tanggal_akhir = $cutis->tanggal_akhir;
        $this->tanggal_pengajuan = $cutis->tanggal_pengajuan;
        $this->akumulasi = $cutis->akumulasi;
        $this->nama_kontak_darurat = $cutis->nama_kontak_darurat;
        $this->telp_darurat = $cutis->telp_darurat;
        $this->hubungan_darurat = $cutis->hubungan_darurat;
        $this->alamat = $cutis->alamat;
        $this->nama_delegasi = $cutis->nama_delegasi;
        $this->detail_delegasi = $cutis->detail_delegasi;
        $this->file_up = $cutis->file_up;

        // $this->loadHead();
        $this->dispatch('show-edit-offcanvas-cuti');
    }

    public function loadHead()
    {
        if ($this->jobdesk_id) {
            $this->atasan = Head::getHeadByJobdesk($this->jobdesk_id);
        }
    }

    public function calculateDays()
    {
        if ($this->tanggal_mulai && $this->tanggal_akhir) {
            $this->akumulasi = ApprovalCuti::calculateCutiDays(
                $this->tanggal_mulai, 
                $this->tanggal_akhir
            );
        } else {
            $this->akumulasi = 0;
        }
    }

    public function updatedTanggalMulai()
    {
        $this->calculateDays();
    }

    public function updatedTanggalAkhir()
    {
        $this->calculateDays();
    }

    #[On('reset')]
    public function resetForm()
    {
        $this->reset([
            'cutiId', 'name', 'selectJobdesk', 'selectHead', 'email', 'no_telepon',
            'jenis_cuti', 'detail', 'tanggal_mulai', 'tanggal_akhir', 'tanggal_pengajuan',
            'nama_kontak_darurat', 'telp_darurat', 'hubungan_darurat', 'alamat',
            'nama_delegasi', 'detail_delegasi', 'newAttachment', 'file_up'
        ]);
        $this->akumulasi = 0;
        $this->atasan = [];
        $this->resetValidation();
    }

    public function btnCloseOffcanvas()
    {
        $this->resetForm();
        $this->dispatch('close-offcanvas');
    }


//     use WithFileUploads;

//     public $cutisId;
//     public $name, $jobdesk_id, $head_id, $email, $no_telepon, $jenis_cuti, $detail,
//            $tanggal_mulai, $tanggal_akhir, $tanggal_pengajuan, $nama_kontak_darurat, 
//            $telp_darurat, $hubungan_darurat, $alamat, $nama_delegasi, $detail_delegasi;
//     public $atasan = [];
//     public $jabatan;
//     public $cutis = [];
//     public $selectJobdesk, $selectHead;
//     public $akumulasi = 0;

//     #[Rule('sometimes|mimes:pdf|max:2048')]
//     public $newAttachment;
//     public $file_up;
    



//     public function render()
//     {
//         $this->jabatan = Jobdesk::getAllJob();
//         return view('livewire.approved.form-pengajuan.form-cuti');
//     }

// // ===========================================STORE===================================================
//     public function store()
//     {
//         $this->validate([
//             'name' => 'required|string|max:255',
//             'selectJobdesk' => 'required',
//             'selectHead' => 'required',
//             'email' => 'required|email|max:255',
//             'no_telepon' => 'required|string|regex:/^[0-9]+$/|max:15',
//             'jenis_cuti' => 'required|string|max:255',
//             'detail' => 'required|string|max:1000',
//             'tanggal_mulai' => 'required|date|before_or_equal:tanggal_akhir',
//             'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
//             'tanggal_pengajuan' => 'required|date',
//             'nama_kontak_darurat' => 'required|string|max:255',
//             'telp_darurat' => 'required|string|regex:/^[0-9]+$/|max:15',
//             'hubungan_darurat' => 'required|string|max:255',
//             'alamat' => 'required|string|max:1000',
//             'nama_delegasi' => 'required|string|max:255',
//             'detail_delegasi' => 'required|string|max:1000',
//             'newAttachment' => $this->cutisId ? 'sometimes|mimes:pdf|max:2048' : 'required|mimes:pdf|max:2048',
//         ]);
//         try {
//             $fileUp = $this->file_up;

//             if ($this->newAttachment) {
//                 // hapus file lama jika ada (update)
//                 if ($this->cutisId && $this->file_up) {
//                     Storage::delete($this->file_up);
//                 }
//                 $fileUp = $this->newAttachment->store('cutis', 'public');
//             }

//             if ($this->cutisId) {
//                 DB::table('cutis')
//                     ->where('id', $this->cutisId)
//                     ->update([
//                     'name' => $this->name,
//                     'jobdesk_id' => $this->selectJobdesk,
//                     'head_id' => $this->selectHead,
//                     'email' => $this->email,
//                     'no_telepon' => $this->no_telepon,
//                     'jenis_cuti' => $this->jenis_cuti,
//                     'detail' => $this->detail,
//                     'tanggal_mulai' => $this->tanggal_mulai,
//                     'tanggal_akhir' => $this->tanggal_akhir,
//                     'tanggal_pengajuan' => $this->tanggal_pengajuan,
//                     'nama_kontak_darurat' => $this->nama_kontak_darurat,
//                     'hubungan_darurat' => $this->hubungan_darurat,
//                     'telp_darurat' => $this->telp_darurat,
//                     'alamat' => $this->alamat,
//                     'nama_delegasi' => $this->nama_delegasi,
//                     'detail_delegasi' => $this->detail_delegasi,
//                     'file_up' => $this->newAttachment ?? $this->file_up,
//                     'updated_at' => now(),
//                 ]);
//             } else {
//                 ApprovalCuti::create([
//                     'name' => $this->name,
//                     'jobdesk_id' => $this->selectJobdesk,
//                     'head_id' => $this->selectHead,
//                     'email' => $this->email,
//                     'no_telepon' => $this->no_telepon,
//                     'jenis_cuti' => $this->jenis_cuti,
//                     'detail' => $this->detail,
//                     'tanggal_mulai' => $this->tanggal_mulai,
//                     'tanggal_akhir' => $this->tanggal_akhir,
//                     'tanggal_pengajuan' => $this->tanggal_pengajuan,
//                     'nama_kontak_darurat' => $this->nama_kontak_darurat,
//                     'hubungan_darurat' => $this->hubungan_darurat,
//                     'telp_darurat' => $this->telp_darurat,
//                     'alamat' => $this->alamat,
//                     'nama_delegasi' => $this->nama_delegasi,
//                     'detail_delegasi' => $this->detail_delegasi,
//                     'file_up' => $this->newAttachment ?? $this->file_up,
//                     'created_at' => now(),
//                     'updated_at' => now(),
//                 ]);
//             }
//             $this->dispatch('close-offcanvas');
//             $this->dispatch('cutiUpdated');
//             $this->resetForm();
//         } catch (\Throwable $th) {
//             throw $th;
//             $this->js("alert('Tidak Tersimpan')");
//         }
//     }

// // ==========================================================EDIT=======================================================
//     #[On('edit')]
//     public function edit($id)
//     {
//         $cutis = ApprovalCuti::getCutiById($id);

//         $this->cutisId = $cutis->id;
//         $this->name = $cutis->name;
//         $this->selectJobdesk = $cutis->jobdesk_id;
//         $this->selectHead = $cutis->head_id;
//         $this->email = $cutis->email;
//         $this->no_telepon = $cutis->no_telepon;
//         $this->jenis_cuti = $cutis->jenis_cuti;
//         $this->detail = $cutis->detail;
//         $this->tanggal_mulai = $cutis->tanggal_mulai;
//         $this->tanggal_akhir = $cutis->tanggal_akhir;
//         $this->tanggal_pengajuan = $cutis->tanggal_pengajuan;
//         $this->nama_kontak_darurat = $cutis->nama_kontak_darurat;
//         $this->hubungan_darurat = $cutis->hubungan_darurat;
//         $this->telp_darurat = $cutis->telp_darurat;
//         $this->alamat = $cutis->alamat;
//         $this->nama_delegasi = $cutis->nama_delegasi;
//         $this->detail_delegasi = $cutis->detail_delegasi;
//         $this->file_up = $cutis->file_up;

//         $this->dispatch('show-edit-offcanvas');
//     }
// // ===========================================DEPEDENT DROPDOWN=================================================================
//     public function loadHead()
//     {
//         if ($this->selectJobdesk) {
//             $this->atasan = Head::getHeadByJobdesk($this->selectJobdesk);
//         }
//     }

// // =================================================COUNT CUT==================================================================
//     public function calculateDays()
//     {
//         if ($this->tanggal_mulai && $this->tanggal_akhir) {
//             $start = Carbon::parse($this->tanggal_mulai);
//             $end = Carbon::parse($this->tanggal_akhir);
            
//             // Hitung hari kerja (exclude weekend)
//             $this->akumulasi = $start->diffInDaysFiltered(function (Carbon $date) {
//                 return !$date->isWeekend();
//             }, $end) + 1; // +1 untuk include hari pertama
//         } else {
//             $this->akumulasi = 0;
//         }
//     }

//     // Auto calculate ketika tanggal berubah
//     public function updatedTanggalMulai()
//     {
//         $this->calculateDays();
//     }

//     public function updatedTanggalAkhir()
//     {
//         $this->calculateDays();
//     }

// // ======================================================HANDLE OFF CANVAS=============================================
//     public function btnClose_Offcanvas()
//     {
//         $this->resetForm();
//         $this->dispatch('close_offcanvas');
//     }

// // ==============================================RESET================================================================
//     #[On('reset')]
//     public function resetForm()
//     {
//         $this->name = '';
//         $this->selectJobdesk = '';
//         $this->selectHead = '';
//         $this->email = '';
//         $this->no_telepon = '';
//         $this->jenis_cuti = '';
//         $this->detail = '';
//         $this->tanggal_mulai = '';
//         $this->tanggal_akhir = '';
//         $this->tanggal_pengajuan = '';
//         $this->nama_kontak_darurat = '';
//         $this->hubungan_darurat = '';
//         $this->telp_darurat = '';
//         $this->alamat = '';
//         $this->nama_delegasi = '';
//         $this->detail_delegasi = '';
//         $this->file_up = '';
//     }
}


//     use WithFileUploads;

//     public $jabatan;
//     public $atasan = [];
//     public $name, $jobdesk_id, $head_id, $email, $no_telepon, $jenis_cuti, $detail, $tanggal_mulai, $tanggal_akhir, 
//            $akumulasi = 0, $tanggal_pengajuan, $nama_kontak_darurat, $telp_darurat, $alamat, $hubungan_darurat, $nama_delegasi, $detail_delegasi;
//     public $selectJobdesk, $selectHead;
//     public $cutisId;


//     #[Rule('nullable|file|mimes:jpg,jpeg,png,pdf|max:2048')]
//     public $newAttachment; //simpan file baru (for update)
//     public $file_up; //simpan path file


//     public function render()
//     {
//         $this->jabatan = Jobdesk::getAllJob();

//         return view('livewire.approved.form-pengajuan.form-cuti');
//     }

// // ==============================STORE (CREATE & UPDATE), DELETE, EDIT==============================================
//     public function store()
//     {
//         // dd('KEHIDUPAN TIDAK WORTH IT INI');

//         $this->validate([
//             'name' => 'required|string|max:255',
//             'selectJobdesk' => 'required',
//             'selectHead' => 'required',
//             'email' => 'required|email|max:255',
//             // 'no_telepon' => 'required|string|max:50',
//             'no_telepon' => 'required|string|regex:/^[0-9]+$/|max:15',
//             'jenis_cuti' => 'required|string|max:255',
//             'detail' => 'required|string|max:1000',
//             'tanggal_mulai' => 'required|date|before_or_equal:tanggal_akhir',
//             'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
//             // 'akumulasi' => 'required|min:1',
//             'tanggal_pengajuan' => 'required|date',
//             'nama_kontak_darurat' => 'required|string|max:255',
//             // 'telp_darurat' => 'required|string|max:50',
//             'telp_darurat' => 'required|string|regex:/^[0-9]+$/|max:15',
//             'hubungan_darurat' => 'required|string|max:255',
//             'alamat' => 'required|string|max:1000',
//             'nama_delegasi' => 'required|string|max:255',
//             'detail_delegasi' => 'required|string|max:1000',
//             'newAttachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
//         ]);

//         try {

//             if (!Storage::exists('public/cuti')) {
//                 Storage::makeDirectory('public/cuti');
//             }

//             $filePath = $this->file_up;
//             if ($this->newAttachment) {
//                 if ($this->file_up) {
//                     Storage::delete($this->file_up);
//                 }
//                 $filePath = $this->newAttachment->store('cuti', 'public');
//             }
//             $data = [
//                 'name' => $this->name,
//                 'jobdesk_id' => $this->selectJobdesk,
//                 'head_id' => $this->selectHead,
//                 'email' => $this->email,
//                 'no_telepon' => $this->no_telepon,
//                 'jenis_cuti' => $this->jenis_cuti,
//                 'detail' => $this->detail,
//                 'tanggal_mulai' => $this->tanggal_mulai,
//                 'tanggal_akhir' => $this->tanggal_akhir,
//                 'tanggal_pengajuan' => $this->tanggal_pengajuan,
//                 'nama_kontak_darurat' => $this->nama_kontak_darurat,
//                 'hubungan_darurat' => $this->hubungan_darurat,
//                 'telp_darurat' => $this->telp_darurat,
//                 'alamat' => $this->alamat,
//                 'nama_delegasi' => $this->nama_delegasi,
//                 'detail_delegasi' => $this->detail_delegasi,
//                 'file_up' => $filePath,
//             ];

//             if ($this->cutisId) {
//                 ApprovalCuti::update($data, $this->cutisId);
//                 $message = 'Data Cuti Berhasil di Update!';
//             } else {
//                 ApprovalCuti::create($data);
//                 $message = 'Data Cuti Berhasil di Buat!';
//             }
//             $this->dispatch('close-offcanvas');
//             $this->dispatch('cutiUpdated');
//             $this->dispatch('resetForm');
//             $this->js("alert('$message')");

//         } catch (\Exception $e) {
//             $this->js("alert('Gagal menyimpan data: " . $e->getMessage() ."')");
//         }

        

//         // try {
//         //     if ($this->cutisId) {

               

//         //         if ($this->newAttachment) {
//         //             Storage::delete($this->file_up, 'public');
//         //             $this->newAttachment = $this->newAttachment->store('cutis', 'public');
//         //         }
//         //         ApprovalCuti::update([
//         //             'name' => $this->name,
//         //             'jobdesk_id' => $this->selectJobdesk,
//         //             'head_id' => $this->selectHead,
//         //             'email' => $this->email,
//         //             'no_telepon' => $this->no_telepon,
//         //             'jenis_cuti' => $this->jenis_cuti,
//         //             'detail' => $this->detail,
//         //             'tanggal_mulai' => $this->tanggal_mulai,
//         //             'tanggal_akhir' => $this->tanggal_akhir,
//         //             'akumulasi' => $this->akumulasi,
//         //             'tanggal_pengajuan' => $this->tanggal_pengajuan,
//         //             'nama_kontak_darurat' => $this->nama_kontak_darurat,
//         //             'hubungan_darurat' => $this->hubungan_darurat,
//         //             'telp_darurat' => $this->telp_darurat,
//         //             'alamat' => $this->alamat,
//         //             'nama_delegasi' => $this->nama_delegasi,
//         //             'detail_delegasi' => $this->detail_delegasi,
//         //             'file_up' => $this->newAttachment ?? $this->file_up,
//         //         ], $this->cutisId);
                
//         //         $this->js("alert('Data Cuti Berhasil di Update!')");
//         //     } else {

               

//         //         if ($this->newAttachment) {
//         //             $this->newAttachment = $this->newAttachment->store('cutis', 'public');
//         //         }
//         //         ApprovalCuti::create([
//         //             'name' => $this->name,
//         //             'jobdesk_id' => $this->selectJobdesk,
//         //             'head_id' => $this->selectHead,
//         //             'email' => $this->email,
//         //             'no_telepon' => $this->no_telepon,
//         //             'jenis_cuti' => $this->jenis_cuti,
//         //             'detail' => $this->detail,
//         //             'tanggal_mulai' => $this->tanggal_mulai,
//         //             'tanggal_akhir' => $this->tanggal_akhir,
//         //             'akumulasi' => $this->akumulasi,
//         //             'tanggal_pengajuan' => $this->tanggal_pengajuan,
//         //             'nama_kontak_darurat' => $this->nama_kontak_darurat,
//         //             'hubungan_darurat' => $this->hubungan_darurat,
//         //             'telp_darurat' => $this->telp_darurat,
//         //             'alamat' => $this->alamat,
//         //             'nama_delegasi' => $this->nama_delegasi,
//         //             'detail_delegasi' => $this->detail_delegasi,
//         //             'file_up' => $this->newAttachment,
//         //         ]);
//         //         $this->js("alert('Data Cuti Berhasil di Buat!')");
//         //     }
//         //     $this->dispatch('close-offcanvas');
//         //     $this->dispatch('cutiUpdated');
//         //     $this->dispatch('resetForm');
//         // } catch (\Throwable $th) {
//         //     throw $th;
//         //     $this->js("alert('Tidak Tersimpan')");
//         // }
//     }

//     public function edit($id)
//     {
//         $cuti = ApprovalCuti::getCutiById($id);

//         $this->cutisId = $cuti->id;
//         $this->name = $cuti->name;
//         $this->selectJobdesk = $cuti->jobdesk_id;
//         $this->selectHead = $cuti->head_id;
//         $this->email = $cuti->email;
//         $this->no_telepon = $cuti->no_telepon;
//         $this->jenis_cuti = $cuti->jenis_cuti;
//         $this->detail = $cuti->detail;
//         $this->tanggal_mulai = $cuti->tanggal_mulai;
//         $this->tanggal_akhir = $cuti->tanggal_akhir;
//         $this->akumulasi = $cuti->akumulasi;
//         $this->tanggal_pengajuan = $cuti->tanggal_pengajuan;
//         $this->nama_kontak_darurat = $cuti->nama_kontak_darurat;
//         $this->hubungan_darurat = $cuti->hubungan_darurat;
//         $this->telp_darurat = $cuti->telp_darurat;
//         $this->alamat = $cuti->alamat;
//         $this->nama_delegasi = $cuti->nama_delegasi;
//         $this->detail_delegasi = $cuti->detail_delegasi;
//         $this->file_up = $cuti->file_up;

//         $this->dispatch('show-edit-offcanvas');
//     }

// // =======================================DEPENDENT DROPDOWN========================================================
//     public function loadHead()
//     {
//         if ($this->selectJobdesk) {
//             $this-> atasan = Head::getHeadByJobdesk($this->selectJobdesk);
//         }
//     }

// // ===========================================COUNT AKUMULASI=======================================================
//     public function updatedTanggalMulai()
//     {
//         $this->calculateCuti();
//     }

//     public function updatedTanggalAkhir()
//     {
//         $this->calculateCuti();
//     }

//     public function calculateCuti()
//     {
//         if ($this->tanggal_mulai && $this->tanggal_akhir) {
//             $this->akumulasi = ApprovalCuti::cutiDays($this->tanggal_mulai, $this->tanggal_akhir);
//         }
//     }

// // ======================================HANDLE OFFCANVAS===============================================
//     public function btnClose_Offcanvas()
//     {
//         $this->resetForm();;
//         $this->dispatch('close-offcanvas');
//     }
// // ============================================================RESET===============================================
//     #[On('reset')]
//     public function resetForm()
//     {
//         $this->cutisId = '';
//         $this->name = '';
//         $this->selectJobdesk = '';
//         $this->selectHead = '';
//         $this->email = '';
//         $this->no_telepon = '';
//         $this->jenis_cuti = '';
//         $this->detail = '';
//         $this->tanggal_mulai = '';
//         $this->tanggal_akhir = '';
//         $this->akumulasi = '';
//         $this->tanggal_pengajuan = '';
//         $this->nama_kontak_darurat = '';
//         $this->telp_darurat = '';
//         $this->alamat = '';
//         $this->hubungan_darurat = '';
//         $this->nama_delegasi = '';
//         $this->detail_delegasi = '';
//         $this->file_up = '';
//     }
// }
