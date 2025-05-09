<?php

namespace App\Livewire\Approved\FormPengajuan;

use App\Models\Approval\PengadaanProyek;
use App\Models\Employee\Department;
use App\Models\Projects\Master\Jobdesk;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Throwable;

class FormPengadaan extends Component
{
    public $nama_proyek, $kode_dokumen, $tanggal_ajuan, $id_department, $nama_pemohon, $lokasi, $ditujukan, $tanggal_setuju;
    public $pengadaanId;
    public $pengadaan;
    public $departments;
    public $selectDepartment;


    public function render()
    {
        $this->departments = Jobdesk::getAllJob();
        return view('livewire.approved.form-pengajuan.form-pengadaan');
    }

    // ======================================CREATE, UPDATE, DELETE, EDIT========================================
    public function store()
    {
        $this->validate([
            'nama_proyek' => 'required',
            'kode_dokumen' => 'required',
            'tanggal_ajuan' => 'required|date',
            'id_department' => 'required',
            'nama_pemohon' => 'required',
            'lokasi' => 'required',
            'ditujukan' => 'required',
            'tanggal_setuju' => 'required|date',
        ]);

        try {
            if ($this->pengadaanId) {
                DB::table('proyeks')
                    ->where('id', $this->pengadaanId)
                    ->update([
                        'nama_proyek' => $this->nama_proyek,
                        'kode_dokumen' => $this->kode_dokumen,
                        'tanggal_ajuan' => $this->tanggal_ajuan,
                        'id_department' => $this->selectDepartment,
                        'nama_pemohon' => $this->nama_pemohon,
                        'lokasi' => $this->lokasi,
                        'ditujukan' => $this->ditujukan,
                        'tanggal_setuju' => $this->tanggal_setuju,
                        'updated_at' => now(),
                    ]);
            } else {
                // create
                DB::table('proyeks')->insert([
                    'nama_proyek' => $this->nama_proyek,
                    'kode_dokumen' => $this->kode_dokumen,
                    'tanggal_ajuan' => $this->tanggal_ajuan,
                    'id_department' => $this->id_department,
                    'nama_pemohon' => $this->nama_pemohon,
                    'lokasi' => $this->lokasi,
                    'ditujukan' => $this->ditujukan,
                    'tanggal_setuju' => $this->tanggal_setuju,
                    'created_at' => now(),  
                    'updated_at' => now(),
                ]);
            }
            $this->dispatch('close-offcanvas'); //offcanvas tutup otomatis
            // $this->dispatch('pengadaanUpdated'); //load otomatis
            $this->resetForm(); //reset otomatis
        } catch (Throwable $th) {
            $this->js("alert('Data gagal disimpan')");
        }
    }

    #[On('edit')] //get data for dispatch
    public function edit($id)
    {
        // get data for form edit
        $this->pengadaan = PengadaanProyek::edit($id);
        $this->pengadaanId = $this->pengadaan->id;
        $this->nama_proyek = $this->pengadaan->nama_proyek;
        $this->kode_dokumen = $this->pengadaan->kode_dokumen;
        $this->tanggal_ajuan = $this->pengadaan->tanggal_ajuan;
        $this->id_department = $this->pengadaan->id_department;
        $this->nama_pemohon = $this->pengadaan->nama_pemohon;
        $this->lokasi = $this->pengadaan->lokasi;
        $this->ditujukan = $this->pengadaan->ditujukan;
        $this->tanggal_setuju = $this->pengadaan->tanggal_setuju;

        $this->dispatch('show-edit-offcanvas');
    }

    // ========================================RESET FORM========================================
    public function resetForm()
    {
        $this->nama_proyek = '';
        $this->kode_dokumen = '';
        $this->tanggal_ajuan = '';
        $this->id_department = '';
        $this->nama_pemohon = '';
        $this->lokasi = '';
        $this->ditujukan = '';
        $this->tanggal_setuju = '';
    }

    // ========================================HANDLE OFF CANVAS========================================
    public function btnCloseOffcanvas()
    {
        $this->resetForm();
        $this->dispatch('close-offcanvas');
    }

    
}
