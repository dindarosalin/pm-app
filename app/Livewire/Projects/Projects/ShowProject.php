<?php

namespace App\Livewire\Projects\Projects;

use App\Models\Employee\Employee;
use App\Models\Master\Department;
use App\Models\Projects\Master\ProjectStatuses;
use App\Models\Projects\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;

class ShowProject extends Component
{
    use WithFileUploads;

    public $selectedTeams = [];
    public $attachments = [], $existingAttachments = [];
    public $status, $projectId, $title, $description, $client, $project_manager, $start_date, $created_by, $due_date_estimation, $budget, $completion;
    public $projectShow;

    public $search = '';
    public $filters = [];
    public $sortColumn = null;
    public $sortDirection = 'asc';

    public $timeFrame = [];
    public $fromToDate;

    public $fromDate = [];
    public $toDate = [];

    public $fromNumber = [];
    public $toNumber = [];

    public $auth;

    public function render()
    {
        $user = Auth::user()->user_name;
        $projectPaginate = DB::table('projects')->paginate(2);
        // dd($user);
        $projects = Project::getAll();  
        // dd($projects);
        $pm = User::all();
        $departments = Department::all();
        $projectStatuses = ProjectStatuses::getAll();

        $projects = $this->filter($projects);

        return view('livewire.projects.projects.show-project', [
            'projects' => $projects,
            'departments' => $departments,
            'pm' => $pm,
            'projectStatuses' => $projectStatuses,
            'projectPaginate' => $projectPaginate,
        ]);
    }

    public function mount() {
        $this->auth = Auth::user()->user_id;
    }

    public function filter($projects)
    {
        // Pencarian
        if ($this->search) {
            $projects = Project::scopeSearch($projects, $this->search);
        }

        // Filter berdasarkan kolom
        if ($this->filters) {
            foreach ($this->filters as $column => $value) {
                if (!empty($value)) {
                    $projects = Project::scopeFilter($projects, $column, $value);
                }
            }
        }

        // Filter berdasarkan time frame dan date range
        if ($this->timeFrame) {
            foreach ($this->timeFrame as $column => $this->fromToDate) {
                if ($this->fromToDate === 'custom-created' || $this->fromToDate === 'custom-start' || $this->fromToDate === 'custom-end') {
                    $projects = Project::scopeFilterByDateRange($projects, $this->fromDate, $this->toDate, $column);
                } else {
                    $projects = Project::scopeFilterByTimeFrame($projects, $column, $this->fromToDate);
                }
            }
        }

        foreach ($this->fromNumber as $column => $fromValue) {
            $toValue = $this->toNumber[$column] ?? null;
            $projects = Project::scopeFilterByNumberRange($projects, $column, $fromValue, $toValue);
        }

        // Sorting
        if ($this->sortColumn) {
            $projects = Project::scopeSorting($projects, $this->sortColumn, $this->sortDirection);
        }

        return $projects;
    }

    #[On('edit')]
    public function edit($id)
    {
        $this->dispatch('show-edit-offcanvas');
        $project = Project::getById($id);
        $teams = Project::editHelper($id);
        // dd($teams);
        $this->status = $project->status_id;
        $this->projectId = $project->id;
        $this->title = $project->title;
        $this->description = $project->description;
        $this->client = $project->client;
        $this->created_by = $project->created_by;
        $this->project_manager = $project->project_manager;
        $this->selectedTeams = $teams->pluck('id')->toArray();
        $this->budget = $project->budget;
        $this->start_date = $project->start_date;
        $this->due_date_estimation = $project->due_date_estimation;
        $this->existingAttachments = json_decode($project->attachments, true);
    }

    public function btnForm_Clicked()
    {
        $this->dispatch('show-create-offcanvas');
    }

    public function alertConfirm($id)
    {
        $this->dispatch('swal:confirm', [
            'type' => 'warning',
            'message' => 'Are you sure?',
            'text' => 'This will archive projects, their tasks, and time cards.',
            'id' => $id,
            'dispatch' => 'archive-project'
        ]);
    }

    public function btnClose_Offcanvas()
    {
        $this->reset();
        $this->dispatch('close-offcanvas');
    }

    private function projectValidate()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'client' => 'required|string|max:255',
            'project_manager' => 'required|exists:employees,id',
            'selectedTeams' => 'required|array',
            'selectedTeams.*' => 'exists:departments,id',
            'start_date' => 'required|date',
            'due_date_estimation' => 'required|date',
            'budget' => 'nullable|numeric',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:10240',
            'created_by' => 'nullable|string',
        ]);
    }

    public function save()
    {
        // $this->projectValidate();
        $attachmentsPaths = $this->existingAttachments ?? [];

        if ($this->attachments) {
            foreach ($this->attachments as $file) {
                $originalName = $file->getClientOriginalName();
                $filePath = $file->store('file', 'public');

                $attachmentsPaths[] = [
                    'name' => $originalName,
                    'path' => $filePath,
                ];
            }
        }

        try {
            if ($this->projectId) {
                Project::update([
                    'status' => $this->status,
                    'title' => $this->title,
                    'description' => $this->description,
                    'client' => $this->client,
                    'project_manager' => $this->project_manager,
                    'budget' => $this->budget,
                    'created_by' => $this->created_by,
                    'start_date' => $this->start_date,
                    'selectedTeams' => $this->selectedTeams,
                    'due_date_estimation' => $this->due_date_estimation,
                    'attachments' => $attachmentsPaths,
                ], $this->projectId);
                session()->flash('success', 'Project Updated Successfully!!');
            } else {
                Project::create([
                    'status' => 1,
                    'title' => $this->title,
                    'description' => $this->description,
                    'client' => $this->client,
                    'project_manager' => $this->project_manager,
                    'budget' => $this->budget,
                    'created_by' => Auth::user()->user_id,
                    'start_date' => $this->start_date,
                    'selectedTeams' => $this->selectedTeams,
                    'due_date_estimation' => $this->due_date_estimation,
                    'attachments' => $attachmentsPaths,
                ]);
                session()->flash('success', 'Project Created Successfully!!');
            }

            $this->dispatch('close-offcanvas');
            $this->dispatch('swal:modal', [
                'type' => 'success',
                'message' => 'Data Saved',
                'text' => 'It will list on the table soon.'
            ]);
            $this->reset();
        } catch (\Throwable $th) {
            session()->flash('error', $th);
        }
    }

    public function removeAttachment($type, $key)
    {
        if ($type === 'new') {
            unset($this->attachments[$key]);
        } else {
            Storage::disk('public')->delete($this->existingAttachments[$key]['path']);
            unset($this->existingAttachments[$key]);
        }
    }

    // GET PROJECT BY ID
    #[On('showById')]
    public function showById($id)
    {
        try {
            $this->projectShow = Project::getById($id);
            $this->projectShow->attachments = json_decode($this->projectShow->attachments, true);
            $this->dispatch('show-view-offcanvas');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // DELETE PROJECT
    #[On('archive-project')]
    public function archive($id)
    {
        Project::softDelete($id);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.'
        ]);
    }

    // FILTER
    public function resetFilter()
    {
        $this->reset();
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

    public function showAlert()
    {
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.'
        ]);
    }
}
