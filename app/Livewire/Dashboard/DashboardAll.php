<?php

namespace App\Livewire\Dashboard;

use App\Models\Projects\Project;
use App\Models\Projects\Task\Task;
use DivisionByZeroError;
use Illuminate\Support\Carbon;
use Livewire\Component;
use App\Services\evmService;

class DashboardAll extends Component
{
    public $percentagesProgress;

    public $time;

    // evm data all projects
    public $evmData;

    // data collection for the tasks dounats
    public $tasks;

    // projects count by status
    public $projectsCountByStatus;




    public function getDataOnsite() {}

    public function getDataWfh() {}

    public function projectOnSuchedule() {}

    public function projectBehindSchedule() {}

    public function totalResources() {}



    // GET ALL PROJECT TASKS
    public function tasksAll()
    {
        $taskNotStarted = Task::getDoneAllProjectTasks([1, 2])->count();
        $taskOnProgress = Task::getDoneAllProjectTasks([3, 4])->count();
        $taskDone = Task::getDoneAllProjectTasks([5, 6])->count();
        $taskHold = Task::getDoneAllProjectTasks([7])->count();
        $taskCancel = Task::getDoneAllProjectTasks([8])->count();


        return ['notStart' => $taskNotStarted, 'onProgress' => $taskOnProgress, 'done' => $taskDone, 'hold' => $taskHold, 'cancel' => $taskCancel];
    }

    // Count projects by status id
    public function projectsCountByStatus()
    {
        return project::projectsCountByStatus();
    }



    // PROJECT PROGESS
    public function projectProgress()
    {
        return Project::getAll()->map(function ($project) {
            return [
                'title' => $project->title,
                'completion' => $project->completion,
                'status' => $project->status,
            ];
        });
        // dd($this->percentagesProgress);
    }



    // TIME
    public function time()
    {
        // PRESENTASE PENYELESAIAN /PROYEK
        // Menghitung persentase penyelesaian per proyek
        $allTasks = Task::getAllTasks();
        $completedTasks = Task::getDoneAllProjectTasks([5, 6]);

        $projectProgress = $allTasks->map(function ($project) use ($completedTasks) {
            $completed = $completedTasks->firstWhere('project_id', $project->project_id);
            $done = $completed->total_tasks_done ?? 0;

            $percentage = $project->total_tasks > 0
                ? ($done / $project->total_tasks) * 100
                : 0;

            return [
                'project_id' => $project->project_title,
                'total_tasks' => $project->total_tasks,
                'total_tasks_done' => $done,
                'progress' => round($percentage, 2) . '%',
            ];
        });

        // dd($projectProgress);
        // return [$evAll, $taskDone];
    }

    // COST
    public function costProjects()
    {
        return Project::getAll()->map(function ($projectCosts) {
            return [
                'id' => $projectCosts->id,
                'title' => $projectCosts->title,
                'budget' => $projectCosts->budget,
            ];
        });

        // dd($cost);


        // Get the actual cost from the related table/column

    }



    public function mount()
    {
        // GET ALL PROJECTS DATA FOR HEALTH
        $projects = Project::getAllProjectsDashboard();
        // dd($projects);

        $this->evmData = $projects->map(function ($project) {
            return EvmService::calculateEVM($project);
        });

        // dd($this->evmData);

        // TASKS DOUNATS
        $this->projectsCountByStatus = $this->projectsCountByStatus();
        // dd($this->projectsCountByStatus());

        // PROGRESS
        $this->percentagesProgress = $this->projectProgress();

        // TIME
        // dd($this->timeData());
        $this->time();

        // COST
        $this->costProjects();
        // dd($projects);
    }



    public function render()
    {
        return view('livewire.dashboard.dashboard-all');
    }
}
