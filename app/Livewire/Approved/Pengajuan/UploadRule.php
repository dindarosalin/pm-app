<?php

namespace App\Livewire\Approved\Pengajuan;

use App\Models\Approval\Ketentuan;
use Livewire\Attributes\On;
use Livewire\Component;

class UploadRule extends Component

// =================================CREATE MODAL DI RULE BERHASIL==========================================================
{
    public $rules;

    public function mount()
    {
        $this->getKetentuan();
    }
// ============================GET ALL===========================================================================
    // event listener for reload otomatis
    #[On('ruleUpdated')]
    
    public function getKetentuan()
    {
        $this->rules = Ketentuan::getAll();
    }
  
// ==================================DELETE===============================================================================
    public function deleteRule($id)
    {
        try {
            Ketentuan::delete($id);
            $this->dispatch('ruleUpdated');
            $this->dispatch('alert', [
                'type' => 'success', 
                'message' => 'Data berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'Gagal menghapus data: '.$e->getMessage()
            ]);
        }
    }

// ================================RENDER==================================================================
    public function render()
    {
        // $this->getKetentuan();
        return view('livewire.approved.pengajuan.upload-rule');
    }

}
// ====================================================================================================


// {
//     public $rules;
//     public $ruleEdit;
//     public $id, $file_name, $file_path;
//     public $attachments;
//     public $existingAttachments;

//     public function render()
//     {
//         $this->getKetentuan();
//         return view('livewire.approved.pengajuan.upload-rule');
//     }

//     public function getKetentuan()
//     {
//         $this->rules = Ketentuan::getAll();
//     }

// // ======================================CREATE, EDIT, DELETE=============================================================
//     // EDIT
//     // #[On('edit')]
//     protected $listeners = ['openEditRule' => 'edit'];
//     public function edit($id)
//     {

//         $ruleEdit = Ketentuan::getById($id);
        
//         $this->id = $ruleEdit->id;
//         $this->file_name = $ruleEdit->file_name;
//         $this->file_path = $ruleEdit->file_path;

//         $this->dispatch('show-edit-offcanvas');
//     }

//     // SAVE
//     public function save()
//     {
//         try {
//             if ($this->id) {
//                 Ketentuan::update([
//                     'file_name' => $this->file_name,
//                     'file_path' => $this->file_path,
//                 ], $this->id);

//                 session()->flash('success', 'Data berhasil diperbarui');
//             } else {
//                 // jika tidak ada ID, maka create
//                 Ketentuan::create([
//                     'file_name' => $this->file_name,
//                     'file_path' => $this->file_path,
//                 ]);

//                 session()->flash('success', 'Data berhasil ditambahkan');
//             }
//             $this->dispatch('close-offcanvas');

//             // reset
//             $this->resetForm();

//             // notifikasi sukses
//             $this->dispatch('swal:modal', [
//                 'type' => 'success',
//                 'message' => 'data berhasil disimpan',
//                 'text' => 'perubahan akan segera terlihat di tabel'
//             ]);
//         } catch (\Throwable $th) {
//              // Menangani error
//             session()->flash('error', 'Terjadi kesalahan: ' . $th->getMessage());
//         }
//     }

//     // DELETE
//     #[On('delete')]
//     public function delete($id)
//     {
//         Ketentuan::delete($id);
//         $this->dispatch('swal:modal', [
//             'type' => 'success',
//             'message' => 'Data Deleted',
//             'text' => 'It will not list on the table'
//         ]);
//     }

// // ======================================RESET=============================================================
//     public function resetForm()
//     {
//         $this->id = null;
//         $this->file_name = null;
//         $this->file_path = null;
//     }
// }