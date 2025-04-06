<?php

namespace App\Livewire\Master\TaskCriteria;

use App\Models\Projects\Master\TaskCriterias;
use Livewire\Attributes\On;
use Livewire\Component;

class ShowTaskCriteria extends Component
{
    public $taskCriterias;
    public $criteriaId;
    public $cName, $cAttribute, $cValue, $cDescription;

    public function render()
    {
        $this->taskCriterias = TaskCriterias::getAll();

        return view('livewire.master.task-criteria.show-task-criteria');
    }

    public function save(){
        // dd('masuk save');
        if ($this->criteriaId) {
            TaskCriterias::Update($this->all(), $this->criteriaId);
        } else {
            TaskCriterias::Create($this->all());
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
        $this->dispatch('show-offcanvas-criteria');
        $var = TaskCriterias::getById($id);

        $this->criteriaId = $var->id;
        $this->cName = $var->c_name;
        $this->cAttribute = $var->c_attribute;
        $this->cValue = $var->c_value;
        $this->cDescription = $var->c_description;
    }

    public function alertConfirm($id)
    {
        $this->dispatch('swal:confirm', [
            'type' => 'warning',
            'message' => 'Are you sure?',
            'text' => 'You won\'t be able to revert this!',
            'id' => $id,
            'dispatch' => 'delete-task-criteria'
        ]);
    }

    #[On('delete-task-criteria')]
    public function delete($id)
    {
        TaskCriterias::delete($id);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.'
        ]);
    }
}
