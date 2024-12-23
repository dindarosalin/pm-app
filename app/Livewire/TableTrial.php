<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Employee\Department;
use App\Models\Employee\Employee;
use App\Models\Project;
use App\Models\SubCategory;
// use App\Models\Projects\Project;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class TableTrial extends Component
{
    use WithPagination;

    public $perPage = 5;

    public $sortDir = 'DESC';

    public $sortBy = 'created_at';

    public $role = '';

    public $search = '';

    public $timeFrame = 'all';

    public $fromDate = "";
    public $toDate = "";

    public $departments;
    
    public $selectedDept = null;
    public $selectedEmpl = null;
    public $employees = [];

    public function search()
    {
        $this->resetPage();
    }

    public function setSortBy($sortByField)
    {

        if ($this->sortBy === $sortByField) {
            $this->sortDir = ($this->sortDir == "ASC") ? 'DESC' : "ASC";
            return;
        }

        $this->sortBy = $sortByField;
        $this->sortDir = 'DESC';
    }

    public function getFilteredProjects()
    {
        $query = Project::query();

        if ($this->timeFrame === 'weekly') {
            $query->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ]);
        } elseif ($this->timeFrame === 'monthly') {
            $query->whereBetween('created_at', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ]);
        }

        return $query;
    }

    public function getRangeDateProjects()
    {
        $query = Project::whereDate('created_at', '>=', $this->fromDate)
            ->whereDate('created_at', '<=', $this->toDate)
            ->get();

        return $query;
    }

    public function resetFilter()
    {
        $this->reset();
        $this->resetPage();
    }

    public function btnClose_Offcanvas()
    {
        $this->dispatch('close-off-canvas');
    }

    public function showOffCanvas()
    {
        $this->dispatch('show-off-canvas');
    }

    public function loadEmployees()
    {
        if ($this->selectedDept) {
            $this->employees = SubCategory::getSubCategoryByCategory($this->selectedDept);
        }
    }

    public function store()
    {
        // Contoh untuk menyimpan data
        $this->validate([
            'selectedDept' => 'required',
            'selectedEmpl' => 'required',
        ]);

        // Simpan logika di sini, misalnya membuat record baru di database.
        dd([
            'department' => $this->selectedDept,
            'employee' => $this->selectedEmpl,
        ]);
    }

    public function mount()
    {
        $this->departments = Category::getAllCategory();
        // dd($this->departments);
    }

    public function render()
    {
        $filteredProjectsQuery = $this->getFilteredProjects();

        if ($this->fromDate && $this->toDate) {
            $filteredProjectsQuery->whereDate('created_at', '>=', $this->fromDate)
                ->whereDate('created_at', '<=', $this->toDate);
        }

        $projects = $filteredProjectsQuery
            ->when($this->search, function ($query) {
                $query->search($this->search);
            })
            ->when($this->role !== '', function ($query) {
                $query->where('project_manager', $this->role);
            })
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        return view('livewire.table-trial', [
            'projects' => $projects,
        ]);
    }
}
