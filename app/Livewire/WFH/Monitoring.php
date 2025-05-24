<?php

namespace App\Livewire\Wfh;

use Livewire\Component;
use App\Models\WfhSession;

class Monitoring extends Component
{

    public $activeSessions;

    public function getListeners()
    {
        return ['refreshComponent' => '$refresh'];
    }

    public function mount()
    {
        $this->activeSessions = WfhSession::whereNull('end')->get();
    }

    public function render()
    {
        $this->activeSessions = WfhSession::whereNull('end')->get();
        return view('livewire.wfh.monitoring');
    }
}
