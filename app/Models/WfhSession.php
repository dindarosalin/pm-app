<?php

namespace App\Models;

use App\Livewire\WFH\Monitoring;
use App\Models\Base\BaseModel;
use Carbon\Carbon;
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

    public static function getTotalWorkDurationToday($userId)
    {
        $sessions = DB::table('wfh_session')
            ->whereDate('start', today())
            ->where('app_user_user_id', $userId)
            ->whereNotNull('end')
            ->get();

        $totalSeconds = 0;

        foreach ($sessions as $session) {
            $start = Carbon::parse($session->start);
            $end = Carbon::parse($session->end);
            $totalSeconds += $start->diffInSeconds($end); // pastikan urutan benar
        }

        return $totalSeconds;
    }

    public static function getTotalDurationThisWeek($userId)
    {
        $sessions = DB::table('wfh_session')
            ->whereBetween('start', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->where('app_user_user_id', $userId)
            ->whereNotNull('end')
            ->get();

        $totalSeconds = 0;
        foreach ($sessions as $s) {
            $start = Carbon::parse($s->start);
            $end = Carbon::parse($s->end);
            $totalSeconds += $start->diffInSeconds($end);
        }
        return $totalSeconds;
    }

    public static function getTotalDurationThisMonth($userId)
    {
        $sessions = DB::table('wfh_session')
            ->whereYear('start', now()->year)
            ->whereMonth('start', now()->month)
            ->where('app_user_user_id', $userId)
            ->whereNotNull('end')
            ->get();

        $totalSeconds = 0;
        foreach ($sessions as $s) {
            $start = Carbon::parse($s->start);
            $end = Carbon::parse($s->end);
            $totalSeconds += $start->diffInSeconds($end);
        }

        return $totalSeconds;
    }
}
