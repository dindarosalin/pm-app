<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WfhSession extends BaseModel
{
    protected function data(): Attribute
    {
        return Attribute::make(
            get: fn($value) => json_decode($value, true),
            set: fn($value) => json_encode($value)
        );
    }

    public static function store($peer)
    {
        Log::withContext([Auth::user()->user_name]);
        Log::info('Storing session with peer_id: ' . $peer);

        $status = "ongoing";
        // $peerId = $peer;

        if (isset($peer)) {
            DB::table('wfh_session')->insert([
                'app_user_user_id' => Auth::user()->user_id,
                'start' => now(),
                'end' => null,
                'status' => $status,
                'peer_id' => $peer,
            ]);
            Log::info('Store session success with peer_id: ' . $peer);
            // Monitoring::getListeners();
            // dispatch('getListeners'); // Trigger event to refresh monitoring
        } else {
            Log::error('Failed to store session: peer_id is null');
        }
    }
}
