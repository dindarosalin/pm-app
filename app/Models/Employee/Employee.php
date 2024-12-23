<?php

namespace App\Models\Employee;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Base\BaseModel;

class Employee extends BaseModel
{
    public static function getAll()
    {
        return DB::table('employees')
            // ->join('roles', 'employees.role_id', '=', 'roles.id')
            // ->join('departments', 'employees.department_id', '=', 'departments.id')
            // ->select(
            //     'employees.*',
            //     'roles.role as role_name',
            //     'departments.name as department_name',
            // )
            ->get();
    }

    public static function getById($id)
    {
        return DB::table('employees')
            ->where('employees.id', $id)
            // ->join('roles', 'employees.role_id', '=', 'roles.id')
            // ->join('departments', 'employees.department_id', '=', 'departments.id')
            // ->select(
            //     'employees.*',
            //     'roles.role as role_name',
            //     'departments.name as department_name',
            // )
            ->first();
    }

    public static function getEmployeesByParent($auth)
    {
        // $authParent = Employee::getById($auth)->parent_id;
        $authParent = DB::table('employees')->where('employees.id', $auth)->first()->parent_id;

        return DB::table('employees')
        ->where('parent_id', '>', $authParent)
        ->get();
    }

    //SEARCH BY KEYWORD
    public static function scopeSearch($query, $searchTerm)
    {
        return $query->filter(function ($query) use ($searchTerm) {
            return stripos($query->name, $searchTerm) !== false;
        });
    }

    public static function scopeFilterByTimeFrame($query, $column, $timeFrame)
    {
        $currentDate = Carbon::now();

        // $query->each(function ($item) {
        //     $item->start_date = Carbon::parse($item->start_date);
        //     $item->due_date_estimation = Carbon::parse($item->due_date_estimation);
        // });

        switch ($timeFrame) {
            case 'today':
                $startDate = $currentDate->copy()->startOfDay();
                $endDate = $currentDate->copy()->endOfDay();
                break;
            case 'tomorrow':
                $startDate = $currentDate->copy()->addDay()->startOfDay();
                $endDate = $currentDate->copy()->addDay()->endOfDay();
                break;
            case 'yesterday':
                $startDate = $currentDate->copy()->subDay()->startOfDay();
                $endDate = $currentDate->copy()->subDay()->endOfDay();
                break;
            case 'week':
                $startDate = $currentDate->copy()->startOfWeek();
                $endDate = $currentDate->copy()->endOfWeek();
                break;
            case 'next_week':
                $startDate = $currentDate->copy()->addWeek()->startOfWeek();
                $endDate = $currentDate->copy()->addWeek()->endOfWeek();
                break;
            case 'last_week':
                $startDate = $currentDate->copy()->subWeek()->startOfWeek();
                $endDate = $currentDate->copy()->subWeek()->endOfWeek();
                break;
            case 'month':
                $startDate = $currentDate->copy()->startOfMonth();
                $endDate = $currentDate->copy()->endOfMonth();
                break;
            case 'next_month':
                $startDate = $currentDate->copy()->addMonth()->startOfMonth();
                $endDate = $currentDate->copy()->addMonth()->endOfMonth();
                break;
            case 'last_month':
                $startDate = $currentDate->copy()->subMonth()->startOfMonth();
                $endDate = $currentDate->copy()->subMonth()->endOfMonth();
                break;
            case 'year':
                $startDate = $currentDate->copy()->startOfYear();
                $endDate = $currentDate->copy()->endOfYear();
                break;
            case 'all':
            default:
                return $query;
        }

        return $query->whereBetween($column, [$startDate, $endDate]);
    }
}
