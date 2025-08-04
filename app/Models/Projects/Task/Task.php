<?php

namespace App\Models\Projects\Task;

use App\Models\Base\BaseModel;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeHierarchy;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class Task extends BaseModel
{
    // GET ALL TASKS DI TABLE TASK
    public static function getAllTask()
    {
        return DB::table('tasks')->get();
    }

    // ========================================================================POV: STAFF========================================================================

    // GET TASKS BY PROJECTS
    public static function getAllProjectTasks($projectId)
    {
        return DB::table('tasks')
            ->where('tasks.project_id', $projectId)
            ->whereNull('tasks.deleted_at')
            ->join('projects', 'tasks.project_id', '=', 'projects.id')
            ->join('task_statuses', 'tasks.status_id', '=', 'task_statuses.id')
            ->select(
                'tasks.*',
                'projects.title as project_title',
                'task_statuses.task_status as status_name'
            )
            ->get();
    }

    // GET All TASKS BY PROJECTS
    public static function getAllTasks()
    {
        return DB::table('tasks')
            ->whereNull('tasks.deleted_at')
            ->join('projects', 'tasks.project_id', '=', 'projects.id')
            ->join('task_statuses', 'tasks.status_id', '=', 'task_statuses.id')
            ->select(
            'tasks.project_id',
            'projects.title as project_title',
            DB::raw('count(tasks.id) as total_tasks')
            )
            ->groupBy('tasks.project_id', 'projects.title')
            ->get();
        }


    // GET PROJECT DONE FOR GENERATE RELEASE NOTES
    public static function getDoneProjectTasks($projectId, array $status)
    {
        return DB::table('tasks')
            ->where('tasks.project_id', $projectId)
            ->whereNull('tasks.deleted_at')
            ->whereIn('tasks.status_id', $status)
            ->join('task_statuses', 'tasks.status_id', '=', 'task_statuses.id')
            ->join('projects', 'tasks.project_id', '=', 'projects.id')
            ->join('app_user as creators', 'tasks.created_by', '=', 'creators.user_id')
            ->leftJoin('app_user as assignees', 'tasks.assign_to', '=', 'assignees.user_id')
            ->leftJoin('task_flagging', 'tasks.id', '=', 'task_flagging.task_id')
            ->leftJoin('task_flags', 'task_flagging.flag_id', '=', 'task_flags.id')
            ->leftJoin('task_labeling', 'tasks.id', '=', 'task_labeling.task_id')
            ->leftJoin('task_labels', 'task_labeling.label_id', '=', 'task_labels.id')
            ->select(
                'tasks.*',
                'task_statuses.task_status as status_name',
                'projects.title as project_title',
                'creators.user_name as created_by_name',
                'assignees.user_name as assign_to_name',
                DB::raw('GROUP_CONCAT(task_flags.flag_name SEPARATOR ", ") as flag'),
                DB::raw('GROUP_CONCAT(task_labels.label_name SEPARATOR ", ") as label')
            )
            ->groupBy(
                'tasks.id',
                'tasks.project_id',
                'tasks.title',
                'tasks.summary',
                'tasks.start_date_estimation',
                'tasks.end_date_estimation',
                'tasks.attachment',
                'tasks.created_by',
                'tasks.assign_to',
                'tasks.completion_time',
                'tasks.created_at',
                'tasks.updated_at',
                'tasks.status_id',
                'tasks.category_id',
                'tasks.use_holiday',
                'tasks.use_weekend',
                'tasks.deleted_at',
                'status_name',
                'project_title',
                'created_by_name',
                'assign_to_name',
                // 'task_flags.flag_name'
            )
            ->get();
    }

    public static function getDoneAllProjectTasks(array $status)
    {
        return DB::table('tasks')
            ->whereIn('tasks.status_id', $status)
            ->whereNull('tasks.deleted_at')
            ->join('task_statuses', 'tasks.status_id', '=', 'task_statuses.id')
            ->leftJoin('projects', 'tasks.project_id', '=', 'projects.id')
            ->join('app_user as creators', 'tasks.created_by', '=', 'creators.user_id')
            ->leftJoin('app_user as assignees', 'tasks.assign_to', '=', 'assignees.user_id')
            ->leftJoin('task_flagging', 'tasks.id', '=', 'task_flagging.task_id')
            ->leftJoin('task_flags', 'task_flagging.flag_id', '=', 'task_flags.id')
            ->leftJoin('task_labeling', 'tasks.id', '=', 'task_labeling.task_id')
            ->leftJoin('task_labels', 'task_labeling.label_id', '=', 'task_labels.id')
            ->select(
            'tasks.project_id',
            'projects.title as project_title',
            DB::raw('count(tasks.project_id) as total_tasks_done')
            )
            ->groupBy('tasks.project_id', 'projects.title')
            ->get();
        }

    // CREATE TASK
    public static function create(array $storeData)
    {
        // dd($storeData['selectedLabels']);
        // dd($storeData);
        $taskId = DB::table('tasks')->insertGetId(
            [
                'project_id' => $storeData['project_id'],
                'title' => $storeData['title'],
                'summary' => $storeData['summary'],
                'category_id' => $storeData['category_id'],
                'start_date_estimation' => $storeData['start_date_estimation'],
                'end_date_estimation' => $storeData['end_date_estimation'],
                'created_by' =>  $storeData['created_by'],
                'assign_to' => $storeData['assign_to'],
                'status_id' => $storeData['status'],
                'use_holiday' => $storeData['use_holiday'],
                'use_weekend' => $storeData['use_weekend'],
                'attachment' => json_encode($storeData['attachments']),
                'created_at' => now()
            ]
        );

        if (isset($storeData['selectedFlags']) && is_array($storeData['selectedFlags'])) {
            foreach ($storeData['selectedFlags'] as $flag) {
                DB::table('task_flagging')->insert([
                    'task_id' => $taskId,
                    'flag_id' => $flag,
                ]);
            }
        }

        if (isset($storeData['selectedLabels']) && is_array($storeData['selectedLabels'])) {
            foreach ($storeData['selectedLabels'] as $label) {
                DB::table('task_labeling')->insert([
                    'task_id' => $taskId,
                    'label_id' => $label,
                ]);
            }
        }

        if ($storeData['assign_to'] != null) {
            DB::table('time_cards')->insert([
                'project_id' => $storeData['project_id'],
                'task_id' => $taskId,
                'employee_id' => $storeData['assign_to'],
                'activity_date' => now(),
                'created_at' => now(),
            ]);
        }

        return $taskId;
    }


    // untuk kebutuhan edit dan mengambil data task flag
    public static function editHelper($id)
    {
        // Ambil flag_id berdasarkan task_id
        $flagIds = DB::table('task_flagging')
            ->where('task_id', $id)
            ->pluck('flag_id')
            ->toArray();

        // Ambil label_id berdasarkan task_id
        $labelIds = DB::table('task_labeling')
            ->where('task_id', $id)
            ->pluck('label_id')
            ->toArray();

        // Ambil data flags berdasarkan flag_id
        $flags = DB::table('task_flags')
            ->whereIn('id', $flagIds)
            ->get();

        // Ambil data labels berdasarkan label_id
        $labels = DB::table('task_labels')
            ->whereIn('id', $labelIds)
            ->get();

        // Kembalikan data flags dan labels sebagai respons
        return [
            'flags' => $flags,
            'labels' => $labels,
        ];
    }

    // UPDATE TASK
    public static function update(array $storeData, $id)
    {
        $oldTask = DB::table('tasks')->where('id', $id)->first(['assign_to', 'id']);

        if ($storeData['assign_to'] != $oldTask->assign_to) {
            DB::table('time_cards')->where('task_id', $id)->delete();
            if ($storeData['assign_to'] != null) {
                DB::table('time_cards')->insert([
                    'project_id' => $storeData['project_id'],
                    'task_id' => $id,
                    'employee_id' => $storeData['assign_to'],
                    'activity_date' => now(),
                    'created_at' => now()
                ]);
            }
        }

        DB::table('tasks')
            ->where('id', $id)
            ->update(
                [
                    'project_id' => $storeData['project_id'],
                    'title' => $storeData['title'],
                    'summary' => $storeData['summary'],
                    'category_id' => $storeData['category_id'],
                    'start_date_estimation' => $storeData['start_date_estimation'],
                    'end_date_estimation' => $storeData['end_date_estimation'],
                    'created_by' =>  $storeData['created_by'],
                    'assign_to' => $storeData['assign_to'],
                    'status_id' => $storeData['status'],
                    'completion_time' => $storeData['completion_time'],
                    'use_holiday' => $storeData['use_holiday'],
                    'use_weekend' => $storeData['use_weekend'],
                    'attachment' => json_encode($storeData['attachments']),
                    'updated_at' => now()
                ]
            );

        DB::table('task_flagging')->where('task_id', $id)->delete();

        if (isset($storeData['selectedFlags']) && is_array($storeData['selectedFlags'])) {
            foreach ($storeData['selectedFlags'] as $flagId) {
                DB::table('task_flagging')->insert([
                    'task_id' => $id,
                    'flag_id' => $flagId,
                ]);
            }
        }

        DB::table('task_labeling')->where('task_id', $id)->delete();

        if (isset($storeData['selectedLabels']) && is_array($storeData['selectedLabels'])) {
            foreach ($storeData['selectedLabels'] as $flagId) {
                DB::table('task_labeling')->insert([
                    'task_id' => $id,
                    'label_id' => $flagId,
                ]);
            }
        }
    }

    public static function getById($id)
    {
        return DB::table('tasks')
            ->where('tasks.id', $id)
            ->join('task_statuses', 'tasks.status_id', '=', 'task_statuses.id')
            ->join('projects', 'tasks.project_id', '=', 'projects.id')
            ->join('app_user as creators', 'tasks.created_by', '=', 'creators.user_id')
            ->leftJoin('app_user as assignees', 'tasks.assign_to', '=', 'assignees.user_id')
            ->leftJoin('task_flagging', 'tasks.id', '=', 'task_flagging.task_id')
            ->leftJoin('task_flags', 'task_flagging.flag_id', '=', 'task_flags.id')
            ->leftJoin('task_labeling', 'tasks.id', '=', 'task_labeling.task_id')
            ->leftJoin('task_labels', 'task_labeling.label_id', '=', 'task_labels.id')
            ->leftJoin('task_categories', 'tasks.category_id', '=', 'task_categories.id')
            ->select(
                'tasks.*',
                'task_statuses.task_status as status_name',
                'projects.title as project_title',
                'creators.user_name as created_by_name',
                'assignees.user_name as assign_to_name',
                'task_categories.category_name as category_name',
                DB::raw('GROUP_CONCAT(task_flags.flag_name SEPARATOR ", ") as flag'),
                DB::raw('GROUP_CONCAT(task_labels.label_name SEPARATOR ", ") as label')
            )
            ->groupBy(
                'task_statuses.task_status',
                'projects.title',
                'task_categories.category_name',
                'tasks.id',
                'tasks.project_id',
                'tasks.title',
                'tasks.summary',
                'tasks.start_date_estimation',
                'tasks.end_date_estimation',
                'tasks.attachment',
                'tasks.created_by',
                'tasks.assign_to',
                'tasks.completion_time',
                'tasks.created_at',
                'tasks.updated_at',
                'tasks.status_id',
                'tasks.category_id',
                'tasks.use_holiday',
                'tasks.use_weekend',
                'tasks.deleted_at',
                'tasks.id',
                'creators.user_name',
                'assignees.user_name'
            )
            ->first();
    }

    public static function getArchivedTasks($projectId)
    {
        return DB::table('tasks')
            ->whereNotNull('deleted_at')
            ->join('task_statuses', 'tasks.status_id', '=', 'task_statuses.id')
            ->select(
                'tasks.*',
                'task_statuses.task_status as status_name',
            )
            ->get();
    }

    public static function softDelete($id)
    {
        DB::table('tasks')->where('id', $id)->update(['deleted_at' => now()]);
    }

    public static function restoreTask($id)
    {
        DB::table('tasks')->where('id', $id)->update(['deleted_at' => null]);
    }

    public static function delete($id)
    {
        DB::table('task_flagging')->where('task_id', $id)->delete();
        DB::table('time_cards')->where('task_id', $id)->delete();
        DB::table('tasks')->where('id', $id)->delete();
    }

    // ======================================================================== KEBUTUHAN REPORT ========================================================================

    // GET ALL REPORT
    public static function getAllReport()
    {
        return DB::table('tasks')
            ->whereNull('tasks.deleted_at')
            ->join('projects', 'tasks.project_id', '=', 'projects.id')
            ->leftJoin('app_user', 'tasks.assign_to', '=', 'app_user.user_id')
            ->leftJoin('task_statuses', 'tasks.status_id', '=', 'task_statuses.id')
            ->select(
                'tasks.*',
                'projects.title as project_title',
                'projects.completion',
                'task_statuses.task_status',
                'app_user.*'
            )
            ->get();
    }

    // ========================================================================POV: STAFF========================================================================

    private static function getHierarchyUp($auth)
    {
        $parent = EmployeeHierarchy::where('user_id', $auth)->first();
        // dd($parent);
        $current = $parent->parent;
        $atasan = [];
        while ($current != null) {
            $parentEmployee = EmployeeHierarchy::where('user_id', $current->user_id)->first();
            $paramAtasan = [
                'id' => $parentEmployee->user_id,
                'name' => $parentEmployee->getEmploye()->user_name,
                'email' => $parentEmployee->getEmploye()->user_email
            ];
            array_push($atasan, $paramAtasan);
            $current = $current->parent;
        }

        return $atasan;
    }


    private static function getHierarchyDown($auth) 

    {
        $dataBawahanLangsung = [];
        // Get bawahan dari user login
        $employee = EmployeeHierarchy::where('user_id', $auth)->whereHas('child')->first();

        if ($employee) {
            foreach ($employee->child as $e) {
                $param = [
                    'id' => $e->user_id,
                    'name' => $e->getEmploye()->user_name,
                    'email' => $e->getEmploye()->user_email
                ];

                $dataBawahanLangsung[] = $param;
            }

            // Get All bawahan
            $usr = EmployeeHierarchy::where('parent_id', $employee->user_id)->get();
            $dataSemuaBawahan = [];
            $no = 1;

            while (count($usr) > 0) {
                $nextUsr = [];
                foreach ($usr as $c) {
                    $param = [
                        'id' => $c->user_id,
                        'name' => $c->getEmploye()->user_name,
                        'email' => $c->getEmploye()->user_email
                    ];
                    array_push($dataSemuaBawahan, $param);
                    $nextUsr = array_merge($nextUsr, $c->child->all());
                }
                $no++;
                $usr = $nextUsr;
            }

            return $dataSemuaBawahan;
        }

        // return $dataBawahanLangsung;
    }

    // GET TASKS BY PROJECTS
    public static function getAllProjectTasksByAuth($projectId, $auth)
    {
        $isAdmin = DB::table('app_role_user')->where('user_id', $auth)->where('role_id', 20)->value('user_id');
        $dataSemuaBawahan = Task::getHierarchyDown($auth);
        // $dataSemuaAtasan = Task::getHierarchyUp($auth);

        // dd($isAdmin, $auth);

        if($auth == $isAdmin){
            // Ambil ID dari seluruh pengguna

            $allUser = DB::table('app_user')
            ->select('user_id')
            ->get()
            ->map(function ($user) {
                return (array) $user;
            })
            ->toArray();
            // Gabungkan semua ID
            $assignToIds = array_merge([$auth], $allUser);
        }elseif (!$dataSemuaBawahan) {
            $assignToIds = [$auth];
        } else {
            $bawahanIds = array_column($dataSemuaBawahan, 'id');
            // Tambahkan ID auth saat ini ke dalam daftar ID bawahan
            $assignToIds = array_merge([$auth], $bawahanIds);
        }

        return DB::table('tasks')
            ->where('tasks.project_id', $projectId)
            ->whereNull('tasks.deleted_at')
            // ->whereIn('tasks.assign_to', $assignToIds)
            ->join('task_statuses', 'tasks.status_id', '=', 'task_statuses.id')
            ->join('projects', 'tasks.project_id', '=', 'projects.id')
            ->join('app_user as creators', 'tasks.created_by', '=', 'creators.user_id')
            ->leftJoin('app_user as assignees', 'tasks.assign_to', '=', 'assignees.user_id')
            ->leftJoin('task_flagging', 'tasks.id', '=', 'task_flagging.task_id')
            ->leftJoin('task_flags', 'task_flagging.flag_id', '=', 'task_flags.id')
            ->leftJoin('task_labeling', 'tasks.id', '=', 'task_labeling.task_id')
            ->leftJoin('task_labels', 'task_labeling.label_id', '=', 'task_labels.id')
            ->leftJoin('task_categories', 'tasks.category_id', '=', 'task_categories.id')
            ->where(function ($query) use ($assignToIds) {
                $query->whereIn('tasks.assign_to', $assignToIds)
                    ->orWhere('tasks.status_id', 1);
            })
            ->select(
                'tasks.*',
                'task_statuses.task_status as status_name',
                'projects.title as project_title',
                'creators.user_name as created_by_name',
                'assignees.user_name as assign_to_name',
                'task_categories.category_name as category_name',
                DB::raw('GROUP_CONCAT(task_flags.flag_name SEPARATOR ", ") as flag'),
                DB::raw('GROUP_CONCAT(task_labels.label_name SEPARATOR ", ") as label')
            )
            ->groupBy(
                'tasks.id',
                'tasks.project_id',
                'tasks.title',
                'tasks.summary',
                'tasks.start_date_estimation',
                'tasks.end_date_estimation',
                'tasks.attachment',
                'tasks.created_by',
                'tasks.assign_to',
                'tasks.completion_time',
                'tasks.created_at',
                'tasks.updated_at',
                'tasks.status_id',
                'tasks.category_id',
                'tasks.use_holiday',
                'tasks.use_weekend',
                'tasks.deleted_at',
                'category_name',
                'status_name',
                'project_title',
                'created_by_name',
                'assign_to_name',
                // 'task_flags.flag_name',
                'creators.user_name',
                'assignees.user_name'
            )
            ->get();
    }

    // GET TASK BY PROJECT DAN STATUS
    public static function getTaskStatusByAuth($projectId, $status, $auth)
    {
        $dataSemuaBawahan = Task::getHierarchyDown($auth);
        if (!$dataSemuaBawahan) {
            $assignToIds = [$auth];
        } else {
            $bawahanIds = array_column($dataSemuaBawahan, 'id');
            $assignToIds = array_merge([$auth], $bawahanIds);
        }
        // dd($assignToIds);

        return DB::table('tasks')
            ->where('tasks.project_id', $projectId)
            ->whereNull('tasks.deleted_at')
            ->where('tasks.status_id', $status)
            // ->whereIn('tasks.assign_to', $assignToIds)
            ->join('task_statuses', 'tasks.status_id', '=', 'task_statuses.id')
            ->join('projects', 'tasks.project_id', '=', 'projects.id')
            ->join('app_user as creators', 'tasks.created_by', '=', 'creators.user_id')
            ->leftJoin('app_user as assignees', 'tasks.assign_to', '=', 'assignees.user_id')
            ->leftJoin('task_flagging', 'tasks.id', '=', 'task_flagging.task_id')
            ->leftJoin('task_flags', 'task_flagging.flag_id', '=', 'task_flags.id')
            ->leftJoin('task_labeling', 'tasks.id', '=', 'task_labeling.task_id')
            ->leftJoin('task_labels', 'task_labeling.label_id', '=', 'task_labels.id')
            ->leftJoin('task_categories', 'tasks.category_id', '=', 'task_categories.id')
            ->where(function ($query) use ($assignToIds) {
                $query->whereIn('tasks.assign_to', $assignToIds)
                    ->orWhere('tasks.status_id', 1);
            })
            ->select(
                'tasks.*',
                'task_statuses.task_status as status_name',
                'projects.title as project_title',
                'creators.user_name as created_by_name',
                'assignees.user_name as assign_to_name',
                'task_categories.category_name as category_name',
                DB::raw('GROUP_CONCAT(task_flags.flag_name SEPARATOR ", ") as flag'),
                DB::raw('GROUP_CONCAT(task_labels.label_name SEPARATOR ", ") as label')
            )
            ->groupBy(
                'tasks.id',
                'tasks.project_id',
                'tasks.title',
                'tasks.summary',
                'tasks.start_date_estimation',
                'tasks.end_date_estimation',
                'tasks.attachment',
                'tasks.created_by',
                'tasks.assign_to',
                'tasks.completion_time',
                'tasks.created_at',
                'tasks.updated_at',
                'tasks.status_id',
                'tasks.category_id',
                'tasks.use_holiday',
                'tasks.use_weekend',
                'tasks.deleted_at',
                'status_name',
                'project_title',
                'created_by_name',
                'assign_to_name',
                'category_name',
                // 'task_flags.flag_name'
            )
            ->get();
    }
    // ================================================================KEBUTUHAN CALENDAR================================================================

    // ================================================================KEBUTUHAN TIMECARD================================================================

    // GET TASK BY AUTH 
    public static function getTaskByAssignTo($auth)
    {
        return DB::table('tasks')
            ->whereNull('tasks.deleted_at')
            ->where('tasks.assign_to', $auth)
            ->join('task_statuses', 'tasks.status_id', '=', 'task_statuses.id')
            ->join('projects', 'tasks.project_id', '=', 'projects.id')
            ->join('task_categories', 'tasks.category_id', '=', 'task_categories.id')
            ->select(
                'tasks.*',
                'task_statuses.task_status as status_name',
                'projects.title as project_title',
                'task_categories.category_name as category_name',
            )
            ->get();
    }

    public static function updateStatus($id, array $storeData)
    {
        DB::table('tasks')
            ->where('id', $id)
            ->update($storeData);
    }

    public static function updateStatusProd(array $id, array $storeData)
    {
        // dd($id['tasks']);
        DB::table('tasks')
            ->whereIn('id', $id['tasks'])
            ->update($storeData);
    }

    // ================================================================FILTER QUERIES================================================================

    //SEARCH BY KEYWORD
    public static function scopeSearch($query, $searchTerm)
    {
        return $query->filter(function ($project) use ($searchTerm) {
            return stripos($project->title, $searchTerm) !== false ||
                // stripos($project->summary, $searchTerm) !== false ||
                stripos($project->created_by, $searchTerm) !== false ||
                stripos($project->assign_to, $searchTerm) !== false;
        });
    }

    public static function scopeFilterByTimeFrame($query, $column, $timeFrame)
    {
        $currentDate = Carbon::now();

        $query->each(function ($item) {
            $item->start_date_estimation = Carbon::parse($item->start_date_estimation);
            $item->end_date_estimation = Carbon::parse($item->end_date_estimation);
        });

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

    //=====================FOR RELEASE NOTE=====================

    // GET DATA FOR GENERATE RELEASE NOTE
    public static function collectData($id)
    {
        // dd($id);
        return DB::table('tasks')
            ->whereIn('id', $id)
            ->select('id', 'tasks.title', 'tasks.summary')
            ->get();
    }
    // Task::whereIn('id', $this->selectedTasks)->get(['title', 'summary']);

    // ================================================================DASHBOARD================================================================

    //TO BE COMPLETED
    public static function toBeCompleted($projectId)
    {
        return DB::table('tasks')
            ->where('tasks.project_id', $projectId)
            ->whereNull('t.deleted_at')
            ->whereIn('tasks.status_id', [1, 2, 3, 4])
            ->select('tasks.*')
            ->count();
    }

    //GET DATA TASK WITH COMPLETION
    public static function taskDelay($projectId)
    {
        $tasks = DB::table('tasks as t') // Menggunakan alias 't'
            ->where('t.project_id', $projectId)
            ->whereNull('t.deleted_at')
            ->whereNotNull('t.completion_time')
            ->orderBy('t.completion_time', 'desc')
            ->get();
        return $tasks;
        // dd($projectId);
    }


    // GET TOTAL DAY FOR PLAN SCHEDULE TASK 
    public static function taskPlanDay($taskId)
    {
        return DB::table('tasks')
            ->where('tasks.id', $taskId)
            ->whereNull('tasks.deleted_at')
            ->select(DB::raw('DATEDIFF(end_date_estimation, start_date_estimation) AS total_days'))
            ->get();
    }


    // DASHBOARD - PROGRESS
    public static function allGroupTasks($projectId)
    {
        return DB::table('tasks as t')
            ->whereNull('t.deleted_at')
            ->select('t.category_id', 'categories.category_name', DB::raw('count(*) as total'))
            ->leftJoin('task_categories as categories', 't.category_id', '=', 'categories.id')
            ->whereNotNull('t.category_id')
            ->where('project_id', $projectId)
            ->groupBy(
                't.category_id',
                'categories.category_name'
            )
            ->get();
    }

    public static function progressDone($projectId)
    {
        return DB::table('tasks as t')
            ->whereNull('t.deleted_at')
            ->select('t.category_id', DB::raw('count(*) as total'))
            ->where('t.project_id', $projectId)
            ->whereNotNull('t.category_id')
            ->where('t.status_id', 5)
            ->groupBy(
                't.id',
                't.project_id',
                't.title',
                't.summary',
                't.start_date_estimation',
                't.end_date_estimation',
                't.attachment',
                't.created_by',
                't.assign_to',
                't.completion_time',
                't.created_at',
                't.updated_at',
                't.status_id',
                't.category_id',
                't.category_id',
                't.use_holiday',
                't.use_weekend',
            )
            ->get();
    }


    // ================================================================RESOURCES TRACK================================================================


    // WORKLOAD
    public static function workloadCompleted($projectId)
    { // Assuming you have a Task model

        $tasks = DB::table('tasks')
            ->whereNull('tasks.deleted_at')
            ->join('app_user', 'tasks.assign_to', '=', 'app_user.user_id')
            ->select('tasks.assign_to', 'app_user.user_name as user_name', DB::raw("
        CASE
            WHEN end_date_estimation >= completion_time AND status_id = 5 THEN 'done'
            WHEN end_date_estimation < completion_time AND status_id = 5 THEN 'done_late'
            WHEN end_date_estimation < completion_time AND status_id != 5 THEN 'overdue'
            WHEN status_id IN (1, 2, 3, 7) THEN 'remaining'
            ELSE 'unknown'
        END as task_status
    "), DB::raw('count(*) as total'))
            ->where('tasks.project_id', $projectId)
            ->groupBy(
                'tasks.assign_to',
                'user_name',
                'task_status'
            )
            ->get();

        // Group tasks by user and status
        $groupedTasks = $tasks->groupBy('assign_to');

        // Get counts for each status per user, including user names
        $taskCounts = $groupedTasks->map(function ($tasksByStatus) {
            $userName = $tasksByStatus->first()->user_name;
            $statusCounts = $tasksByStatus->mapWithKeys(function ($task) {
                return [$task->task_status => $task->total];
            });
            return [
                'user_name' => $userName,
                'statuses' => $statusCounts
            ];
        });

        return $taskCounts;
    }

    // =============================== SISTEM PENDUKUNG KEPUTUSAN ======================================

}
