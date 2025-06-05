<?php

namespace App\Livewire\Approved\FormPengajuan;

use App\Livewire\Master\Approved\Atasan;
use App\Models\Approval\Cuti as ApprovalCuti;
use App\Models\Projects\Master\Approval;
use App\Models\Projects\Master\Head;
use App\Models\Projects\Master\Jobdesk;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class FormCuti extends Component
{
    use WithFileUploads;

    public $cutiId;
    public $name, $jobdesk_id, $head_id, $email, $no_telepon, $id_jenis_approve, $detail,
           $tanggal_mulai, $tanggal_akhir, $tanggal_pengajuan, $nama_kontak_darurat, 
           $telp_darurat, $alamat, $hubungan_darurat, $nama_delegasi, $detail_delegasi;
    public $cutis = [];
    public $atasan = [], $jabatan = [], $jenisApprove = [];
    public $akumulasi = 0;
    public $selectJobdesk, $selectHead, $jenis_cuti;
    public $auth;


    #[Rule('required|mimes:pdf|max:2048',
    onUpdate: 'sometimes|mimes:pdf|max:2048')]
    public $newAttachment; //simpan file baru
    public $file_up; // simpan path file

    public function mount()
    {
        $this->jabatan = Jobdesk::getAllJob();
        $this->jenisApprove = Approval::getAllApproval();
        $this->tanggal_pengajuan = now()->format('Y-m-d');
        $this->atasan = Head::getHeadByJobdesk($this->selectJobdesk);
    }

    public function render()
    {
        $this->auth = Auth::user()->user_id;
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
                        'name' => $this->auth,
                        'jobdesk_id' => $this->jobdesk_id,
                        'head_id' => $this->head_id,
                        'email' => $this->email,
                        'no_telepon' => $this->no_telepon,
                        'id_jenis_approve' => $this->id_jenis_approve,
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
                    'name' => $this->auth,
                    'jobdesk_id' => $this->jobdesk_id,
                    'head_id' => $this->head_id,
                    'email' => Auth::user()->user_email,
                    'no_telepon' => $this->no_telepon,
                    'id_jenis_approve' => $this->id_jenis_approve,
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
            $this->dispatch('cutiUpdated');
            $this->resetForm();
        } catch (\Throwable $th) {
            throw $th;
            $this->js("alert('Tidak Tersimpan')");
        }
    }


    #[On('editCuti')]
    public function editCuti($id)
    {
        $cutis = ApprovalCuti::getById($id);
        
        $this->cutiId = $cutis->id;
        $this->name = $cutis->name;
        $this->jobdesk_id = $cutis->jobdesk_id;
        $this->head_id = $cutis->head_id;
        $this->email = $cutis->email;
        $this->no_telepon = $cutis->no_telepon;
        $this->id_jenis_approve = $cutis->id_jenis_approve;
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

    public function updatedSelectJobdesk()
    {
        $this->loadHead();
        $this->head_id = null; // Reset head_id when jobdesk changes
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
            'cutiId', 'name', 'jobdesk_id', 'head_id'   , 'email', 'no_telepon',
            'id_jenis_approve', 'detail', 'tanggal_mulai', 'tanggal_akhir', 'tanggal_pengajuan',
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
}



