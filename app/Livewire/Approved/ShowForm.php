<?php

namespace App\Livewire\Approved;

use App\Models\Approval\Ketentuan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithFileUploads as LivewireWithFileUploads;

use function Laravel\Prompts\alert;

// class ShowForm extends Component
// {

    // use WithFileUploads;

    // // upload file
    // public $file; //simpan file yang diupload
    // public $uploadFileUrl; //simpan URL file yang diupload
    // public $rules; //simpan daftar ketentuan dokumen yang diupload

    // public function mount()
    // {
    //     $this->rules = Ketentuan::getAll(); //get all ketentuan dari database
    // }

    // // Method Upload File
    // public function uploadFile()
    // {
    //     $this->validate([
    //         'file' => 'file|mimes:pdf|max:10240', //validasi file pdf ukuran maksimum 10 mb
    //     ]);

    //     // simpan file dan dapatkan urlnya
    //     $filePath = $this->file->store('uploads', 'public');
    //     $this->uploadFileUrl = asset('storage/' .$filePath); //dapatkan url file yang dapat diakses

    //     // simpan informasi file ke dalam database
    //     Ketentuan::create([
    //         'file_name' => $this->file->getClientOriginalName(),
    //         'file_path' => $filePath,
    //     ]);

    //     // ambil kembali semua dokumen setelah upload
    //     $this->rules = Ketentuan::getAll();

    //     // reset file input
    //     $this->file('file');
    // }
    
    // public function render()
    // {
    //     return view('livewire.approved.show-form');
    // }

    // public function uploadFile($category)
    // {
    //     $this->validate([
    //         'file' => 'mimes:pdf|max:2048',
    //     ]);

    //     // simpan file ke storage/app/public/ketentuan
    //     $filename = $category . '-'. time() . '.' . $this->file->getClientOriginalExtension();
    //     $filepath = $this->file->storeAs('public/ketentuan', $filename);

    //     // simpan ke database 
    //     Ketentuan::create([
    //         'file_name' => $filename,
    //         'file_path' => $filepath
    //     ]);

    //     // buat url file untuk ditampilkan di blade
    //     $this->uploadFileUrl[$category] = asset(str_replace('public/', 'storage/', $filepath));

    //     // reset input setelah upload berhasil
    //     $this->reset('file');
    // }
    // ==================================KODE BARU======================================================
    // use WithFileUploads;

    // #[Rule('sometimes|pdf|max:2048')]
    // public $newRule; //simpan file baru
    // public $pathRule; //simpan path file
    // public $ruleId;

//     public function store()
//     {
//         $this->validate([
//             'file_name' => 'string|max:255',
//             'file_path' => 'nullable|pdf|max:2048'
//         ]);

//         try {
//             if ($this->ruleId) {

//                 if ($this->newRule) {
//                     Storage::delete($this->pathRule, 'public');
//                     $this->newRule = $this->newRule->store('rules', 'public');
//                 }
//                 DB::table('ketentuans')->where('id', $this->ruleId)->update([
//                     'file_name' => $this->file_name,
//                     'file_path' => $this->file_path,
//                 ]);
//                 $this->js("alert('File Ketentun Berhasil Update !')");
//             } else {
//                 if ($this->newRule) {
//                     $this->newRule = $this->newRule->store('rules', 'public');
//                 }
//                 Ketentuan::create([
//                     'file_name' => $this->file_name,
//                     'file_path' => $this->file_path,
//                 ]);
//                 $this->js("alert('Ketentuan Berhasil Diupload !')");
//             }
//         } catch (\Throwable $th){
//             throw $th;
//             $this->js("alert('Unsaved')");
//         }
//     }

//     public function render()
//     {
//         return view('livewire.approved.show-form');
//     }
// }
