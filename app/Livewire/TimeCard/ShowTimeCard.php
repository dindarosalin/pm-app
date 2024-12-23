<?php

namespace App\Livewire\TimeCard;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShowTimeCard extends Component
{
    public $auth;

    public function render()
    {
        $this->auth = Auth::user()->user_id;
        // $this->auth = '16825598905258'; // -> 2
        // $this->auth = '16838855416673'; // -> 3
        // $this->auth = '1672385124827'; // -> 4
        return view('livewire.time-card.show-time-card');
    }
}
