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

    public $attachments = [], $existingAttachments = []; //simpan path file
    public $ruleId;
    public $title;
    
   
    public $newFileRule; //simpan file baru
    
    public function mount($title)
    {  
        $this->title = $title;
    }

    // CREATE DAN UPDATE
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
                    'file_name' => $originalName,
                    'file_path' => $filePath,
                ], $this->ruleId);
                session()->flash('success', 'Rule Updated Successfully!!');
            } else {
                // dd('halo');
                Ketentuan::create([
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
        }  catch (\Throwable $th) {
            session()->flash('error', $th);
        }
    }

    public function removeFile($type, $key)
    {
        if ($type === 'new') {
            unset($this->attachments[$key]);
        } else {
            Storage::disk('public')->delete($this->existingAttachments[$key]['path']);
            unset($this->existingAttachments[$key]);
        }
    }

    public function render()
    {
        // return view('livewire.approved.pengajuan.rule', [
        //     'title' => $this->title, //kirim ke view blade 
        // ]);
        return view('livewire.approved.pengajuan.rule');

    }
}

// Update File
    // public function updateFile()
    // {
    //     $this->validate([
    //         'file' => 'file|max:2048|mimes:jpg,jpeg,png,pdf', //max 2mb
    //     ]);

    //     $this->filePath = $this->file->temporaryUrl();
    //     $this->fileName = $this->file->getClientOriginalName();
    // }

    // public $file; //upload file
    // public $fileName;
    // public $existingFiles;

    // public function store()
    // {
    //     $this->validate([
    //         'newFileRule' => 'required|mimes:pdf|max:2048', // Hanya file PDF dengan max size 2MB
    //     ]);

    //     $filePath = $this->newFileRule->store('uploads', 'public');
    //     $this->filePath = $filePath;

    //     session()->flash('message', 'File berhasil diunggah.');
    // }

        // validate
        // $this->validate([
        //     // 'file_name' => 'string|max:255',
        //     // 'file_path' => 'nullable|mimes:pdf|max:2048',

        //     'newFileRule' => 'nullable|mimes:pdf|max:2048', // Hanya file PDF dengan max size 2MB
        // ]);

        // try {
        //     if ($this->ruleId) {
        //         if ($this->newFileRule) {
        //             Storage::delete($this->filePath, 'public');
        //             $this->newFileRule = $this->newFileRule->store('rule_files', 'public');
        //         }

        //         DB::table('ketentuans')->where('id', $this->roleId)->update([
        //             'file_name' => $this->fileName,
        //             'file_path' =>$this->newFileRule ?? $this->filePath,
        //         ]);
        //         $this->js("alert('File Ketentuan berhasil di update')");
        //     } else {
        //         if ($this->newFileRule) {
        //             $this->newFileRule = $this->newFileRule->store('rule_files', 'public');
        //         }
        //         Ketentuan::create([
        //             'file_name' => $this->fileName,
        //             'file_path' => $this->newFileRule,
        //         ]);
        //         $this->js("alert('File Ketentuan Berhasil di upload')");
        //     }
        // } catch (\Throwable $th) {
        //     throw $th;
        //     $this->js("alert('unsaved')");
        // }

         // public function mount($title = "Form Approval")
    // {
    //     $this->title = $title;
    //     $this->existingFiles = Ketentuan::getAll(); //get all file pada database

    //     // $this->userRole = session('role'); //get peran dari session
    //     $this->userRole = Auth::user()->role->role_name ?? 'Super Admin'; //ambil role by user login
    // }

    // Save File, Upload, Validasi
    // public function store()
    // {
    //     // validasi untuk HR yang bisa upload file
    //     if ($this->userRole !== 'Super Admin') {
    //         session()->flash('error', 'Anda tidak memiliki izin untuk mengunggah file');
    //         return;
    //     }

    //     // simpan file
    //     $this->validate([
    //         'file' => 'file|max:2048|mimes:jpg,jpeg,png,pdf',
    //     ]);

    //     // save file ke storage (2)
    //     $filePath = $this->file->store('rule_file', 'public');
    //     $fileName = $this->file->getClientOriginalName();

    //     // save file ke storage
    //     // $path = $this->file->store('rule_file', 'public');

    //     // save data ke database (2)
    //     Ketentuan::create([
    //         'file_name' => $fileName,
    //         'file_path' => $filePath,
    //         'created_at' => now(),
    //         // 'uploaded_by' => Auth::id(), //simpan ID pengguna yang unggah (HR)
    //     ]);

    //     // save data ke database
    //     // Ketentuan::create([
    //     //     'file_name' => $this->fileName,
    //     //     'file_path' => $path,
    //     // ]);

    //     // reset input setelah diupload (2)
    //     $this->file = null;
    //     $this->existingFiles = Ketentuan::getAll();
        
    //     session()->flash('message', 'File berhasil diunggah');

    //     // reset input setelah diupload
    //     // $this->file = null;
    //     // $this->fileName = null;
    //     // $this->filePath = null;

    //     // refresh daftar file
    //     // $this->existingFiles = Ketentuan::getAll();

    //     // session()->flash('message', 'file berhasil diunggah');
    // }

    // delete File
    // public function delete($id)
    // {
    //     $file = Ketentuan::getById($id);

    //     // validasi HR saja yang bisa hapus
    //     if ($this->userRole !== 'HR') {
    //         session()->flash('error', 'Anda tidak memiliki izin untuk menghapus file');
    //         return;
    //     }

    //     if ($file) {
    //         // hapus file dari storage
    //         Storage::disk('public')->delete($file->file_path);
    //         // hapus dari database
    //         Ketentuan::delete($id);
    //         // refresh daftar file
    //         $this->existingFiles = Ketentuan::getAll();

    //         session()->flash('message', 'file berhasil dihapus');
    //     }
    // }