<?php

namespace App\Livewire\Wfh;

use Livewire\Component;
use App\Models\WfhSession;
use Illuminate\Support\Str;

class WorkFromHome extends Component
{
    public $userId;

    protected $listeners = ['receiveSignal'];

    public $peerId;
    public $status = 'ongoing';


    public function render()
    {
        return view('livewire.wfh.work-from-home');
    }
}
