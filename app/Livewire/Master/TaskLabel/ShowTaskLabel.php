<?php

namespace App\Livewire\Master\TaskLabel;

use Livewire\Component;
use App\Models\Projects\Master\TaskLabel;

class ShowTaskLabel extends Component
{
    public $labels;
    public $labelId;
    public $labelName, $labelCode;
    
    public function render()
    {
        $this->labels = TaskLabel::getAll();

        return view('livewire.master.task-label.show-task-label');
    }

    public function save(){
        // dd('masuk save');
        if ($this->labelId) {
            TaskLabel::Update($this->labelId, $this->all());
        } else {
            TaskLabel::Create($this->all());
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
        $this->dispatch('show-offcanvas-label');
        $var = TaskLabel::getById($id);

        $this->labelId = $var->id;
        $this->labelName = $var->label_name;
        $this->labelCode = $var->label_code;
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
        TaskLabel::delete($id);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.'
        ]);
    }
}
