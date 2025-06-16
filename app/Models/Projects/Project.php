<?php

namespace App\Models\Projects;

use App\Models\Base\BaseModel;
use App\Models\Projects\Task\Task;
use Carbon\Carbon;
use FontLib\TrueType\Collection;
use Illuminate\Support\Facades\DB;

class Project extends BaseModel
{
    // CREATE PROJECTS
    public static function create(array $storeData)
    {
        // Insert ke tabel projects
        $projectId = DB::table('projects')->insertGetId([
            'status_id' => $storeData['status'],
            'title' => $storeData['title'],
            'description' => $storeData['description'],
            'client' => $storeData['client'],
            'project_manager' => $storeData['project_manager'],
            'budget' => $storeData['budget'],
            'created_by' => $storeData['created_by'],
            'start_date' => $storeData['start_date'],
            // 'team' => json_encode($storeData['selectedTeams']),
            'due_date_estimation' => $storeData['due_date_estimation'],
            'attachments' => json_encode($storeData['attachments']),
            'created_at' => now(),
        ]);

        // Insert ke pivot table
        if (isset($storeData['selectedTeams']) && is_array($storeData['selectedTeams'])) {
            foreach ($storeData['selectedTeams'] as $teamId) {
                DB::table('project_team')->insert([
                    'project_id' => $projectId,
                    'department_id' => $teamId,
                ]);
            }
        }

        return $projectId;
    }

    // UPDATE PROJECTS
    public static function update(array $storeData, $id)
    {
        DB::table('projects')->where('id', $id)->update([
            'status_id' => $storeData['status'],
            'title' => $storeData['title'],
            'description' => $storeData['description'],
            'client' => $storeData['client'],
            'project_manager' => $storeData['project_manager'],
            'budget' => $storeData['budget'],
            'created_by' => $storeData['created_by'],
            'start_date' => $storeData['start_date'],
            'due_date_estimation' => $storeData['due_date_estimation'],
            'attachments' => json_encode($storeData['attachments']),
            'updated_at' => now(),
        ]);

        DB::table('project_team')->where('project_id', $id)->delete();

        if (isset($storeData['selectedTeams']) && is_array($storeData['selectedTeams'])) {
            foreach ($storeData['selectedTeams'] as $teamId) {
                DB::table('project_team')->insert([
                    'project_id' => $id,
                    'department_id' => $teamId,
                ]);
            }
        }
    }

    public static function editHelper($id)
    {
        $teamIds = DB::table('project_team')
            ->where('project_id', $id)
            ->pluck('department_id')
            ->toArray();

        return DB::table('master_department')
            ->whereIn('id', $teamIds)
            ->get();
    }

    // UPDATE COMPLETION
    public static function updateCompletion($value, $id)
    {
        DB::table('projects')
            ->where('id', $id)
            ->update([
                'completion' => $value,
                'updated_at' => now()
            ]);
    }

    // UPDATE Project Status
    public static function updateProjectStatus($id, $storeData)
    {
        DB::table('projects')
            ->where('id', $id)
            ->update([
                'status_id' => $storeData,
                'completion_date' => now(),
                'updated_at' => now()
            ]);
    }

    public static function all()
    {
        return DB::table('projects');
    }

    // GET ALL PROJECTS
    public static function getAll()
    {
        return DB::table('projects')
            ->whereNull('deleted_at')
            ->join('app_user', 'projects.project_manager', '=', 'app_user.user_id')
            ->leftJoin('project_team', 'projects.id', '=', 'project_team.project_id')
            ->join('master_department', 'project_team.department_id', '=', 'master_department.id')
            ->join('project_statuses', 'projects.status_id', '=', 'project_statuses.id')
            ->select(
                'projects.*',
                'app_user.user_name as pm_name',
                'project_statuses.project_status as status',
                DB::raw('GROUP_CONCAT(master_department.name SEPARATOR ", ") as team_names')
            )
            ->groupBy(
                'projects.id',
                'app_user.user_name',
                'projects.title',
                'projects.description',
                'projects.client',
                'projects.project_manager',
                'projects.budget',
                'projects.start_date',
                'projects.due_date_estimation',
                'projects.completion',
                'projects.attachments',
                'projects.completion_date',
                'projects.created_at',
                'projects.updated_at',
                'projects.created_by',
                'projects.status_id',
                'status',
                'deleted_at'
            )
            ->orderBy('projects.created_at', 'desc')
            ->get();
    }

