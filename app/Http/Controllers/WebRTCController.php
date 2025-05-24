<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebRTCController extends Controller
{
    public function signal(Request $request)
    {
        broadcast(new WebRTCSignalEvent($request->receiver_id, $request->message))->toOthers();
        return response()->json(['status' => 'sent']);
    }
}
