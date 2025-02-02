<?php

namespace App\Livewire\Projects\Tasks;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Projects\Project;
use App\Models\Employee\Employee;
use App\Models\Projects\Task\Task;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\Authenticate;
use App\Models\Projects\Task\Comment;
use App\Models\Projects\Master\TaskFlags;
use App\Models\Projects\Master\TaskLabel;
use App\Models\Employee\EmployeeHierarchy;
use App\Models\Projects\Master\TaskCategory;
use App\Models\Projects\Master\TaskStatuses;

class ShowTask extends Component
{
    public $totalTask, $projectDetail;

    public $taskCounts = [];

    public $taskId, $title, $summary, $category, $start_date_estimation, $end_date_estimation, $created_by, $assign_to;
    public $use_weekend = false;
    public $use_holiday = false;
    public $attachments = [];
    public $selectedFlags = [];
    public $selectedLabels = [];
    public $employees, $flags, $categories, $labels;

    public $tasks;

    public $status = 1;

    public $statuses;

    public $taskShow;

    public $projectId;
    public $auth;

    public $comment;
    public $countComment;

    public $search = '';
    public $sortColumn = null;
    public $sortDirection = 'asc';
    public $filters = [];

    public function render()
    {
        $this->auth = Auth::user()->user_id; // -> 1
        // $this->auth = '16825598905258'; // -> 2
        // $this->auth = '16838855416673'; // -> 3
        // $this->auth = '1672385124827'; // -> 4

        $this->totalTask = Task::getAllProjectTasksByAuth($this->projectId, $this->auth)->count();
        $this->projectDetail = Project::getById($this->projectId);
        $this->employees = collect($this->getEmployeesTask());
        $this->getAllTasks();
        $this->tasks = $this->filter($this->tasks);

        // dd($this->tasks);
        
        // if role admin
        // $user = User::select('user_id AS id', 'user_name AS name', 'user_email AS email')->get()->toArray();
        // $this->employees = collect($user);

        return view('livewire.projects.tasks.show-task', [
            'totalTask' => $this->totalTask,
            'employees' => $this->employees,
            'flags' => $this->flags,
            'categories' => $this->categories,
            'labels' => $this->labels,
        ]);
    }

    public function getAllTasks(){
        $this->tasks = Task::getAllProjectTasksByAuth($this->projectId, $this->auth);
    }

    #[On('updateTaskCount')]
    public function updateTaskCount($status, $count)
    {
        $this->taskCounts[$status] = $count;
    }

    public function btnClose_Offcanvas()
    {
        $this->resetForm();
        $this->dispatch('close-offcanvas');
    }

    public function mount()
    {
        $this->dispatch('handle-project-id', $this->projectId);
        $this->flags = TaskFlags::getAll();
        $this->categories = TaskCategory::getAll();
        $this->labels = TaskLabel::getAll();
        $this->projectId;

        // Cek user punya bawahan apa engga
        $employee = EmployeeHierarchy::where('user_id', $this->auth)->whereHas('child')->first();
        if (!$employee) {
            $this->statuses = TaskStatuses::getExceptNew();
        } else {
            $this->statuses = TaskStatuses::getAll();
        }

        $this->statuses = TaskStatuses::getAll();

        foreach ($this->statuses as $status) {
            $this->taskCounts[$status->id] = 0;
        }
    }

    public function save()
    {
        if ($this->status >= 5) {
            $completion_time = Carbon::now();
        } else {
            $completion_time = null;
        }

        $storeData = [
            'project_id' => $this->projectId,
            'title' => $this->title,
            'selectedFlags' => $this->selectedFlags,
            'selectedLabels' => $this->selectedLabels,
            'category_id' => $this->category,
            'summary' => $this->summary,
            'start_date_estimation' => $this->start_date_estimation,
            'end_date_estimation' => $this->end_date_estimation,
            'created_by' => $this->auth,
            'assign_to' => $this->assign_to,
            'status' => $this->status,
            'attachments' => $this->attachments,
            'completion_time' => $completion_time,
            'use_weekend' => $this->use_weekend,
            'use_holiday' => $this->use_holiday,
        ];

        try {
            // dd($storeData);
            if ($this->taskId) {
                Task::update($storeData, $this->taskId);
            } else {
                Task::create($storeData);
                $this->updatedProjectStatus($this->projectId);
            }

            $this->resetForm();
            Project::calculateCompletion($this->projectId);
            $this->dispatch('close-offcanvas');
            $this->dispatch('task-updated');
            $this->dispatch('swal:modal', [
                'type' => 'success',
                'message' => 'Data Saved',
                'text' => 'It will list on the table soon.'
            ]);
        } catch (\Throwable $th) {
            session()->flash('error', $th);
            $th->getMessage();
        }
    }

