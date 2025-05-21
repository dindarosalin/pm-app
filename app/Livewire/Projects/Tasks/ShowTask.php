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
use App\Models\Settings\Role;
use Illuminate\Support\Facades\DB;
use App\Livewire\Projects\Tasks\Priorities;

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

    // FILTER VAR
    public $search = '';
    public $sortColumn = 'status_id';
    public $sortDirection = 'asc';
    public $filters = [];

    public $timeFrame = [];
    public $fromToDate;

    public $startFromDate = [];
    public $startToDate = [];

    public $endFromDate = [];
    public $endToDate = [];

    public $fromNumber = [];
    public $toNumber = [];

    public $scores;

    public function render()
    {
        $this->auth = Auth::user()->user_id;

        $this->totalTask = Task::getAllProjectTasksByAuth($this->projectId, $this->auth)->count();
        $this->projectDetail = Project::getById($this->projectId);
        $this->employees = collect($this->getEmployeesTask());
        $this->getAllTasks();

        // $this->filter($this->tasks);
        $this->tasks = $this->filter($this->tasks);
        // dd($this->tasks);
        return view('livewire.projects.tasks.show-task', [
            'totalTask' => $this->totalTask,
            'employees' => $this->employees,
            'flags' => $this->flags,
            'categories' => $this->categories,
            'labels' => $this->labels,
        ]);
    }

    public function getAllTasks()
    {
        // $this->tasks = Task::getAllProjectTasksByAuth($this->projectId, $this->auth);
        $t = Task::getAllProjectTasksByAuth($this->projectId, $this->auth);
        $ranking = collect($this->scores);
        // dd($this->scores);

        $this->tasks = $t->map(function ($task) use ($ranking) {
            $score = optional($ranking->firstWhere('task_id', $task->id))['score'] ?? null;
            $task->score = $score;
            return $task;
        });
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
                'text' => 'It will list on the table soon.',
            ]);
        } catch (\Throwable $th) {
            session()->flash('error', $th);
            // $this->dispatch('swal:modal', [
            //     'type' => 'error',
            //     'message' => 'Error',
            //     'text' => 'It not list on the table.'
            // ]);
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
        // dd($task);
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
        $this->use_holiday = (bool) $task->use_holiday;
        $this->use_weekend = (bool) $task->use_weekend;

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
        $isAdmin = DB::table('app_role_user')->where('user_id', $this->auth)->where('role_id', 20)->value('user_id');

        // dd($isAdmin, $this->auth);

        $dataBawahanLangsung = [];
        // Get bawahan dari user login
        $employee = EmployeeHierarchy::where('user_id', $this->auth)->whereHas('child')->first();

        if ($employee) {
            foreach ($employee->child as $e) {
                $param = [
                    'id' => $e->user_id,
                    'name' => $e->getEmploye()->user_name,
                    'email' => $e->getEmploye()->user_email,
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
                        'email' => $c->getEmploye()->user_email,
                    ];
                    array_push($dataSemuaBawahan, $param);
                    $nextUsr = array_merge($nextUsr, $c->child->all());
                }
                $no++;
                $usr = $nextUsr;
            }

            return $dataSemuaBawahan;

            // manage assign_to untuk admin
        } elseif ($this->auth == $isAdmin) {
            $allUser = DB::table('app_user')
                ->select(['user_id as id', 'user_name as name', 'user_email as email'])
                ->get()
                ->map(function ($user) {
                    return (array) $user;
                })
                ->toArray();

            // $allUser = EmployeeHierarchy::getAllEmployees();

            // dd($allUser);
            return $allUser;
        }
    }

    public function filter($tasks)
    {
        // dd('kefilter');
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
            foreach ($this->timeFrame as $column => $value) {
                if ($value === 'custom-start-date' && $column === 'start_date_estimation') {
                    $tasks = Project::scopeFilterByDateRange($tasks, $this->startFromDate, $this->startToDate, $column);
                } elseif ($value === 'custom-end-date' && $column === 'end_date_estimation') {
                    $tasks = Project::scopeFilterByDateRange($tasks, $this->endFromDate, $this->endToDate, $column);
                } else {
                    $tasks = Task::scopeFilterByTimeFrame($tasks, $column, $value);
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
        $this->sortColumn = 'status_id';
    }

    public function alertConfirm($id)
    {
        $this->dispatch('swal:confirm', [
            'type' => 'warning',
            'message' => 'Are you sure?',
            'text' => 'This will archive task',
            'id' => $id,
            'dispatch' => 'archive-task',
        ]);
    }

    #[On('archive-task')]
    public function archive($id)
    {
        Task::softDelete($id);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Archived',
            'text' => 'It will not list on the table.',
        ]);
    }

    #[On('update-task-score')]
    public function applyRanking($scoresData)
    {
        $this->scores = collect($scoresData);

        // dd($this->scores);
    }

    public function updatedScores()
    {
        $this->getAllTasks();
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
