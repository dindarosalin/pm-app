<?php

namespace App\Models\Employee;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Department extends BaseModel
{
    public static function getAllDepartments(){
        return DB::table('departments')->get();
    }
}
