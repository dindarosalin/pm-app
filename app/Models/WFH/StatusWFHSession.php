<?php

namespace App\Models\WFH;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StatusWFHSession extends Model
{
    protected $fillable = [
        'status_wfh_id',
        'wfh_session_id',
        'start',
        'end',
    ];
}
