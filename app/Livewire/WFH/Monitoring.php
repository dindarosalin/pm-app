<?php

namespace App\Livewire\Wfh;

use App\Models\WfhSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Monitoring extends Component
{

    public $activeSessions;

    public $sessions;


    public function getListeners()
    {
        return ['refreshComponent' => '$refresh'];
    }

    public function mount()
    {
        // dd($this->storePeerId());
        // $this->activeSessions = WfhSession::whereNull('end')->get();
    }

    public function getSessionsProperty()
    {
        return DB::table('wfh_session')
            ->join('app_user', 'app_user.user_id', '=', 'wfh_session.app_user_user_id')
            ->where('wfh_session.status', 'ongoing')
            ->select('wfh_session.peer_id', 'app_user.user_name')
            ->get();
    }

    public function render()
    {

        $this->sessions = $this->getSessionsProperty();

        // dd($this->sessions);


        // $this->activeSessions = WfhSession::whereNull('end')->get();
        return view('livewire.wfh.monitoring');
    }
}