    //GET PROJECT BY ID
    public static function getById($id)
    {
        return DB::table('projects')
            ->where('projects.id', $id)  // Specify the table name for 'id'
            ->join('app_user', 'projects.project_manager', '=', 'app_user.user_id')
            ->leftJoin('project_team', 'projects.id', '=', 'project_team.project_id') // Join ke table penghubung (pivot table)
            ->join('master_department', 'project_team.department_id', '=', 'master_department.id')
            ->join('project_statuses', 'projects.status_id', '=', 'project_statuses.id')
            ->select(
                'projects.*',
                'app_user.user_name as pm_name',
                'project_statuses.project_status as status',
                DB::raw('GROUP_CONCAT(master_department.name SEPARATOR ", ") as team_names')
            )
            ->groupBy(
                'projects.id',
                'app_user.user_name',
                'projects.title',
                'projects.description',
                'projects.client',
                'projects.project_manager',
                'projects.budget',
                'projects.start_date',
                'projects.due_date_estimation',
                'projects.completion',
                'projects.attachments',
                'projects.completion_date',
                'projects.created_at',
                'projects.updated_at',
                'projects.created_by',
                'projects.status_id',
                'status',
                'deleted_at'
            )
            ->orderBy('projects.created_at', 'desc')
            ->first();
    }

    //DELETE PROJECT
    public static function delete($id)
    {
        DB::table('tasks')->where('project_id', $id)->delete();
        DB::table('time_cards')->where('project_id', $id)->delete();
        DB::table('release_notes')->where('id_project', $id)->delete();
        DB::table('plans')->where('id_project', $id)->delete();
        DB::table('tracks')->where('id_project', $id)->delete();
        DB::table('projects')->where('id', $id)->delete();
    }

    public static function getArchivedProjects()
    {
        return DB::table('projects')->whereNotNull('deleted_at')->get();
    }

    public static function softDelete($id)
    {
        DB::table('tasks')->where('project_id', $id)->update(['deleted_at' => now()]);
        DB::table('projects')->where('id', $id)->update(['deleted_at' => now()]);
    }

    public static function restoreProject($id)
    {
        DB::table('projects')->where('id', $id)->update(['deleted_at' => null]);
    }


    public static function getProjectByAuth($employeeId)
    {
        return DB::table('projects')
            ->join('tasks', 'projects.id', '=', 'tasks.project_id')
            ->where('tasks.assign_to', $employeeId)
            ->select('projects.*')
            ->distinct()
            ->get();
    }

    public static function getForBudget()
    {
        return DB::table('projects')
            ->select('id', 'title', 'budget', 'due_date_estimation')
            ->get();
    }

    public static function getTitle($projectId)
    {
        return DB::table('projects')
            ->where('id', $projectId)
            ->value('title');
    }

    public static function getTitleProject($title)
    {
        return DB::table('projects')
            ->where('title', $title)
            ->first();
    }

    // ======================================== FILTER ========================================

    //SEARCH BY KEYWORD
    public static function scopeSearch($query, $searchTerm)
    {
        return $query->filter(function ($project) use ($searchTerm) {
            return stripos($project->title, $searchTerm) !== false ||
                stripos($project->client, $searchTerm) !== false ||
                stripos($project->pm_name, $searchTerm) !== false ||
                stripos($project->budget, $searchTerm) !== false ||
                stripos($project->team_names, $searchTerm) !== false ||
                stripos($project->completion, $searchTerm) !== false;
        });
    }

    // FILTER PROJECTS
    public static function scopeFilter($query, $column, $value)
    {
        return $query->where($column, $value);
    }

    // SORTING PROJECTS
    public static function scopeSorting($query, $column, $direction)
    {
        return $query->sortBy(function ($query) use ($column) {
            return $query->$column;
        }, SORT_REGULAR, $direction === 'desc');
    }

