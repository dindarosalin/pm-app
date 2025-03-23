<?php

namespace App\Livewire\Approved\Pengajuan;

use App\Models\Approval\Ketentuan;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditformRule extends Component
{
    use WithFileUploads;
    public $ruleId;
    public $file_name;
    public $file_path;
    public $newFileRule; //simpan file baru
    public $title;


  // =========================================LOAD DATA OTOMATIS=================================================================
    #[On('openEditRule')]
    public function loadData($data)
    {
        $ruleId = $data['id']; //get ID dari data yang dikirim
        $rule = Ketentuan::getById($ruleId);

        if ($rule) {
            $this->ruleId = $rule->id;
            $this->file_name =$rule->file_name;
            $this->file_path = $rule->file_path;
        }

        // open edit offcanvas
        $this->dispatch('show-edit-offcanvas');
    }

// ==========================================DELETE, UPDATE============================================================================================
    public function update()
    {
        $this->validate([
            'file_name' => 'required|string|max:255',
            'file_path' => 'nullable|file|max:2048',
        ]);

        try {
            $rule = Ketentuan::getById($this->ruleId);

            if (!$rule) {
                session()->flash('error', 'Data tidak ditemukan!');
                return;
            }

            // jika ada file baru, hapus file lama dan simpan yang baru
            if ($this->newFileRule) {
                Storage::disk('public')->delete($rule->file_path); //hapus file lama
                $filePath = $this->newFileRule->store('rules', 'public');

                $rule->update([
                    'file_name' => $this->file_name,
                    'file_path' => $filePath,
                ]);
            } else {
                // jika tidak ada file baru, cukup update nama file
                $rule->update([
                    'file_name' => $this->file_name,
                ]);
            }

            // tampilkan pesan sukses
            session()->flash('success', 'Data berhasil diperbarui!');
            $this->dispatch('ruleUpdated');

            // reset form
            session()->flash(['file_name', 'newFileRule', 'ruleId']);
        } catch (\Throwable $th) {
            session()->flash('error', 'Terjadi kesalahan:' . $th->getMessage());
        }
    }

    public function mount($title)
    {
        $this->title = $title;
    }

    public function render()
    {
        return view('livewire.approved.pengajuan.editform-rule');
    }
   

   
}

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