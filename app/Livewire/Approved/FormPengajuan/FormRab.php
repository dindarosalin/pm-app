<?php

namespace App\Livewire\Approved\FormPengajuan;

use App\Models\Approval\rab;
use Livewire\Attributes\On;
use Livewire\Component;

class FormRab extends Component
{
    public $kebutuhan, $deskripsi, $uom, $quantity = 1, $unit_per_price = 0;
    public $total_per_item;
    public $rabId;
    public $rabs;


    public function render()
    {
        return view('livewire.approved.form-pengajuan.form-rab');
    }

    //=========================================STORE=========================================
    public function store()
    {
        $this->validate([
            'kebutuhan' => 'required',
            'deskripsi' => 'required',
            'uom' => 'required',
            'quantity' => 'required|numeric|min:1',
            'unit_per_price' => 'required|numeric|min:0',
        ]);

        try {
            if ($this->rabId) {
                $this->total_per_item = $this->quantity * $this->unit_per_price;
                rab::update([
                    'kebutuhan' => $this->kebutuhan,
                    'deskripsi' => $this->deskripsi,
                    'uom' => $this->uom,
                    'quantity' => $this->quantity,
                    'unit_per_price' => $this->unit_per_price,
                    'total_price' => $this->total_per_item,
                ], $this->rabId);
                $this->js("alert('Data RAB berhasil diupdate!');");
            } else {

                $this->total_per_item = $this->quantity * $this->unit_per_price;
                rab::create([
                    'kebutuhan' => $this->kebutuhan,
                    'deskripsi' => $this->deskripsi,
                    'uom' => $this->uom,
                    'quantity' => $this->quantity,
                    'unit_per_price' => $this->unit_per_price,
                    'total_price' => $this->total_per_item,
                ]);
                $this->js("alert('Data RAB berhasil disimpan!');");
            }
            $this->dispatch('close-offcanvas'); //offcanvas tutup otomatis
            $this->dispatch('rabUpdated'); //load otomatis
            $this->resetForm(); //reset otomatis
        } catch (\Throwable $th) {
            $this->js("alert('Data RAB gagal disimpan!');");
        }
    }

    #[On('edit')]
    public function edit($id)
    {
        // get data for form edit
        $rabs = rab::getAllRab($id);

        $this->rabId = $rabs->id;
        $this->kebutuhan = $rabs->kebutuhan;
        $this->deskripsi = $rabs->deskripsi;
        $this->uom = $rabs->uom;
        $this->quantity = $rabs->quantity;
        $this->unit_per_price = $rabs->unit_per_price;

        $this->dispatch('show-edit-offcanvas-rab');
    }
    //=========================================COUNT TOTAL PER ITEM=========================================
    public function totalItem($qty, $price)
    {
        return $this->total_per_item = $qty * $price;
    }

    // =========================================HANDLE CLOSE OFFCANVAS=========================================
        public function btnCloseOffcanvas()
        {
            $this->resetForm();
            $this->dispatch('close-offcanvas');
        }

        public function resetForm()
        {
            $this->kebutuhan = '';
            $this->deskripsi = '';                      
            $this->uom = '';
            $this->quantity = ''; 
            $this->unit_per_price = '';
            $this->rabId = '';
        }
}
