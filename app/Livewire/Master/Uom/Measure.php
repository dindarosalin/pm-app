<?php

namespace App\Livewire\Master\Uom;

use App\Models\master\uom;
use Livewire\Attributes\On;
use Livewire\Component;

class Measure extends Component
{

    public $uomId, $name, $description;
    public $data;
    public function render()
    {
        $this->data = uom::getAll();
        return view('livewire.master.uom.measure');
    }

    public function save()
    {
        if ($this->uomId) {
            uom::update($this->uomId, $this->all());
        } else {
            uom::create($this->all());
        }
        $this->reset();
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.'
        ]);
    }

    #[On('edit')]
    public function edit($id) {
        $this->dispatch('show-offcanvas');
        $var = uom::getById($id);

        $this->uomId = $var->id;
        $this->name = $var->name;
        $this->description = $var->description;
    }

    public function alertConfirm($id)
    {
        $this->dispatch('swal:confirm', [
            'type' => 'warning',
            'message' => 'Are you sure?',
            'text' => 'You won\'t be able to revert this!',
            'id' => $id,
            'dispatch' => 'delete'
        ]);
    }

    #[On('delete')]
    public function delete($id)
    {
        uom::delete($id);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.'
        ]);
    }

}
