<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\DB;


class Working extends BaseModel
{
    public static function create(array $storeData)
    {
        DB::table('workings')->insertGetId(
            [
                'employee_id' => $storeData['employee_id'],
                'created_at' => now()
            ]
            );
    }

    // public static function get($employee)
    // {
        
    // }
}
