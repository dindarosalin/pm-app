<?php

namespace App\Livewire\Approved\Pengajuan;

use App\Models\Approval\Ketentuan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use function session;

class Rule extends Component
{
    use WithFileUploads;

    public $attachments = []; //simpan file baru yang diupload
    public $existingAttachments = []; //simpan file yang sudah ada
    public $ruleId; //id rule (untuk edit)
    public $newFIleRule; //simpan file baru
    public $jenis; //jenis ketentuan
    public $title;
    
    // edit
    public $showEditModal = false;
// =====================================KONEKSI==============================================================================
    public function mount($title)
    {
        $this->title = $title;
    }

// ========================================SETTING OTOMATIS JENIS==================================================================================
   //    atur jenis ketentuan
    public function setJenis($jenis)
    {
        $this->jenis = $jenis;
    }

// ===========================================CREATE UPDATE DELETE=========================================================================================
    public function store()
    {
        $this->validate([
            'jenis' => 'required',
            //  cek file apakah sudah terisi atau belum, jika belum wajib diisi
            'attachments' => empty($this->existingAttachments) ? 'required' : 'nullable',
        ]);
    
        try {
            if ($this->ruleId) {
                // UPDATE KETENTUAN YANG SUDAH ADA
                $rule = Ketentuan::getById($this->ruleId);
                
                // jenis tidak berubah untuk update (sebagai acuan)
                $data = ['jenis' => $this->jenis];
                
                // Jika ada file baru diupload
                if ($this->attachments) {
                    // Hapus file lama jika ada
                    if (!empty($this->existingAttachments)) {
                        Storage::disk('public')->delete($this->existingAttachments[0]['file_path']);
                    }
                    
                    // Simpan file baru
                    $file = $this->attachments[0];
                    $data['file_name'] = $file->getClientOriginalName();
                    $data['file_path'] = $file->store('rules', 'public');

                    // $originalName = $file->getClientOriginalName();
                    // $filePath = $file->store('rules', 'public');
                    
                    // tambahkan info file ke data update
                    // $data['file_name'] = $originalName;
                    // $data['file_path'] = $filePath;
                }
                
                $rule->update($data); //update data di database
                session()->flash('success', 'Rule Updated Successfully!!');
            } else {
                // BUAT KETENTUAN BARU
                $file = $this->attachments[0]; //ambil file yang diupload
                $originalName = $file->getClientOriginalName(); //nama asli file
                $filePath = $file->store('rules', 'public'); //simpan file
    
                // create record baru di database
                Ketentuan::create([
                    'jenis' => $this->jenis,
                    'file_name' => $originalName,
                    'file_path' => $filePath,
                ]);
                session()->flash('success', 'Rule Created Successfully!!');
            }
    
            $this->dispatch('ruleUpdated');
            $this->resetForm();
            
            // $this->dispatch('close-modal');
            
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
        }
    }

    #[On('editRule')]
    public function edit($id)
    {
        $rule = Ketentuan::getById($id);
        $this->ruleId = $id; //set id ketentuan yang sedang di edit
        $this->jenis = $rule->jenis;
        $this->existingAttachments = [[
            'file_name' => $rule->file_name,
            'file_path' => $rule->file_path
        ]];
        
        // Buka modal
        $this->dispatch('showEditModal');
    }

    public function delete($id)
    {
        try {
            $rule = Ketentuan::getById($id);
            Storage::disk('public')->delete($rule->file_path); //hapus file dari storage
            Ketentuan::delete($id); //hapus record dari database

            $this->dispatch('ruleUpdated');
            $this->dispatch('swal:modal', [
                'type' => 'success', 
                'message' => 'Data terhapus',
                'text' => 'Data berhasil terhapus',
            ]);
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
        }
    }


    // hapus file dari form (baik yang baru diupload atau yang sudah ada)
    public function removeFile($type, $key)
    {
        if ($type === 'new') {
            // Hapus file yang baru diupload (belum disimpan)
            unset($this->attachments[$key]);
        } else {
            // Tambahkan pengecekan sebelum mengakses array
            // Hapus file yang sudah ada (juga hapus dari penyimpanan)
            if (isset($this->existingAttachments[$key]['file_path'])) {
                Storage::disk('public')->delete($this->existingAttachments[$key]['file_path']);
            }
            
            unset($this->existingAttachments[$key]);
            
            // Reset array keys setelah menghapus
            // Susun ulang index array setelah penghapusan
            $this->existingAttachments = array_values($this->existingAttachments);
        }
    }

// =====================================RESET==================================================================
    // kosongkan form ke keadaan awal
    public function resetForm()
    {
        $this->reset(['attachments', 'existingAttachments', 'ruleId', 'jenis']);
    }

// =======================================RENDER==================================================================================================
    public function render()
    {
        return view('livewire.approved.pengajuan.rule');
    }
}

  // if ($type === 'new') {
        //     unset($this->attachments[$key]); //hapus file baru dari array
        // } else {
        //     Storage::disk('public')->delete($this->existingAttachments[$key]['file_path']); //hapus file lama dari storage

        //     // edit
        //     unset($this->existingAttachments[$key]);
        // }

