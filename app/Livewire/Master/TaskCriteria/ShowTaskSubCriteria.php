<?php

namespace App\Livewire\Master\TaskCriteria;

use Livewire\Component;
use App\Models\Projects\Master\TaskCriterias;
use App\Models\Projects\Master\TaskSubCriterias;
use Livewire\Attributes\On;

class ShowTaskSubCriteria extends Component
{
    public $cNameList, $scId;
    public $cId, $scLabel, $scMin, $scMax, $scValue, $scDesc;
    public $scNameList;

    public function render()
    {
        $this->cNameList = TaskCriterias::getAll();
        $this->scNameList = TaskSubCriterias::getAll();
        // dd($this->scNameList);
        return view('livewire.master.task-criteria.show-task-sub-criteria');
    }

    public function save(){
        if ($this->scId) {
            TaskSubCriterias::Update($this->all(), $this->scId);
        } else {
        // dd($this->all());
            TaskSubCriterias::Create($this->all());
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
        $this->dispatch('show-offcanvas-subcriteria');
        $var = TaskSubCriterias::getById($id);

        $this->scId = $var->id;
        $this->cId = $var->criteria_id;
        $this->scLabel = $var->sc_label;
        $this->scMin = $var->sc_min;
        $this->scMax = $var->sc_max;
        $this->scValue = $var->sc_value;
        $this->cDesc = $var->sc_description;
    }

    public function alertConfirm($id)
    {
        $this->dispatch('swal:confirm', [
            'type' => 'warning',
            'message' => 'Are you sure?',
            'text' => 'You won\'t be able to revert this!',
            'id' => $id,
            'dispatch' => 'delete-task-subcriteria'
        ]);
    }

    #[On('delete-task-subcriteria')]
    public function delete($id)
    {
        TaskSubCriterias::delete($id);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.'
        ]);
    }
}
