<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\DB;

class EmployeeSalary extends BaseModel
{
   public static function getSalaryById($userId)
   {
      // return $userId;
    return DB::table('employee_salary')
            ->where ('user_id', $userId)
            ->select('employee_salary.salary')
            ->get();
   }

   public static function getPokokById($userId)
   {
      // return $userId;
    return DB::table('employee_salary')
            ->where ('user_id', $userId)
            ->select('employee_salary.gaji_pokok')
            ->get();
   }

   // public static function getById($userId)
   // {
   //    return DB::table('employee_salary')
   //             ->where ('employee_salary.user_id', $userId)
   //             ->join ('app_user', 'employee_salary.user_id', '=', 'app_user.user_id')
   //             ->select ('employee_salary.*', 'app_user.user_name as employee_name')
   //             ->first();
   // }
}
