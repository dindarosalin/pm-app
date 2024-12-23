<?php

namespace App\Livewire\TimeCard;

use App\Models\Projects\Master\TaskStatuses as ModelTaskStatuses;
use App\Models\Projects\Project;
use App\Models\Projects\Task\Task;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class TableTaskList extends Component
{
    public $auth;

    public $tasks, $taskStatuses, $taskCount, $taskShow;
    public $timeCardId, $duration, $taskId, $projectId, $taskStatus;

    public $search = '';
    public $filters = [];
    public $sortColumn = null;
    public $sortDirection = 'asc';

    public $timeFrame = [];
    public $fromToDate;

    public $fromDate = [];
    public $toDate = [];

    public function render()
    {
        $this->loadTask();
        $this->tasks = $this->filter($this->tasks);
        $this->taskCount = $this->tasks->count();

        return view('livewire.time-card.table-task-list');
    }

    public function loadTask()
    {
        $today = Carbon::today();

        $this->taskStatuses = ModelTaskStatuses::getAll();

        $this->tasks = Task::getTaskByAssignTo($this->auth);
    }

    public function showById($id) 
    {
        try {
            $this->taskShow = Task::getById($id);
            $this->dispatch('show-view-offcanvas');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function filter($tasks)
    {
        // Pencarian
        if ($this->search) {
            $tasks = Task::scopeSearch($tasks, $this->search);
        }

        // Filter berdasarkan kolom
        if ($this->filters) {
            foreach ($this->filters as $column => $value) {
                if (!empty($value)) {
                    $tasks = Project::scopeFilter($tasks, $column, $value);
                }
            }
        }

        // Sorting
        if ($this->sortColumn) {
            $tasks = Project::scopeSorting($tasks, $this->sortColumn, $this->sortDirection);
        }

        // Filter berdasarkan time frame dan date range
        if ($this->timeFrame) {
            foreach ($this->timeFrame as $column => $this->fromToDate) {
                if ($this->fromToDate === 'custom-date') {
                    $tasks = Project::scopeFilterByDateRange($tasks, $this->fromDate, $this->toDate, $column);
                } else {
                    $tasks = Task::scopeFilterByTimeFrame($tasks, $column, $this->fromToDate);
                }
            }
        }

        return $tasks;
    }

    public function applySortBy($column)
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortColumn = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function resetFilter()
    {
        $this->reset(['search', 'filters', 'sortColumn', 'timeFrame']);
    }
}
