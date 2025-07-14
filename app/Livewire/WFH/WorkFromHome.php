<?php

namespace App\Livewire\WFH;

use App\Livewire\Master\StatusWfh\ShowStatusWfh;
use App\Models\Master\WfhStatuses;
use App\Models\WfhSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class WorkFromHome extends Component
{
    public $userId;

    public $statusList;

    #[On('storePeer')]
    public function storePeerId($request)
    {
        Log::withContext([Auth::user()->user_name]);
        $status = "ongoing";
        Log::info('Storing session with peer_id: ' . $request);
        if ($request) {
            WfhSession::store($request);
            $this->dispatch('swal:modal', [
                'type' => 'success',
                'message' => 'Session Started',
                'text' => 'The session has been started successfully.'
            ]);

            $this->dispatch('refreshMonitoring')->to('WFH.Monitoring');
            Log::info('Send session success with peer_id: ' . $request);
        } else {
            Log::error('Failed send to store session: peer_id is null');
        }
    }

    public static function updateSessionEnded($peerId)
    {
        Log::withContext([Auth::user()->user_name]);
        // Log::info('Ending session for peer_id: ' . $peerId);
        $status = "end";
        $updated = DB::table('wfh_session')
            ->where('peer_id', $peerId)
            ->update([
                'end' => now(),
                'status' => $status,
            ]);


        if ($updated) {
            Log::info('Session ended successfully for peer_id: ' . $peerId);
        } else {
            Log::warning('No ongoing session found to end for peer_id: ' . $peerId);
        }
    }

    public static function sessionPeerUpdate($peerId, $status)
    {
        Log::withContext([Auth::user()->user_name]);
        Log::info('Handling status change for peer_id: ' . $peerId . ', status: ' . $status);

        // 1. Ambil session aktif terakhir (belum diakhiri)
        $lastSession = DB::table('status_wfh_has_wfh_session')
            ->where('wfh_session_id', $peerId)
            ->whereNull('end_at')
            ->orderByDesc('start_at')
            ->first();

        if ($lastSession && $lastSession->status_wfh_id == $status) {
            // Status tidak berubah, tidak perlu update apa-apa
            return response()->json(['message' => 'Status unchanged, no action taken.']);
        }

        if ($lastSession) {
            DB::table('status_wfh_has_wfh_session')
                ->where('wfh_session_id', $lastSession->wfh_session_id)
                ->update(['end_at' => now()]);
            Log::info('Previous session ended for peer_id: ' . $peerId);
        } else {
            Log::info('No previous session found for peer_id: ' . $peerId . ', creating new session.');
        }

        // 2. Simpan session baru
        DB::table('status_wfh_has_wfh_session')->insert([
            'wfh_session_id' => $peerId,
            'status_wfh_id' => $status,
            'start_at' => now(),
            'end_at' => null,
        ]);

        // SWEET ALERT
        // $this->dispatch('swal:modal', [
        //     'type' => 'success',
        //     'message' => 'Data Added',
        //     'text' => 'The data has been added successfully.'
        // ]);

        Log::info('New session created for peer_id: ' . $peerId . ', status: ' . $status);
        // Log::debug('Updating session status for peer_id: ' . $request->input('peer_id'));
        // Log::debug('Updating session status: ' . $request->input('status'));
        // $status = $request->input('status');
        // $peerId = $request->input('peer_id');

        // DB::table('wfh_session')
        //     ->where('peer_id', $peerId)
        //     ->update(['status' => $status]);
    }

    public function render()
    {
        $showStatusWfh = new ShowStatusWfh();
        $statusList = $showStatusWfh->getStatusesProperty();
        $this->statusList = $statusList->toArray();
        return view('livewire.wfh.work-from-home');
    }

    public function mount()
    {
        $this->statusList = WfhStatuses::getAllStatus()->pluck('status_wfh', 'id');
    }
}
