<?php

namespace App\Livewire\Master\StatusWfh;

use Livewire\Component;

class ShowStatusWfh extends Component
{
    public $statuses;
    public function store() {}
    public function update() {}
    public function delete() {}
    public function getListeners()
    {
        return ['refreshComponent' => '$refresh'];
    }
    public function mount()
    {
        $this->statuses = $this->getStatusesProperty();
        if ($this->statuses->isEmpty()) {
            session()->flash('message', 'No statuses found.');
        } else {
            session()->flash('message', 'Statuses loaded successfully.');
        }
        // dd($statuses);
    }
    public function getStatusesProperty()
    {
        return (new \App\Models\Master\WfhStatuses())->getAllStatus();
    }
    public function render()
    {
        return view('livewire.master.status-wfh.show-status-wfh');
    }
}
