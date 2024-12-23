<?php

namespace App\Models\TimeCard;
use App\Models\Base\BaseModel;
use Carbon\Carbon;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\DB;

class TimeCard extends BaseModel
{
    public static function getAll() {
        return DB::table('time_cards')->get();
    }
    
    public static function getAllByAuth($authId)
    {
        $today = date('Y-m-d');
        // dd($today);

        return DB::table('time_cards')
            ->where('time_cards.employee_id', $authId)
            // ->whereNull('time_cards.deleted_at')
            ->whereDate('activity_date', $today)
            ->join('projects', 'time_cards.project_id', '=', 'projects.id')
            ->join('tasks', 'time_cards.task_id', '=', 'tasks.id')
            ->join('app_user', 'time_cards.employee_id', '=', 'app_user.user_id')
            ->join('task_statuses', 'tasks.status_id', '=', 'task_statuses.id')
            ->where('tasks.status_id', '<=', 4)
            ->select(
                'time_cards.*',
                'projects.title as project_title',
                'tasks.title as task_title',
                'tasks.status_id as status_id',
                'task_statuses.task_status as task_status',
                'app_user.user_name as assign_to',
            )
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public static function getByAuth($auth)
    {
        return DB::table('time_cards')
        ->where('employee_id', $auth)
        ->get();
    }

    public static function getById($id)
    {
        return DB::table('time_cards')
            ->where('time_cards.id', $id)
            ->join('projects', 'time_cards.project_id', '=', 'projects.id')
            ->join('tasks', 'time_cards.task_id', '=', 'tasks.id')
            ->join('app_user', 'time_cards.employee_id', '=', 'app_user.user_id')
            ->join('task_statuses', 'tasks.status_id', '=', 'task_statuses.id')
            ->select(
                'time_cards.*',
                'projects.title as project_title',
                'tasks.title as task_title',
                'tasks.status_id as status_id',
                'task_statuses.task_status as task_status',
                'app_user.user_name as assign_to',
            )
            ->first();
    }

    public static function create(array $storedData) {
        // dd($storedData);
        DB::table('time_cards')->insert($storedData);
    }

    public static function update($id, array $storedData)
    {
        // dd($storedData);
        DB::table('time_cards')
            ->where('id', $id)
            ->update($storedData);
    }

    public static function getProjectsByAuth() {}

    public static function getProjectIds ($auth) {
        return DB::table('time_cards')
            ->where('employee_id', $auth)
            ->join('projects', 'time_cards.project_id', '=', 'projects.id')
            ->distinct()
            ->select(
                'project_id',
                'projects.title as project_title',
                'projects.completion as project_completion',
                'projects.start_date as project_start_date',
                )
            ->get();
    }

    // ======================================== FILTER ========================================

    //SEARCH BY KEYWORD
    public static function scopeSearch($query, $searchTerm)
    {
        return $query->filter(function ($timeCard) use ($searchTerm) {
            return stripos($timeCard->project_title, $searchTerm) !== false ||
                stripos($timeCard->task_title, $searchTerm) !== false;
        });
    }

// ======================================== PERFORMA RESOURCE ========================================
    public static function getTaskByEmployee($employeeId, $month, $day)
    {
        $year = Carbon::now()->year;
            $date = Carbon::create($year, $month, $day);

                return DB::table('time_cards')
                        -> where('employee_id', $employeeId)
                        -> whereDate('activity_date', $date)
                        // -> whereDay('activity_date', $day)
                        -> sum('duration');
    }

    public static function getWeekTask ($employeeId, $start)
    {
        return DB::table('time_cards')
                ->where('employee_id', $employeeId)
                ->whereDate('activity_date', $start->toDateString())
                ->sum('duration');
    }

    public static function getDuration($employeeId, $day)
    {
        return DB::table('time_cards')
                ->where('employee_id', $employeeId)
                ->whereDate('activity_date', $day)
                ->sum('duration');
    }

    // public static function getWeekDuration ($employeeId)
    // {
    //     // return DB::table('time_cards')
    //     //         ->where('employee_id', $employeeId)
    //     //         ->whereBetween('activity_date', [$startDate, $endDate])
    //     //         ->sum('duration');

    //     $thisWeek = Carbon::
    //     return DB::table('time_cards')
    //             ->where('employee_id', $employeeId)
    //             ->where('activity_date', $thisWeek)
    //             ->select('activity_date', DB::raw('SUM(duration) as total_duration'))
    //             ->groupBy('activity_date')
    //             ->get();
    // }

    public static function getWeekDuration($employeeId)
    {
        $startOfWeek = Carbon::now()->startOfWeek()->toDateString();
        $endOfWeek = Carbon::now()->endOfWeek()->toDateString();

        return DB::table('time_cards')
        ->where('employee_id', $employeeId)
        ->whereBetween('activity_date', [$startOfWeek, $endOfWeek])
        ->sum('duration');
    }

    
    public static function getMonthDuration($employeeId)
    {
        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();
        return DB::table('time_cards')
        ->where('employee_id', $employeeId)
        ->whereBetween('activity_date', [$startOfMonth, $endOfMonth])
        ->sum('duration');
    }

    
}


// public static function getWeekDuration($weekStartDate, $employeeId)
    // {
    //     // calculate start date and end date in weekDay
    //     $startOfWeek = Carbon::parse($weekStartDate)->startOfWeek(); //monday
    //     // $endOfWeek = $startOfWeek->copy()->endOfWeek(); //sunday

    //     // atur akhir minggu kerja jadi jumt
    //     $endOfWorkWeek = $startOfWeek->copy()->addDays(4); //jumat

    //     return DB::table('time_cards')
    //             ->where('employee_id', $employeeId)
    //             ->whereBetween('activity_date', [$startOfWeek, $endOfWorkWeek])
    //             ->sum('duration');
    // }

 // return DB::table('time_cards')
        //         ->select(DB::raw('DATE(activity_date) as date'), DB::raw('SUM(duration) as total_duration'))
        //         ->where('employee_id', $employeeId)
        //         ->whereMonth('activity_date', $month)
        //         ->groupBy(DB::raw('DATE(activity_date)'))
        //         ->get();

        // public static function getTaskByDay($employeeId, $activityDate)
    // {
    //     return DB::table('time_cards')
    //             -> where('employee_id', $employeeId)
    //             -> whereDay('activity_date', $activityDate)
    //             -> sum('duration');
    // }