    public function updatedAssignTo()
    {
        if ($this->assign_to) {
            $this->status = 2;
        } else {
            $this->status = 1;
        }

        $this->save();
    }

    public function updatedStatus()
    {
        // dd($this->status);
        if ($this->status >= 2) {
            $this->status;
        }
        $this->save();
    }

    public function resetForm()
    {
        $this->taskId = '';
        $this->selectedFlags = '';
        $this->category = '';
        $this->status = 1;
        $this->title = '';
        $this->summary = '';
        $this->start_date_estimation = '';
        $this->end_date_estimation = '';
        $this->assign_to = null;
        $this->attachments = '';
        $this->use_holiday = false;
        $this->use_weekend = false;
        $this->dispatch('clear-summary');
    }

    #[On('showById')]
    public function showById($id)
    {
        try {
            $this->taskShow = Task::getById($id);
            // dd($this->taskShow);
            $this->dispatch('show-view-offcanvas');
            $this->dispatch('taskId', taskId: $this->taskShow->id);
            // $this->countComment = $this->commentCount();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    #[On('edit')]
    public function edit($id)
    {
        $task = Task::getById($id);
        $data = Task::editHelper($id);
        $flags = $data['flags'];
        $labels = $data['labels'];
        $this->dispatch('load-summary', summary: $task->summary);
        // dd($task->summary);
        $this->taskId = $task->id;
        $this->selectedFlags = $flags->pluck('id')->toArray();
        $this->selectedLabels = $labels->pluck('id')->toArray();
        $this->title = $task->title;
        $this->category = $task->category_id;
        $this->summary = $task->summary;
        $this->start_date_estimation = $task->start_date_estimation;
        $this->end_date_estimation = $task->end_date_estimation;
        $this->created_by = $task->created_by;
        $this->assign_to = $task->assign_to;
        $this->status = $task->status_id;
        $this->use_holiday = $task->use_holiday;
        $this->use_weekend = $task->use_weekend;

        $this->dispatch('show-edit-offcanvas');
    }

    public function updatedProjectStatus($projectId)
    {
        // dd('masuk ga');
        $taskAll = Task::getAllProjectTasks($projectId)->count();

        if ($taskAll >= 1) {
            $projectStatus = 2;
        }

        Project::updateProjectStatus($this->projectId, $projectStatus);
    }

    public function getEmployeesTask()
    {
        $dataBawahanLangsung = [];
        // Get bawahan dari user login
        $employee = EmployeeHierarchy::where('user_id', $this->auth)->whereHas('child')->first();

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

    // public function sendComment()
    // {
    //     $user = Auth::user()->user_id;
    //     // dd($user);
    //     $storeData = [
    //         'id_task' => $this->taskShow->id,
    //         'id_employee' => $user,
    //         'comment' => $this->comment,
    //     ];

    //     Comment::create($storeData);
    //     // return dd($this->taskShow);
    //     $this->dispatch('swal:modal', [
    //         'type' => 'success',
    //         'message' => 'Send',
    //         'text' => 'It will not list on the table.'
    //     ]);

    //     // dd($this->taskShow->id);
    //     $this->dispatch('clear-comment');
    //     $this->dispatch('showById', id: $this->taskShow->id);
    //     $this->dispatch('updateComment', taskId: $this->taskShow->id);

    //     // dd($this->comment);

    // }

    public function commentCount()
    {
        // dd($this->taskShow->id);
        return Comment::countByTask($this->taskShow->id);

    }
}
