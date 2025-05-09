<?php

namespace App\Livewire\Approved\FormPengajuan;

use App\Models\Approval\Reimburse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Throwable;

class FormReimburse extends Component
{
    use WithFileUploads;
    public $reimburse;
    public $reimburseId;
    public $kebutuhan, $uom, $quantity = 1, $unit_price = 0, $purchase_date;
    public $total_per_item;

    #[Rule('required|sometimes|image|max:2048')]
    public $newAttachment; //simpan file baru
    public $attachment; //simpan path file


    public function render()
    {
        return view('livewire.approved.form-pengajuan.form-reimburse');
    }

    // ======================================CREATE, UPDATE, DELETE, EDIT========================================
    public function store()
    {
        // validate
        $this->validate([
            'kebutuhan' => 'required',
            'uom' => 'required',
            'quantity' => 'required|numeric|min:1',
            'unit_price' => 'required|numeric|min:0',
            'purchase_date' => 'required|date',
            'newAttachment' => 'nullable|image|max:2048', // max 2MB
        ]);

        try {
            if ($this->reimburseId) {
                
                $this->total_per_item = $this->quantity * $this->unit_price;

                if ($this->newAttachment) {
                    Storage::delete($this->attachment, 'public');
                    $this->newAttachment = $this->newAttachment->store('reimburses', 'public');
                } 

                DB::table('reimburse')
                    ->where('id', $this->reimburseId)
                    ->update([
                        'kebutuhan' => $this->kebutuhan,
                        'uom' => $this->uom,
                        'quantity' => $this->quantity,
                        'unit_price' => $this->unit_price,
                        'total_per_item' => $this->total_per_item,
                        'purchase_date' => $this->purchase_date,
                        'attachment' => $this->newAttachment ?? $this->attachment,
                    ]);
                    $this->js("alert('Reimburse updated successfully');");
            } else {

                $this->total_per_item = $this->quantity * $this->unit_price;

                if ($this->newAttachment) {
                    $this->newAttachment = $this->newAttachment->store('reimburses', 'public');
                }

               Reimburse::create([
                    'kebutuhan' => $this->kebutuhan,
                    'uom' => $this->uom,
                    'quantity' => $this->quantity,
                    'unit_price' => $this->unit_price,
                    'total_per_item' => $this->total_per_item,
                    'purchase_date' => $this->purchase_date,
                    'attachment' => $this->newAttachment,
                ]);
                $this->js("alert('Reimburse created successfully');");
            }
            $this->dispatch('close-offcanvas');
            $this->dispatch('reimburseUpdated');
            $this->resetForm();
        } catch (Throwable $th) {
            throw $th;
            $this->js("alert('Tidak Tersimpan')");
        }
    }

    #[On('edit')]
    public function edit($id)
    {
        $this->reimburse = Reimburse::getReimburseById($id);

        $this->reimburseId = $this->reimburse->id;
        $this->kebutuhan = $this->reimburse->kebutuhan;
        $this->uom = $this->reimburse->uom;
        $this->quantity = $this->reimburse->quantity;
        $this->unit_price = $this->reimburse->unit_price;
        $this->total_per_item = $this->reimburse->total_per_item;
        $this->attachment = $this->reimburse->attachment;
        $this->purchase_date = $this->reimburse->purchase_date;

        $this->dispatch('show-edit-offcanvas');
    }

    // =======================================COUNT TOTAL PER ITEM========================================
    public function totalItem($qty, $price)
    {
        return $this->total_per_item = $qty * $price;
    }

    // =======================================RESET FORM========================================
    public function resetForm()
    {
        $this->kebutuhan = '';
        $this->uom = '';
        $this->quantity = '';
        $this->unit_price = '';
        $this->total_per_item = '';
        $this->purchase_date = '';
        $this->newAttachment = '';
        $this->attachment = '';
        $this->reimburseId = '';
    }

    // =======================================HANDLE OFF CANVAS========================================
    public function btnCloseOffcanvas()
    {
        $this->resetForm();
        $this->dispatch('close-offcanvas');
    }
}
