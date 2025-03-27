<?php

namespace App\Livewire\Approved\Pengajuan;

use App\Models\Approval\Ketentuan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditformRule extends Component
{
    use WithFileUploads;

    public $ruleId;
    public $jenis;
    public $file_name;
    public $title;

    #[Rule('required|sometimes|file|max:2048')]
    public $newFile; //simpan file baru
    public $file_path; //simpan path file

// =================================MOUNT================================================= 
    // Koneksi
    public function mount($title)
    {
        $this->title = $title;
    }

// =================================STORE (CREATE & UPDATE), EDIT================================================= 
    // Create  & Update
    public function store()
    {
        $this->validate([
            'jenis' => 'required|string|max:255',
            'file_name' => 'required|string|max:255',
            'newFile' => 'nullable|file|max:2048',
        ]);

        try {
            if ($this->ruleId) {
                
                if ($this->newFile) {
                    Storage::delete($this->file_path, 'public');
                    $this->newFile = $this->newFile->store('rules', 'public');
                }

                DB::table('ketentuans')->where('id', $this->ruleId)->update([
                    'jenis' => $this->jenis, 
                    'file_name' => $this->file_name,
                    'file_path' => $this->newFile ?? $this->file_path,
                ]);
                $this->js("alert('Ketentuan berhasil diperbarui!')"); 
            } else {
                if ($this->newFile) {
                    $this->newFile = $this->newFile->store('rules', 'public');
                }
                Ketentuan::create([
                    'jenis' => $this->jenis,
                    'file_name' => $this->file_name,
                    'file_path' => $this->newFile,
                ]);
                $this->js("alert('Ketentuan berhasil dibuat!')");
            }
            $this->dispatch('close-offcanvas');
            $this->dispatch('ruleUpdated');
            $this->resetForm();
        } catch (\Throwable $th) {
            throw $th;
            $this->js("alert('Unsaved')");
        }
    }

    #[On('edit')]
    public function edit($id)
    {
        $rule = Ketentuan::getById($id);

        $this->ruleId = $rule->id;
        $this->file_name = $rule->file_name;
        $this->file_path = $rule->file_path;

        $this->dispatch('show-edit-offcanvas');
    }

// =================================HANDLE CLOSE=================================================
    // HANDLE CLOSE
    public function btnClose_Offcanvas()
    {
        $this->resetForm();
        $this->dispatch('close_offcanvas');
    }

// =================================RESET FORM=================================================
    #[On('reset')]
    public function resetForm()
    {
        $this->jenis = '';
        $this->file_name = '';
        $this->file_path = '';
        $this->ruleId = '';
    }

// =================================RENDER=================================================
    public function render()
    {
        return view('livewire.approved.pengajuan.editform-rule');
    }
}




// {
//     use WithFileUploads;

//     public $ruleId;
//     public $file_name;
//     public $file_path;
//     public $newFileRule; //simpan file baru
//     public $title;
//     public $jenis; //simpan jenis ketentuan


//   // =========================================LOAD DATA OTOMATIS=================================================================
//     #[On('openEditRule')]
//     public function loadData($id)
//     {
//     //   $ruleId = $data['id']; // get ID dari data yang dikirim
//       $rule = Ketentuan::getById($id);
//     // $rule = DB::table('ketentuans')->where('id', $ruleId)->first();

//     //   if ($rule) {
//           $this->ruleId = $rule->id;
//           $this->file_name = $rule->file_name;
//           $this->file_path = $rule->file_path;
//           $this->jenis = $rule->jenis; // isi nilai dari jenis ketentuan
//     //   }

//       // open edit offcanvas
//       $this->dispatch('show-edit-offcanvas');
//     }

// // ==========================================DELETE, UPDATE============================================================================================
//     public function update()
//     {
//         $this->validate([
//             'file_name' => 'required|string|max:255',
//             'newFileRule' => 'nullable|file|max:2048',
//         ]);

