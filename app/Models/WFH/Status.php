<?php

namespace App\Models\WFH;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\DB;

class Status extends BaseModel
{
    public static function getAll(){
        return DB::table('status_wfh')->get();
    }
}
