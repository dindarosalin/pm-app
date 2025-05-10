<?php

namespace App\Livewire\Wfh;

use Livewire\Component;

class WorkFromHome extends Component
{
    public $userId;

    protected $listeners = ['receiveSignal'];

    public function mount()
    {
        // $this->userId = $userId;
    }

    public function receiveSignal($data)
    {
        // Handle signaling data if needed (usually managed via JS/WebSocket)
        // This could be used to log or route signaling info
    }

    public function render()
    {
        return view('livewire.wfh.work-from-home');
    }
}