    // FILTER DAILY-WEEKLY-MONTHLY-ALL
    public static function scopeFilterByTimeFrame($query, $column, $timeFrame)
    {
        $currentDate = Carbon::now();

        $query->each(function ($item) {
            $item->start_date = Carbon::parse($item->start_date);
            $item->due_date_estimation = Carbon::parse($item->due_date_estimation);
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

    // FILTER DATE RANGE
    public static function scopeFilterByDateRange($query, $fromDate, $toDate, $column)
    {
        if ($fromDate !== null && $toDate !== null) {
            return $query->whereBetween($column, [$fromDate, $toDate]);
        } elseif ($fromDate !== null) {
            return $query->where($column, '>=', $fromDate);
        } elseif ($toDate !== null) {
            return $query->where($column, '<=', $toDate);
        }

        return $query;
    }

    // FILTER NUMBER RANGE
    public static function scopeFilterByNumberRange($query, $column, $fromNumber, $toNumber)
    {
        if ($fromNumber !== null && $toNumber !== null) {
            return $query->whereBetween($column, [$fromNumber, $toNumber]);
        } elseif ($fromNumber !== null) {
            return $query->where($column, '>=', $fromNumber);
        } elseif ($toNumber !== null) {
            return $query->where($column, '<=', $toNumber);
        }

        return $query;
    }

    //======================================================================DASHBOARD======================================================================
    public static function cost($projectId)
    {
        return DB::table('cost')
            ->where('cost.id', $projectId)
            ->select('cost.*')
            ->get();
    }

    // public $taskCount;
    public static function calculateCompletion($projectId)
    {
        $taskAll = Task::getAllProjectTasks($projectId)->count();

        $count = DB::table('tasks')
            ->where('project_id', $projectId)
            ->whereBetween('status_id', [5, 8])
            ->count();

        $taskCount = ($count / $taskAll) * 100;
        // dd('jumlah task: '.$taskAll, 'task selesai: '.$taskDone, 'hasil: '.$this->taskCount);
        Project::updateCompletion($taskCount, $projectId);
        if ($taskCount == 100) {
            // dd('masuk ga');
            $projectStatus = 3;
            Project::updateProjectStatus($projectId, $projectStatus);
        }
    }

    //======================================================================DASHBOARD ALL======================================================================
    public static function getAllProjectsDashboard()
    {
        $now = Carbon::now()->format('Y-m-d');

        $trackSub = DB::table('tracks')
            ->select('id_project', DB::raw('SUM(total_per_item) as ac'))
            ->groupBy('id_project');

        return DB::table('tasks')
            ->join('projects', 'tasks.project_id', '=', 'projects.id')
            ->leftJoinSub($trackSub, 'track_summary', function ($join) {
                $join->on('tasks.project_id', '=', 'track_summary.id_project');
            })
            ->select(
                'tasks.project_id',
                'projects.title as project_title',
                'projects.budget as bac',
                DB::raw('COUNT(*) as total_task'),
                DB::raw("SUM(CASE WHEN end_date_estimation <= '$now' THEN 1 ELSE 0 END) as planned_done_task"),
                DB::raw("SUM(CASE WHEN tasks.status_id = 5 THEN 1 ELSE 0 END) as actual_done_task"),
                'track_summary.ac'
            )
            ->groupBy('tasks.project_id', 'projects.budget', 'project_title', 'track_summary.ac')
            ->get();
    }

    /**
     * Menghitung jumlah project berdasarkan status yang diberikan.
     * 
     * @param array|null $statusMap Array dengan key bebas dan value array/list id status, 
     *        atau null untuk mengambil semua status dari tabel master.
     *        Contoh: ['onProgress' => [3,4], 'done' => [5,6]]
     *        Jika null, akan return count untuk semua status di master.
     * @return array
     */
    public static function projectsCountByStatus()
    {

        // Ambil semua status dari tabel master
        $statuses = DB::table('project_statuses')->pluck('id', 'project_status')->toArray();
        $result = [];
        foreach ($statuses as $name => $id) {
            $result[$name] = DB::table('projects')->where('status_id', $id)->count();
        }
        return $result;


        $result = [];
        foreach ($statusMap as $key => $statusIds) {
            $result[$key] = DB::table('projects')->whereIn('status_id', (array)$statusIds)->count();
        }
        return $result;
    }
}
