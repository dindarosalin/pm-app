<?php

namespace App\Livewire\Approved\Pengajuan;

use App\Models\Approval\Ketentuan;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditformRule extends Component
{
    use WithFileUploads;
    public $ruleId;
    public $file_name;
    public $file_path;
    public $newFileRule; //simpan file baru

    public $showOffcanvas = false; //kontrol visibilitas offcanvas

    // protected $listeners = ['editRule' => 'edit']; //listener for offcanvas edit dg get id offcanvas

    public function mount($ruleId)
    {
        $this->loadData($ruleId);
    }

    public function loadData($ruleId)
    {
        $rule = Ketentuan::getById($ruleId);

        if ($rule) {
            $this->ruleId = $rule->id;
            $this->file_name =$rule->file_name;
            $this->file_path = $rule->file_path;
        }
    }

    public function update()
    {
        $this->validate([
            'file_name' => 'required|string|max:255',
            'newFileRule' => 'nullable|file|max:2048',
        ]);

        try {
            $rule = Ketentuan::getById($this->ruleId);

            if (!$rule) {
                session()->flash('error', 'Data tidak ditemukan');
                return;
            }

            $filePath = $rule->file_path;

            // file baru masuk, hapus file lama dan upload yang baru
            if ($this->newFileRule) {
                Storage::disk('public')->delete($filePath);
                $filePath = $this->newFileRule->store('rules', 'public');
            }

            Ketentuan::update([
                'file_name' => $this->file_name,
                'file_path' => $filePath,
            ], $this->ruleId);

            session()->flash('success', 'Ketentuan berhasil diupdate');
            $this->dispatch('ruleUpdated'); //refresh data di tabel
        } catch (\Throwable $th) {
            session()->flash('error', 'Terjadi kesalahan saat memperbarui data');
        }
    }

    public function render()
    {
        return view('livewire.approved.pengajuan.editform-rule');
    }
}
