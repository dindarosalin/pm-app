<?php
// KODE YANG FIKS DIPAKE UNTUK FITUR UPLOAD RULE
namespace App\Livewire\Approved\Pengajuan;

use App\Models\Approval\Ketentuan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormRule extends Component
{
    use WithFileUploads;

    public $title; //koneksi
    public $ruleId; // ID untuk edit
    public $jenis, $file_name; // Jenis ketentuan
    public $rules = [];
    // public $file; // File yang diupload (Livewire temporary upload)
    // public $existingFilePath; // Path file yang sudah ada (untuk edit)
    // public $existingFileName; // Nama file yang sudah ada (untuk edit)

    // Rules untuk validasi
    #[Rule('required|mimes:pdf|max:2048',
    onUpdate: 'sometimes|mimes:pdf|max:2048')]
    public $newAttachment; //simpan file baru
    public $file_path; // simpan path file


    public function render()
    {
        return view('livewire.approved.pengajuan.form-rule');
    }

// =================================================================================================
    public function mount($title)
    {
        $this->title = $title;
    }

// =======================================================STORE======================================
    public function store()
    {
        // dd('store dipanggil');
        // validate
        $this->validate([
            'jenis' => 'required|string|max:255',
            // 'file_name' => 'required|string|max:255',
            // 'newAttachment' => 'nullable|mimes:pdf|max:2048',
            'newAttachment' => $this->ruleId ? 'sometimes|mimes:pdf|max:2048' : 'required|mimes:pdf|max:2048',
        ]);
        // ]);

        try {
            $filePath = $this->file_path;

        if ($this->newAttachment) {
            // Hapus file lama jika ada (untuk update)
            if ($this->ruleId && $this->file_path) {
                Storage::delete($this->file_path);
            }
            $filePath = $this->newAttachment->store('rules', 'public');
        }

        if ($this->ruleId) {
            // UPDATE menggunakan Query Builder
            DB::table('ketentuans')
                ->where('id', $this->ruleId)
                ->update([
                    'jenis' => $this->jenis,
                    'file_name' => $this->newAttachment ? $this->newAttachment->getClientOriginalName() : basename($this->file_path),
                    'file_path' => $filePath,
                    'updated_at' => now(),
                ]);
        } else {
            // CREATE menggunakan Query Builder
            DB::table('ketentuans')->insert([
                'jenis' => $this->jenis,
                'file_name' => $this->newAttachment->getClientOriginalName(),
                'file_path' => $filePath,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->dispatch('close-offcanvas');
        $this->dispatch('ruleUpdated');
        $this->resetForm();

            // if ($this->ruleId) {

            //     if ($this->newAttachment) {
            //         Storage::delete($this->file_path, 'public');
            //         $this->newAttachment = $this->newAttachment->store('rules', 'public');
            //     }
            //     DB::table('ketentuans')->where('id', $this->ruleId)->update([
            //         'jenis' => $this->jenis,
            //         'file_name' => $this->file_name,
            //         'file_path' => $this->newAttachment ?? $this->file_path,
            //     ]);
            // } else {
            //     if ($this->newAttachment) {
            //         $this->newAttachment = $this->newAttachment->store('rules', 'public');
            //     }
            //     Ketentuan::create([
            //         'jenis' => $this->jenis,
            //         'file_name' => $this->file_name,
            //         'file_path' => $this->newAttachment,
            //     ]);
            //     $this->js("alert('Ketentuan Berhasil Dibuat!')");
            // }
            // $this->dispatch('close-offcanvas');
            // $this->dispatch('ruleUpdated');
            // $this->resetForm();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

// ==================================================EDIT==================================================================
    #[On('edit')]
    public function edit($id)
    {
        $rules = Ketentuan::getById($id);

        $this->ruleId = $rules->id;
        $this->jenis = $rules->jenis;
        $this->file_name = $rules->file_name;
        $this->file_path = $rules->file_path;

        $this->dispatch('show-edit-offcanvas');
    }

// ==================================================HANDLE CLOSE============================================================
    public function btnClose_Offcanvas()
    {
        $this->resetForm();
        $this->dispatch('close_offcanvas');
    }

// ======================================================RESET================================================================
    #[On('reset')]
    public function resetForm()
    {
        $this->jenis = '';
        $this->file_name = '';
        $this->file_path = '';
        $this->ruleId = '';
    }
}