// try {
        //     $rule = Ketentuan::getById($id);
            
        //     // Hapus file dari storage
        //     Storage::disk('public')->delete($rule->file_path);
            
        //     // Hapus record dari database
        //     Ketentuan::delete($id);
            
        //     $this->dispatch('ruleUpdated');
        //     $this->dispatch('swal:modal', [
        //         'type' => 'success',
        //         'message' => 'Data Deleted',
        //         'text' => 'Data has been deleted successfully'
        //     ]);
        // } catch (\Throwable $th) {
        //     session()->flash('error', $th->getMessage());
        // }

// {
    //     // validasi for create and update data (edit)
    //     $this->validate([
    //         'jenis' => 'required',
    //         'attachments' => $this->ruleId ? 'nullable' : 'required',
    //     ]);

    //     $attachmentsPaths = $this->existingAttachments  ?? [];
   
    //     if ($this->attachments) {
    //         foreach ($this->attachments as $file) {
    //             $originalName = $file->getClientOriginalName();
    //             $filePath = $file->store('rules', 'public');
    
    //             $attachmentsPaths[] = [
    //                 'file_name' => $originalName,
    //                 'file_path' => $filePath,
    //             ];
    //         }
    //     }
    //         // Pastikan ada attachment sebelum mengakses index 0
    //         if (empty($attachmentsPaths)) {
    //             session()->flash('error', 'Harap upload file');
    //             return;
    //         }

        
    //     try {
    //         if ($this->ruleId) {
    //             // update data keluar/existing (Edit)
    //             $rule = Ketentuan::getById($this->ruleId);
    //             $rule->update([
    //                 'jenis' =>$this->jenis,
    //                 'file_name' => $attachmentsPaths[0]['file_name'] ?? $rule->file_name,
    //                 'file_path' => $attachmentsPaths[0]['file_path'] ?? $rule->file_path,
    //             ]);

    //             // Ketentuan::update([
    //             //     'jenis' => $this->jenis,
    //             //     'file_name' => $originalName,
    //             //     'file_path' => $filePath,
    //             // ], $this->ruleId);
    //             session()->flash('success', 'Rule Updated Successfully!!');
    //         } else {
    //             // create data baru
    //             Ketentuan::create([
    //                 'jenis' => $this->jenis,
    //                 'file_name' => $attachmentsPaths[0]['file_name'],
    //                 'file_path' => $attachmentsPaths[0]['file_path'],
    //             ]);

    //             // Ketentuan::create([
    //             //     'jenis' => $this->jenis,
    //             //     'file_name' => $originalName,
    //             //     'file_path' => $filePath,
    //             // ]);
    //             session()->flash('success', 'Rule Created Successfully!!');
    //         }

    //         // dispatch load otomatis
    //         $this->dispatch('ruleUpdated');
    //         $this->resetForm();
            
    //         $this->dispatch('swal:modal', [
    //             'type' => 'success',
    //             'message' => 'Data saved',
    //             'text' => 'It will list on the table soon'
    //         ]);

    //     } catch (\Throwable $th) {
    //         session()->flash('error', $th->getMessage());

    //         // session()->flash('error', $th);
    //     }
    // }




    // use WithFileUploads;

    // public $attachments = [], $existingAttachments = []; //simpan path file
    // public $ruleId;
    // public $title;
    // public $newFileRule; //simpan file baru
    // public $jenis; 
    
    // public function mount($title)
    // {  
    //     $this->title = $title;
    // }
// ====================================CREATE UPDATE DELETE==============================================================================
    // CREATE DAN UPDATE
    // public function store()
    // {
    //     $attachmentsPaths = $this->existingAttachments  ?? [];

    //     if ($this->attachments) {
    //         foreach ($this->attachments as $file) {
    //             $originalName = $file->getClientOriginalName();
    //             $filePath = $file->store('rules', 'public');

    //             $attachmentsPaths[] = [
    //                 'file_name' => $originalName,
    //                 'file_path' => $filePath,
    //             ];
    //         }
    //     }

    //     try {
    //         if ($this->ruleId) {
    //             Ketentuan::update([
    //                 'file_name' => $originalName,
    //                 'file_path' => $filePath,
    //             ], $this->ruleId);
    //             session()->flash('success', 'Rule Updated Successfully!!');
    //         } else {
    //             // dd('halo');
    //             Ketentuan::create([
    //                 'file_name' => $originalName,
    //                 'file_path' => $filePath,
    //             ]);
    //             session()->flash('success', 'Project Created Successfully!!');
    //         }

    //         // dispatch load otomatis
    //         $this->dispatch('ruleUpdated');
            
    //         $this->dispatch('swal:modal', [
    //             'type' => 'success',
    //             'message' => 'Data saved',
    //             'text' => 'It will list on the table soon'
    //         ]);
    //     }  catch (\Throwable $th) {
    //         session()->flash('error', $th);
    //     }
    // }

    // public function removeFile($type, $key)
    // {
    //     if ($type === 'new') {
    //         unset($this->attachments[$key]);
    //     } else {
    //         Storage::disk('public')->delete($this->existingAttachments[$key]['path']);
    //         unset($this->existingAttachments[$key]);
    //     }
    // }

    // public function render()
    // {
    //     return view('livewire.approved.pengajuan.rule');

    // }