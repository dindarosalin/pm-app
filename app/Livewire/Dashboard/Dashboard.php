<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use DivisionByZeroError;
use Illuminate\Support\Carbon;
use App\Models\Projects\Project;
use App\Models\Projects\Task\Task;
use App\Models\Projects\Budget\Plan\Plan;
use App\Models\Projects\Budget\Track\Track;

class Dashboard extends Component
{
    public $projectId;
    // DESCRIPTION
    public $project;

    // HEALTH
    public $toBeCompleted = 0, $cost = 0, $actualBudget = 0;
    public $progress = 0, $ev = 0, $pv = 0, $ac = 0, $cpi = 0, $spi = 0;

    public $spiMessage, $cpiMessage;

    // TASK
    public $tasks = 0, $tasksDone = 0, $tasksNotStarted = 0, $tasksInProgress = 0, $totalTasks = 0;

    //COST
    //budget
    public  $plannedBudget = 0, $budget = 0, $plannedValue=0;

    //TIME
    public $timeAhead = 0;

    //PROGRES
    public $percentagesProgress = 0;

    //WORKLOAD
    public $taskOver = 0, $workload;

    //Get hari yang telah berlalu
    public function hitungDay()
    {
        $tanggalMulai = Carbon::parse($this->project->start_date);
        $hariIni = Carbon::today();
        // $hariIni = Carbon::parse(2020 - 1 - 20);
        $selisihHariNow = $tanggalMulai->diffInWeekdays($hariIni);

        return $selisihHariNow;
    }

    //Menghitung waktu pengerjaan project
    public function countDay()
    {
        $tanggalMulai = Carbon::parse($this->project->start_date);
        $tangalSelesai = Carbon::parse($this->project->due_date_estimation);
        $selisihHariKerja = $tanggalMulai->diffInWeekdays($tangalSelesai);

        return $selisihHariKerja;
    }


    public function taskDelay()
    {
        $tasks = task::taskDelay($this->projectId);
        $taskDelay = $tasks->filter(function ($task) {
            return $task->completion_time > $task->end_date_estimation;
        })->count();
        return $taskDelay;
    }

    public function allTask()
    {
        return task::getAllProjectTasks($this->projectId);
    }

    public function totalTasks()
    {
        try {
            
            $totalTasks = task::getAllProjectTasks($this->projectId)->count();
        } catch (DivisionByZeroError $e) {
            $totalTasks = 0;
        }
        
        return $totalTasks;
    }

    public function earnedValue()
    {

        try {

            $ev = round(task::getDoneProjectTasks($this->projectId, [5,6])->count() / Dashboard::allTask()->count() * 100, 2);
        } catch (DivisionByZeroError $e) {

            $ev = 0;
        }
        // $this->ev = $allTask;
        return $ev;
    }

    public function plannedValue()
    {
        $allTask = 0;
        $all = Dashboard::allTask();


        //mencari project yang harus diselesaikan sampai hari ini
        $currentDate = Carbon::now();
        $doTasks = $all->filter(function ($task) use ($currentDate) {
            return Carbon::parse($task->end_date_estimation)->lessThan($currentDate);
        })->count();

        try {

            $pv = ($doTasks / Dashboard::allTask()->count() * 100);
        } catch (DivisionByZeroError $e) {

            $pv = 0;
        }

        return $pv;
    }

    public function actualCost()
    {
        try {

            $ac = Track::getAllTrack($this->projectId)->sum('total_per_item');
        } catch (DivisionByZeroError $e) {

            $ac = 0;
        }

        return $ac;
    }

    //Get performance
    public function spi()
    {
        try {

            $spi = $this->ev / $this->pv;
        } catch (DivisionByZeroError $e) {

            $spi = 0;
        }


        return $spi;
    }

    public function actualBudget()
    {
        $actualBudget = Track::getAllTrack($this->projectId)->sum('total_per_item');

        return $actualBudget;
    }

    public function plannedBudget()
    {
        $actualPlan = Plan::getAllPlan($this->projectId)->sum('total_per_item');

        return $actualPlan;
    }

