<?php

namespace App\Livewire\Approval\Responsible;

use Livewire\Component;

class ResponsibleAbsence extends Component
{
    public $absences;

    public function render()
    {
        $this->loadData();
        return view('livewire.approval.responsible.responsible-absence');
    }

    public function loadData()
    {

    }
}
