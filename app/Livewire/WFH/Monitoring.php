<?php

namespace App\Livewire\Wfh;

use App\Models\WfhSession;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Monitoring extends Component
{

    public $activeSessions;



    public function getListeners()
    {
        return ['refreshComponent' => '$refresh'];
    }

    public function mount()
    {
        // dd($this->storePeerId());
        // $this->activeSessions = WfhSession::whereNull('end')->get();
    }

    public function render()
    {
        // $this->activeSessions = WfhSession::whereNull('end')->get();
        return view('livewire.wfh.monitoring');
    }
}
