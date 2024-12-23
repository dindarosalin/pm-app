<?php

namespace App\Livewire\Projects\Projects;

use App\Models\Employee\Department;
use App\Models\Employee\Employee;
use Livewire\Component;
use App\Models\Projects\Project;

class Table extends Component
{
    public $search = '';
    public $filters = [];
    public $sortColumn = null;
    public $sortDirection = 'asc';

    public $timeFrame = 'all'; //all, weekly, monthly, yearly

    public $fromDate = "";
    public $toDate = "";

    public function updatingSearch()
    {
        $this->reset();
    }

    public function updatingFilters()
    {
        $this->reset();
    }

    public function resetFilter(){
        $this->reset();
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

    public function render()
    {
        $teams = Department::getAllDepartments();
        $pm = Employee::getAll();
        $projects = Project::getAll();
        // dd($projects);

        if ($this->search) {
            $projects = Project::scopeSearch($projects, $this->search);
        }

        if ($this->filters) {
            foreach ($this->filters as $column => $value) {
                if (!empty($value)) {
                    $projects = Project::scopeFilter($projects, $column, $value);
                }
            }
        }

        if ($this->sortColumn) {
            $projects = Project::scopeSorting($projects, $this->sortColumn, $this->sortDirection);
        }

        if ($this->timeFrame) {
            $projects = Project::scopeFilterByTimeFrame($projects, $this->timeFrame);
        }

        if ($this->fromDate && $this->toDate) {
            $projects = Project::scopeFilterByDateRange($projects, $this->fromDate, $this->toDate);
        }

        return view('livewire.projects.projects.table', [
            'projects' => $projects, 'teams' => $teams, 'pm' => $pm
        ]);
    }
}

