<?php

namespace App\Models\Employee;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\DB;

class Role extends BaseModel
{
    public static function getAll() {
        return DB::table('roles')->get();
    }
}
