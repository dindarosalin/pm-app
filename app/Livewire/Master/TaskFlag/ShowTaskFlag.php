<?php

namespace App\Livewire\Master\TaskFlag;

use Livewire\Component;
use App\Models\Projects\Master\TaskFlags as ModelsTaskFlags;
use Livewire\Attributes\On;

class ShowTaskFlag extends Component
{
    public $taskFlags;
    public $taskFlagId;
    public $flagName, $flagCode;

    public function render()
    {
        $this->taskFlags = ModelsTaskFlags::getAll();

        return view('livewire.master.task-flag.show-task-flag', [
            'taskFlags' => $this->taskFlags
        ]);
    }

    public function save(){
        // dd('masuk save');
        if ($this->taskFlagId) {
            ModelsTaskFlags::Update($this->all(), $this->taskFlagId);
        } else {
            ModelsTaskFlags::Create($this->all());
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
        $this->dispatch('show-offcanvas-flag');
        $var = ModelsTaskFlags::getById($id);

        $this->taskFlagId = $var->id;
        $this->flagName = $var->flag_name;
        $this->flagCode = $var->flag_code;
    }


    public function alertConfirm($id)
    {
        $this->dispatch('swal:confirm', [
            'type' => 'warning',
            'message' => 'Are you sure?',
            'text' => 'You won\'t be able to revert this!',
            'id' => $id,
            'dispatch' => 'delete-task-flag'
        ]);
    }

    #[On('delete-task-flag')]
    public function delete($id)
    {
        ModelsTaskFlags::delete($id);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.'
        ]);
    }
}