    public function cpi()
    {
        $actualCost = Dashboard::actualCost();


        try {
            $cpi = round(($this->ev / 100) * round($this->project->budget) / $this->ac,2);
            
        } catch (DivisionByZeroError $e) {

            $cpi = 0;
        }


        return round($cpi,2);
    }



    public function mount()
    {
        // dd($this->cpi());
        $this->ev = Dashboard::earnedValue();
        $this->pv = Dashboard::plannedValue();
        $this->ac = Dashboard::actualCost();
        $this->totalTasks = $this->totalTasks();
        



        // DESCRIPTION
        $this->project = Project::getById($this->projectId);

        // HEALTH
        $this->spi = (float)Dashboard::spi();
        if ($this->spi == 1.0) {
            $this->spiMessage = "On Track";
        } else if ($this->spi == 0.0) {
            $this->spiMessage = "NA";
        } else if ($this->spi > 1.0) {
            $this->spiMessage = "Faster";
        } else if ($this->spi < 1.0){
            $this->spiMessage = "Delay";
        } else if ($this->project->status = 'Hold') {
            $this->spiMessage = "Hold";
        }else {
            $this->spiMessage = "NA";
        }
        

        // dd($this->ev, $this->ac, $this->cpi);
        $this->cpi = (float)Dashboard::cpi();
        if ($this->cpi == 1.0) {
            $this->cpiMessage = "On Budget";
        } else if ($this->cpi == 0.0) {
            $this->cpiMessage = "NA";
        } else if ($this->cpi > 1.0) {
            $this->cpiMessage = "Under Budget";
        } else if($this->cpi < 1.0){
            $this->cpiMessage = "Over Budget";
        } else {
            $this->cpiMessage = "NA";
        }
        // dd($this->cpi, $this->ev, $this->ac);

        $this->taskOver = Dashboard::taskDelay();

        // ==============================================================TASKS==============================================================
        $this->tasks = task::getAllProjectTasks($this->projectId)->count();

        /**
         * ID
         * 1 New
         * 2 Assign
         * 3 On Progress
         * 4 Testing
         * 5 Done
         * 6 Production
         * 7 Hold
         * 8 Cancel 
         */
        $this->tasksNotStarted = task::getAllProjectTasks($this->projectId)->where('status_id', 1)->count();

        $this->tasksNotStarted += task::getAllProjectTasks($this->projectId)->where('status_id', 2)->count();

        $this->tasksInProgress = task::getAllProjectTasks($this->projectId)->where('status_id', 3)->count();
        $this->tasksInProgress += task::getAllProjectTasks($this->projectId)->where('status_id', 4)->count();

        $this->tasksDone = task::getAllProjectTasks($this->projectId)->where('status_id', 5)->count();
        $this->tasksDone += task::getAllProjectTasks($this->projectId)->where('status_id', 6)->count();
        // ==============================================================TASKS END==============================================================


        //COST
        $this->budget = $this->project->budget;
        $this->plannedBudget = $this->plannedBudget();
        $this->actualBudget = $this->actualBudget();
        $this->plannedValue = round(($this->pv/100)*$this->budget, 2);
        // dd($this->pv, $this->budget, $this->plannedValue);


        //TIME
        $this->timeAhead = ($this->ev-$this->pv);
        // dd($this->timeAhead);



        // WORKLOAD
        $taskGroup = task::allGroupTasks($this->projectId);
        $taskGroupDone = task::progressDone($this->projectId);

        $this->percentagesProgress = $taskGroup->mapWithKeys(function ($task) use ($taskGroupDone) {
            $total = $task->total;
            $completed = $taskGroupDone->firstWhere('category_id', $task->category_id)->total ?? 0;
            $percentage = round($total > 0 ? ($completed / $total) * 100 : 0, 0);
            return [$task->category_name => $percentage]; // Using category name here
        });

        $this->workload = Task::workloadCompleted($this->projectId)->values()->toArray();


        // dd($this->workload);




    }

    public function render()
    {

        return view('livewire.dashboard.dashboard', [
            'workload' => $this->workload,
        ]);
    }
}
