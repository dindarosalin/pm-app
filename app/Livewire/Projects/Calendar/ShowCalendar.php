<?php

namespace App\Livewire\Projects\Calendar;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Master\Holiday;
use App\Models\Projects\Project;
use App\Models\Projects\Task\Task;
use Illuminate\Support\Facades\Auth;

class ShowCalendar extends Component
{
    public $tasks = [];
    public $projectId, $projectDetail;
    public $auth;
    public $holidays = [];
    public $events;

    public function render()
    {
        $this->auth = Auth::user();
        $this->projectDetail = Project::getById($this->projectId);
        $this->loadTask();
        return view('livewire.projects.calendar.show-calendar');
    }

    public function loadTask(){
        $holidays = Holiday::getAll();
        $tasks = Task::getAllProjectTasksByAuth($this->projectId, $this->auth->user_id);

        foreach ($holidays as $holiday){
            $newHoliday = [
                'title' => $holiday->name,
                'start' => $holiday->date,
                'description' => $holiday->description,
                'display' => 'background',
                'color' => 'pink'
            ];
            $this->holidays[] = $newHoliday;
        }

        foreach ($tasks as $task) {
            $newTask = [
                'title' => $task->title,
                'start' => Carbon::parse($task->start_date_estimation),
                'end' => Carbon::parse($task->end_date_estimation)->addDay(),
                'link' => $task->id
            ];
            $this->tasks[] = $newTask;
        }

        $this->events = array_merge($this->tasks, $this->holidays);
    }
}
