<?php

namespace App\Livewire\Approved\Pengajuan;

use App\Models\Approval\Ketentuan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use function session;

class Rule extends Component
{
    use WithFileUploads;

    public $attachments = []; //simpan file baru yang diupload
    public $existingAttachments = []; //simpan file yang sudah ada
    public $ruleId;
    public $newFIleRule; //simpan file baru
    public $jenis; //jenis ketentuan
    public $title;
    
// =====================================KONEKSI==============================================================================
    public function mount($title)
    {
        $this->title = $title;
    }
// ========================================SETTING OTOMATIS JENIS==================================================================================
    public function setJenis($jenis)
    {
        $this->jenis = $jenis;
    }
// ===========================================CREATE UPDATE DELETE=========================================================================================
    public function store()
    {
        $attachmentsPaths = $this->existingAttachments  ?? [];
   
        if ($this->attachments) {
            foreach ($this->attachments as $file) {
                $originalName = $file->getClientOriginalName();
                $filePath = $file->store('rules', 'public');
    
                $attachmentsPaths[] = [
                    'file_name' => $originalName,
                    'file_path' => $filePath,
                ];
            }
        }
        try {
            if ($this->ruleId) {
                Ketentuan::update([
                    'jenis' => $this->jenis,
                    'file_name' => $originalName,
                    'file_path' => $filePath,
                ], $this->ruleId);
                session()->flash('success', 'Rule Updated Successfully!!');
            } else {
                Ketentuan::create([
                    'jenis' => $this->jenis,
                    'file_name' => $originalName,
                    'file_path' => $filePath,
                ]);
                session()->flash('success', 'Project Created Successfully!!');
            }

            // dispatch load otomatis
            $this->dispatch('ruleUpdated');
            
            $this->dispatch('swal:modal', [
                'type' => 'success',
                'message' => 'Data saved',
                'text' => 'It will list on the table soon'
            ]);

        } catch (\Throwable $th) {
            session()->flash('error', $th);
        }
    }

    // public function removeFile($type, $key)
    // {
    //     if ($type === 'new') {
    //         unset($this->attachments[$key]); //hapus file baru dari array
    //     } else {
    //         Storage::disk('public')->delete($this->existingAttachments[$key]['file_path']); //hapus file lama dari storage
    //     }
    // }
// =======================================RENDER==================================================================================================
    public function render()
    {
        return view('livewire.approved.pengajuan.rule');
    }
}


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