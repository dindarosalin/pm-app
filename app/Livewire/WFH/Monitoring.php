<?php

namespace App\Livewire\WFH;

use App\Models\Master\WfhStatuses;
use App\Models\WfhSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class Monitoring extends Component
{

    public $activeSessions;

    public $sessions;

    public $statusList = [];



    #[On('js-event')]
    public function handleJsEvent($message)
    {
        // Handle the event data from JavaScript
        Log::info('JS event received:', ['message' => $message]);
    }

    public function mount()
    {
        $this->statusList = WfhStatuses::getAllStatus()->pluck('status_wfh', 'id');
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

    public static function getOngoingPeerIds()
    {

        $peerIds = DB::table('wfh_session')
            ->where('status', 'ongoing')->pluck('peer_id');
        // dd($peerIds);
        return response()->json(['peer_ids' => $peerIds]);
    }

    public function render()
    {

        $this->sessions = $this->getSessionsProperty()->toArray();

        $peerIds = array_column($this->sessions, 'peer_id');



        // $this->activeSessions = WfhSession::whereNull('end')->get();
        return view('livewire.wfh.monitoring', [
            'peerIds' => $peerIds
        ]);
    }
}