//         try {
//             // $rule = Ketentuan::getById($this->ruleId);
//             $ruleUpdate = ['file_name' => $this->file_name];

//             // jika ada file baru
//             if ($this->newFileRule) {
//                 // hapus file lama
//                 Storage::disk('public')->delete($this->file_path);

//                 // simpan file baru
//                 $filePath = $this->newFileRule->store('rules', 'public');
//                 $ruleUpdate['file_name'] = $this->newFileRule->getClientOriginalName();
//                 $ruleUpdate['file_path'] = $filePath;
//             }

//             // Update Data
//             Ketentuan::update($ruleUpdate, $this->ruleId);

//             // refresh data dan tutup offcanvas
//             $this->dispatch('ruleUpdated');
//             $this->dispatch('alert', [
//                 'type' => 'success',
//                 'message' => 'Data berhasil diperbarui'
//             ]);

//             // reset file baru
//             $this->reset(['newFileRule']);
//         } catch (\Exception $e) {
//             $this->dispatch('alert', [
//                 'type' => 'error',
//                 'message' => 'Gagal update data: '.$e->getMessage()
//             ]);
//         }

//             // if (!$rule) {
//             //     session()->flash('error', 'Data tidak ditemukan!');
//             //     return;
//             // }

//             // jika ada file baru, hapus file lama dan simpan yang baru
//             // if ($this->newFileRule) {
//             //     Storage::disk('public')->delete($rule->file_path); // hapus file lama
//             //     $filePath = $this->newFileRule->store('rules', 'public');

//             //     $rule->update([
//             //         'file_name' => $this->file_name,
//             //         'file_path' => $filePath,
//             //     ]);
//             // } else {
//                 // jika tidak ada file baru, cukup update nama file
//         //         $rule->update([
//         //             'file_name' => $this->file_name,
//         //         ]);
//         //     }

//         //     // tampilkan pesan sukses
//         //     session()->flash('success', 'Data berhasil diperbarui!');
//         //     $this->dispatch('ruleUpdated');

//         //     // reset form
//         //     $this->reset(['file_name', 'newFileRule', 'ruleId']);
//         // } catch (\Throwable $th) {
//         //     session()->flash('error', 'Terjadi kesalahan:' . $th->getMessage());
//         // }
//     }

//     public function mount($title)
//     {
//         $this->title = $title;
//     }

//     public function render()
//     {
//         return view('livewire.approved.pengajuan.editform-rule');
//     }
   

   
// }

 // public function mount($ruleId)
    // {
    //     $this->loadData($ruleId);
    // }

     // public function removeFile($type)
    // {
    //     if ($type === 'new') {
    //         $this->newFileRule = null; // Hapus file baru
    //     } else {
    //         Storage::disk('public')->delete($this->file_path); // Hapus file lama
    //         $this->file_path = null;
    //     }
    // }

    // public function update()
    // {
    //     $this->validate([
    //         'file_name' => 'required|string|max:255',
    //         'newFileRule' => 'nullable|file|max:2048',
    //     ]);

    //     try {
    //         $rule = Ketentuan::getById($this->ruleId);

    //         if (!$rule) {
    //             session()->flash('error', 'Data tidak ditemukan');
    //             return;
    //         }

    //         $filePath = $rule->file_path;

    //         // Jika ada file baru, hapus file lama dan upload yang baru
    //         if ($this->newFileRule) {
    //             Storage::disk('public')->delete($filePath);
    //             $filePath = $this->newFileRule->store('rules', 'public');
    //         }

    //         Ketentuan::update([
    //             'file_name' => $this->file_name,
    //             'file_path' => $filePath,
    //         ], $this->ruleId);

    //         session()->flash('success', 'Ketentuan berhasil diupdate');
    //         $this->dispatch('ruleUpdated'); // Refresh data di tabel
    //     } catch (\Throwable $th) {
    //         session()->flash('error', 'Terjadi kesalahan saat memperbarui data');
    //     }
    // }