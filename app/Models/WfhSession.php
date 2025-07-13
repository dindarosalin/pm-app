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

    public static function storeNewSession($peerId)
    {
        Log::withContext(['user' => Auth::user()->user_name]);

        if (!$peerId) {
            Log::error('Failed to store session: peer_id is null');
            return;
        }

        $userId = Auth::user()->user_id;

        // Cegah sesi ganda yang masih ongoing
        $hasOngoing = DB::table('wfh_session')
            ->where('app_user_user_id', $userId)
            ->where('status', 'ongoing')
            ->exists();

        if ($hasOngoing) {
            Log::warning("User $userId already has an ongoing session.");
            return;
        }

        DB::table('wfh_session')->insert([
            'app_user_user_id' => $userId,
            'start' => now(),
            'end' => null,
            'status' => 'ongoing',
            'peer_id' => $peerId,
        ]);

        Log::info('Store session success with peer_id: ' . $peerId);
    }
}
