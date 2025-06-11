<?php

namespace App\Livewire\Approved\FormPengajuan;

use App\Models\Approval\Cuti;
use App\Models\Approval\Izin;
use App\Models\Projects\Master\Approval;
use App\Models\Projects\Master\Head;
use App\Models\Projects\Master\Jobdesk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormIzin extends Component
{
    use WithFileUploads;

    public $izinId;
    public $name, $jobdesk_id, $head_id, $email, $telepon, $id_jenis_approve, $detail_izin,
           $tgl_mulai, $tgl_akhir, $tgl_ajuan, 
           $nama_darurat, $telp_darurat, $relasi_darurat, $alamat,
           $nama_delegasi, $detail_delegasi;
    // public $permissions = [];
    public $izins = [];
    public $atasan =[], $jabatan = [], $jenisApprove = [];
    public $akumulasi = 0;
    public $selectJobdesk, $selectHead, $jenis_izin;
    public $auth;
    

    
    #[Rule('required|mimes:pdf|max:2048',
    onUpdate: 'sometimes|mimes:pdf|max:2048')]
    public $newAttachment;
    public $file_izin;

    public function mount()
    {
        $this->jabatan = Jobdesk::getAllJob();
        $this->jenisApprove = Approval::getAllApproval();
        $this->tgl_ajuan = now()->format('Y-m-d');
        $this->atasan = Head::getHeadByJobdesk($this->selectJobdesk);
    }

    public function render()
    {
        $this->auth = Auth::user()->user_id;
        return view('livewire.approved.form-pengajuan.form-izin');
    }

    // =====================================STORE===============================================
    public function store()
    {
        // $this->validate([
        //     'selectJobdesk' =>'required',
        //     'selectHead' => 'required',
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|email|max:50',
        //     'telepon' => 'required|string|regex:/^[0-9]+$/|max:15',
        //     'jenis_izin' => 'required|string|max:50',
        //     'detail_izin' => 'nullable|string|max:1000',
        //     'tgl_mulai' => 'required|date|before_or_equal:tgl_akhir',
        //     'tgl_akhir' => 'required|date|after_or_equal:tgl_mulai',
        //     'tgl_ajuan' => 'required|date',
        //     'nama_darurat' => 'nullable|string|max:50',
        //     'telp_darurat' => 'nullable|string|regex:/^[0-9]+$/|max:15',
        //     'relasi_darurat' => 'nullable|string|max:50',
        //     'alamat' => 'required|string',
        //     'nama_delegasi' => 'nullable|string|max:50',
        //     'detail_delegasi' => 'nullable|string|max:1000',
        //     // 'newAttachment' => 'nullable|file|max:10240', // 10MB max
        //     'newAttachment' => 'nullable|image|max:2048',
        // ]);

        try {
            $filePath = $this->file_izin;

            if ($this->newAttachment) {
                if ($this->izinId && $this->file_izin) {
                    Storage::delete($this->file_izin);
                }
                $filePath = $this->newAttachment->store('izin', 'public');
            }
            if ($this->izinId) {
                DB::table('izins')
                    ->where('id', $this->izinId)
                    ->update([
                        'name' => $this->name,
                        'jobdesk_id' => $this->jobdesk_id,
                        'head_id' => $this->head_id,
                        'email' => $this->email,
                        'telepon' => $this->telepon,
                        'id_jenis_approve' => $this->id_jenis_approve,
                        'detail_izin' => $this->detail_izin,
                        'tgl_mulai' => $this->tgl_mulai,
                        'tgl_akhir' => $this->tgl_akhir,
                        'akumulasi' => $this->akumulasi,
                        'tgl_ajuan' => $this->tgl_ajuan,
                        'nama_darurat' => $this->nama_darurat,
                        'telp_darurat' => $this->telp_darurat,
                        'relasi_darurat' => $this->relasi_darurat,
                        'alamat' => $this->alamat,
                        'nama_delegasi' => $this->nama_delegasi,
                        'detail_delegasi' => $this->detail_delegasi,
                        'file_izin' => $filePath,
                        'updated_at' => now()
                ]);
                $this->js("alert('Data Approval Izin Tidak Terencana Berhasil Diupdate!')");
            } else {
                DB::table('izins')->insert([
                    'name' => $this->auth,
                    'jobdesk_id' => $this->jobdesk_id,
                    'head_id' => $this->head_id,
                    'email' => Auth::user()->user_email,
                    'telepon' => $this->telepon,
                    'id_jenis_approve' => $this->id_jenis_approve,
                    'detail_izin' => $this->detail_izin,
                    'tgl_mulai' => $this->tgl_mulai,
                    'tgl_akhir' => $this->tgl_akhir,
                    'akumulasi' => $this->akumulasi,
                    'tgl_ajuan' => $this->tgl_ajuan,
                    'nama_darurat' => $this->nama_darurat,
                    'telp_darurat' => $this->telp_darurat,
                    'relasi_darurat' => $this->relasi_darurat,
                    'alamat' => $this->alamat,
                    'nama_delegasi' => $this->nama_delegasi,
                    'detail_delegasi' => $this->detail_delegasi,
                    'file_izin' => $filePath,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                // $this->js("alert('Data Approval Izin Tidak Terencana Berhasil Dibuat!')");
            }
            $this->dispatch('close-offcanvas');
            $this->dispatch('izinUpdated');
            $this->resetForm();
        } catch (\Throwable $th) {
            throw $th;
            $this->js("alert('Tidak Tersimpan')");
        }

    }

    #[On('editIzin')]
    public function editIzin($id)
    {
        $izins = Izin::getIzinById($id);

        $this->name = $izins->name;
        $this->jobdesk_id = $izins->jobdesk_id;
        $this->head_id = $izins->head_id;
        $this->email = $izins->email;
        $this->telepon = $izins->telepon;
        $this->id_jenis_approve = $izins->id_jenis_approve;
        $this->detail_izin = $izins->detail_izin;
        $this->tgl_mulai = $izins->tgl_mulai;
        $this->tgl_akhir = $izins->tgl_akhir;
        $this->tgl_ajuan = $izins->tgl_ajuan;
        $this->nama_darurat = $izins->nama_darurat;
        $this->telp_darurat = $izins->telp_darurat;
        $this->relasi_darurat = $izins->relasi_darurat;
        $this->alamat = $izins->alamat;
        $this->nama_delegasi = $izins->nama_delegasi;
        $this->detail_delegasi = $izins->detail_delegasi;
        $this->file_izin = $izins->file_izin;

        $this->dispatch('show-edit-offcanvas-izin');
    }

    // =======================================LOAD HEAD==============================================
    public function loadHead()
    {
        if ($this->selectJobdesk) {
            $this->atasan = Head::getHeadByJobdesk($this->selectJobdesk);
        }
    }

    public function updatedSelectJobdesk()
    {
        $this->loadHead();
        $this->head_id = null; // Reset head_id when jobdesk changes
    }
     

    // =======================================CALCULATE AKUMULASI==============================================
    public function calculateIzins()
    {
        if ($this->tgl_mulai && $this->tgl_akhir) {
            $this->akumulasi = Izin::calculateIzin(
                $this->tgl_mulai,
                $this->tgl_akhir
            );
        } else {
            $this->akumulasi = 0;
        }
    }

    public function updatedTglMulai()
    {
        $this->calculateIzins();
    }
    public function updatedTglAkhir()
    {
        $this->calculateIzins();
    }

    // =================================================HANDLE OFF CANVAS==================================================
    public function btnCloseOffcanvas()
    {
        $this->resetForm();
        $this->dispatch('close_offcanvas');
    }
    // ======================================================RESET=========================================================
    #[On('reset')]
    public function resetForm()
    {
        $this->reset([
            'izinId', 'name', 'jobdesk_id', 'head_id', 'email', 'telepon',
            'id_jenis_approve', 'detail_izin', 'tgl_mulai', 'tgl_akhir', 'tgl_ajuan',
            'nama_darurat', 'telp_darurat', 'relasi_darurat', 'alamat',
            'nama_delegasi', 'detail_delegasi', 'newAttachment', 'file_izin'
        ]);
        $this->akumulasi = 0;
        $this->atasan = [];
        $this->resetValidation();
    }
    
       
}


 // $filePath = null;
            // if ($this->newAttachment) {
            //     $filePath = $this->newAttachment->store('izin', 'public');
            // }

            // $filePath = null;
            // if (isset($storeData['file_izin'])) {
            //     $file = $storeData['file_izin'];
            //     $filePath = $file->store('izin','public');
            // }

            // if ($this->izinId) {

            //     if ($filePath) {
            //         Storage::disk('public')->delete($this->file_izin);
            //     }

                // if ($this->newAttachment) {
                //     // Storage::delete($this->file_izin, 'public');
                //     Storage::disk('public')->delete($this->file_izin);
                //     $filePath = $this->newAttachment->store('izin', 'public');
                // }

            //     DB::table('izins')->where('id', $this->izinId)->update([
            //         'name' => $this->name,
            //         'jobdesk_id' => $this->selectJobdesk,
            //         'head_id' => $this->selectHead,
            //         'email' => $this->email,
            //         'telepon' => $this->telepon,
            //         'jenis_izin' => $this->jenis_izin,
            //         'detail_izin' => $this->detail_izin,
            //         'tgl_mulai' => $this->tgl_mulai,
            //         'tgl_akhir' => $this->tgl_akhir,
            //         'akumulasi' => $this->akumulasi,
            //         'tgl_ajuan' => $this->tgl_ajuan,
            //         'nama_darurat' => $this->nama_darurat,
            //         'telp_darurat' => $this->telp_darurat,
            //         'relasi_darurat' => $this->relasi_darurat,
            //         'alamat' => $this->alamat,
            //         'nama_delegasi' => $this->nama_delegasi,
            //         'detail_delegasi' => $this->detail_delegasi,
            //         // 'file_izin' => $this->newAttachment ?? $this->file_izin,
            //         'file_izin' => $filePath ?? $this->file_izin,
            //     ]);
            //     $this->js("alert('Data Izin Tidak Terencana Berhasil Diupdate!')");
            // } else {

                // if ($filePath) {
                //     $filePath = $this->newAttachment->store('izin', 'public');
                // }
            //     Izin::create([
            //         'name' => $this->name,
            //         'jobdesk_id' => $this->selectJobdesk,
            //         'head_id' => $this->selectHead,
            //         'email' => $this->email,
            //         'telepon' => $this->telepon,
            //         'jenis_izin' => $this->jenis_izin,
            //         'detail_izin' => $this->detail_izin,
            //         'tgl_mulai' => $this->tgl_mulai,
            //         'tgl_akhir' => $this->tgl_akhir,
            //         'akumulasi' => $this->akumulasi,
            //         'tgl_ajuan' => $this->tgl_ajuan,
            //         'nama_darurat' => $this->nama_darurat,
            //         'telp_darurat' => $this->telp_darurat,
            //         'relasi_darurat' => $this->relasi_darurat,
            //         'alamat' => $this->alamat,
            //         'nama_delegasi' => $this->nama_delegasi,
            //         'detail_delegasi' => $this->detail_delegasi,
            //         // 'file_izin' => $this->newAttachment,
            //         'file_izin' => $filePath,
            //     ]);
            //     $this->js("alert('Data Izin Tidak Terencana Berhasil Dibuat!')");
            // }
            // $this->dispatch('close-offcanvas');
            // $this->dispatch('izinUpdated');
        //     $this->resetForm();
        // } catch (\Throwable $th) {
            // throw $th;
            // $this->js("alert('Tidak Tersimpan')");
        //     $this->js("alert('Gagal menyimpan izin: " . $th->getMessage() . "')");
        // }

         // $this->name = '';
        // $this->selectJobdesk = '';
        // $this->selectHead = '';
        // $this->email = '';
        // $this->telepon = '';
        // $this->jenis_izin = '';
        // $this->detail_izin = '';
        // $this->tgl_mulai = '';
        // $this->tgl_akhir = '';
        // $this->tgl_ajuan = '';
        // $this->nama_darurat = '';
        // $this->telp_darurat = '';
        // $this->relasi_darurat = '';
        // $this->alamat = '';
        // $this->nama_delegasi = '';
        // $this->detail_delegasi = '';
        // $this->file_izin = '';
        // $this->izinId = '';
    // }