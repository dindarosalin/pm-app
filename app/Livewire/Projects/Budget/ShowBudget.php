<?php

namespace App\Livewire\Projects\Budget;

use App\Livewire\Projects\Budget\Plan\ShowPlan;
use App\Livewire\Projects\Budget\Track\ShowTrack;
use App\Livewire\Projects\Projects\ShowProject;
use App\Models\Budget;
use App\Models\Projects\Project;
use App\Models\Projects\Budget\Plan\Plan as PlanPlan;
use App\Models\Projects\Budget\Track\Track as TrackTrack;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;


class ShowBudget extends Component
{
    // PROPS
    public $projectId;
    public $project;
    public $percentInitial = 0;
    public $percentFixed = 0;
    public $percentBudget = 0;
    public $budget;
    public $totalPlan;
    public $expense;
    public $projectData;
    public $getProject;
    public $title;

    // public $totalAllPlan;
    // public $total_all;

    public function render()
    {
        return view('livewire.projects.budget.show-budget', [
            // 'totalPlan' => $this->getTotalPlan(),
            'percentInitial' => $this->percentInitial,
            'percentFixed' => $this->percentFixed,
            'percentBudget' => $this->percentBudget,
            // 'total_all' => $this->total_all,
            // 'chart' => $this->chart,
        ]);
    }

    public function mount()
    {
        $this->projectId;
        $this->project = Project::getById($this->projectId);
        // $this->expense = TrackTrack::getAllTrack($this->projectId)->sum('total_per_item');
        $this->expense = TrackTrack::getTotalExpense($this->projectId);
        // dd($this->expense);
        // $this->totalPlan = PlanPlan::getAllPlan($this->projectId)->sum('total_per_item');
        $this->totalPlan = PlanPlan::getTotalPlan($this->projectId);
        // $this->initialBudget($this->budget, $this->totalPlan);
        $this->fixedBudget($this->budget, $this->expense);
        $this->projectBudget($this->budget);
        $this->projectData = Project::getForBudget();

        // $this->totalAllPlan = PlanPlan::getAllPlan($this->projectId);
        // $planAll = $this->totalAllPlan->total;
        // dd($this->totalAllPlan, $planAll);
    }


    public function plan($projectId)
    {
        $title = Project::getTitle($projectId);
       return redirect()->route('budget.show.plan', ['title' => $title]);
    }


    public function track($projectId)
    {
        $title = Project::getTitle($projectId);
        return redirect()->route('budget.show.track', ['title' => $title]);
        // return redirect()->route('budget.show.track', ['projectId' => $projectId]);
    }
    
    public function updateDisplay()
    {
        $this->dispatch('resetDisplay');
        $this->dispatch('planUpdated');
    }

   

    // BUDGET PERCENT
    public function initialBudget($budget, $totalPlan)
    {
        if ($totalPlan > 0) {
            $this->percentInitial = ($totalPlan / $budget ) * 100;
        } else {
            $this->percentInitial = 0;
        }
    }

    // EXPENSE PERCENT
    public function fixedBudget($budget, $expense)
    {
        if ($expense > 0) {
            $this->percentFixed = ($expense / $budget ) * 100;
        } else {
            $this->percentFixed = 0;
        }
    }

    // PROJECT PERCENT
    public function projectBudget($budget)
    {
        if ($budget > 0) {
            $this->percentBudget = ($this->project->budget / $budget) * 100;
        }
    }

    // protected $listeners = ['planTotal' => 'totalPlan'];
    // public function totalPlan($total)
    // {
    //     $this->total_all = $total;
    // }
   
}


// use ArielMejiaDev\LarapexCharts\LarapexChart;
  // PROPS FOR CHART
    //  public $chartData = []; // Gunakan array atau struktur data sederhana
    //  public $chart = []; // Simpan data chart sebagai array

// KODE ASLI
    // public function mount()
    // {
    //     $this->projectId;
    //     $this->project = Project::getById($this->projectId);
    //     // $this->totalPlan = ShowBudget::getTotalPlan();
    //     $this->expense = TrackTrack::getAllTrack($this->projectId)->sum('total_per_item');//hitung otomatis saat filter
    //     $this->totalPlan = PlanPlan::getAllPlan($this->projectId)->sum('total_per_item');
    //     $this->initialBudget($this->project->budget, $this->totalPlan);
    //     $this->fixedBudget($this->project->budget, $this->expense);
    //     $this->projectBudget($this->project->budget);
    //     // $this->chart = $this->generateChart(); // Simpan data chart ke dalam array
    // }

    // DIRECT BUTTON
    // public function plan()
    // {
    //     return $this->redirectRoute('projects.budget.show.plan', ['projectId'=>$this->projectId]);
    //     $this->updateDisplay($projectId);
        
    // }

    // DIRECT BUTTON
    // public function track()
    // {
    //     return $this->redirectRoute('projects.budget.show.track', ['projectId'=>$this->projectId]);
    // }

     // GET TOTAL BUDGET PLAN
    // public function getTotalPlan()
    // {
    //     $totalPlan = new ShowPlan(); //ambil dari kelas showPlan (component showPlan)
    //     return $totalPlan->totalPrice($this->projectId);
    // }

     // CHART
    // public function generateChart()
    // {
    //     return (new LarapexChart)->horizontalBarChart()
    //     ->setTitle('Los Angeles vs Miami.')
    //     ->setSubtitle('Wins during season 2021.')
    //     ->setColors(['#FFC107', '#D32F2F'])
    //     ->addData('San Francisco', [6, 9, 3, 4, 10, 8])
    //     ->addData('Boston', [7, 3, 8, 2, 6, 4])
    //     ->setXAxis(['January', 'February', 'March', 'April', 'May', 'June']);
        
    // }

     // GET ID PROJECT FOR BUDGET
    //  #[On('project')]
    //  public function getProjectId($id_project)
    //  {
    //     dd($id_project);
            //  try {
            //      $this->getProject = PlanPlan::getPlanByIdProject($id_project);
            //  } catch (\Throwable $th) {
            //      throw $th;
            //  }
    //  }


