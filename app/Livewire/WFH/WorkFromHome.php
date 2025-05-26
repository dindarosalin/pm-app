<?php

namespace App\Livewire\Wfh;

use App\Models\WfhSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;

class WorkFromHome extends Component
{
    public $userId;

    protected $listeners = ['receiveSignal'];

    public static function storePeerId($request)
    {
        Log::withContext([Auth::user()->user_name]);
        if (isset($request)) {
            $query = DB::table('wfh_session')->insert(
                [
                    'app_user_user_id' => Auth::user()->user_id,
                    'start' => now(),
                    'end' => null,
                    'status' => 'ongoing',
                    'peer_id' => $request,
                ]
            );

            Log::info('Store session success with peer_id: ' . $request);
        } else {
            Log::error('Failed to store session: peer_id is null');
        }
    }

    public static function updateSessionEnded($peerId)
    {
        Log::withContext([Auth::user()->user_name]);
        // Log::info('Ending session for peer_id: ' . $peerId);

        $updated = DB::table('wfh_session')
            ->where('peer_id', $peerId)
            ->update([
                'end' => now(),
                'status' => 'end',
            ]);

        if ($updated) {
            Log::info('Session ended successfully for peer_id: ' . $peerId);
        } else {
            Log::warning('No ongoing session found to end for peer_id: ' . $peerId);
        }
    }

    public function render()
    {
        return view('livewire.wfh.work-from-home');
    }
}
