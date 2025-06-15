<?php

namespace App\Livewire\Projects\Tasks;

use Livewire\Component;
use App\Models\Projects\Project;
use App\Models\Projects\Task\Task;

class Filter extends Component
{
    // FILTER VAR
    public $search = '';
    public $sortColumn = null;
    public $sortDirection = 'asc';
    public $filters = [];

    public $timeFrame = [];
    public $fromToDate;

    public $fromDate = [];
    public $toDate = [];

    public $fromNumber = [];
    public $toNumber = [];

    public $tasks;
    
    public function render()
    {
        return view('livewire.projects.tasks.filter');
    }

    public function filteringTasks()
    {
        // dd('halo');
        $t = $this->filter($this->tasks);
        $this->dispatch('filteredTasks', $t);
    }

    public function filter($tasks)
    {
        // Pencarian
        if ($this->search) {
            $tasks = Task::scopeSearch($tasks, $this->search);
        }

        // Sorting
        if ($this->sortColumn) {
            $tasks = Project::scopeSorting($tasks, $this->sortColumn, $this->sortDirection);
        }

        // Filter berdasarkan kolom
        if ($this->filters) {
            foreach ($this->filters as $column => $value) {
                if (!empty($value)) {
                    $tasks = Project::scopeFilter($tasks, $column, $value);
                }
            }
        }

        // Filter berdasarkan time frame dan date range
        if ($this->timeFrame) {
            foreach ($this->timeFrame as $column => $this->fromToDate) {
                if ($this->fromToDate === 'custom-start-date' || $this->fromToDate === 'custom-start' || $this->fromToDate === 'custom-end') {
                    $tasks = Task::scopeFilterByDateRange($tasks, $this->fromDate, $this->toDate, $column);
                } else {
                    $tasks = Task::scopeFilterByTimeFrame($tasks, $column, $this->fromToDate);
                }
            }
        }

        foreach ($this->fromNumber as $column => $fromValue) {
            $toValue = $this->toNumber[$column] ?? null;
            $tasks = Task::scopeFilterByNumberRange($tasks, $column, $fromValue, $toValue);
        }

        return $tasks;
    }

    public function sortBy($column)
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
        // $this->reset();
        $this->filters = [];
        $this->search = '';
        $this->timeFrame = [];
        $this->sortColumn = null;
    }
}
