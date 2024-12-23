<?php

namespace App\Livewire\Projects\GanttChart;

use App\Models\Master\Holiday;
use App\Models\Projects\Project;
use App\Models\Projects\Task\Task;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShowGanttChart extends Component
{
    public $tasks;
    public $projectId, $projectDetail;
    public $auth;
    public $holidays;

    public function render()
    {
        $this->auth = Auth::user();
        $this->projectDetail = Project::getById($this->projectId);
        $this->loadTask();
        return view('livewire.projects.gantt-chart.show-gantt-chart');
    }

    public function mount($projectId)
    {
        $this->projectId = $projectId;
    }

    public function loadTask()
    {
        $tasks = Task::getAllProjectTasksByAuth($this->projectId, $this->auth->user_id)->sortBy('status_id');
        $this->holidays = Holiday::getAll();
        // dd($this->holidays);

        $ganttTasks = [];

        // dd($this->holidays->pluck('date'));

        foreach ($tasks as $task) {
            $duration = $this->calculateBusinessDays(
                $task->start_date_estimation, 
                $task->end_date_estimation, 
                $this->holidays->pluck('date')
            );

            $ganttTasks[] = [
                'id' => $task->id,
                'text' => $task->title,
                'start_date' => Carbon::parse($task->start_date_estimation)->format('Y-m-d'),
                'end_date' => Carbon::parse($task->end_date_estimation)->addDay()->format('Y-m-d'),
                // 'end_date' => Carbon::parse($task->start_date_estimation)->addDays($duration)->format('Y-m-d'),
                'duration' => $duration,
                'progress' => 0,
                'parent' => $task->parent_id ?? 0
            ];
        }

        return $this->tasks = $ganttTasks;
    }

    public function calculateBusinessDays($startDate, $endDate, $holidays)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $businessDays = 0;

        while ($start->lte($end)) {
            $currentDate = $start->toDateString();

            if (!$start->isWeekend() && !$holidays->contains($currentDate)) {
                $businessDays++;
            }

            $start->addDay();
        }

        return $businessDays;
    }
}
