<?php

namespace App\Livewire\Projects\Budget\Plan;

use App\Models\Plan;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Projects\Project;
use App\Models\Category;
use App\Models\Projects\Budget\Category as BudgetCategory;
use App\Models\Projects\Budget\Plan\Plan as PlanPlan;

class ShowPlan extends Component
{
    public $plans;
    public $planId;
    public $projectId;
    public  $category_id, 
            $name, 
            $quantity = 1, 
            $unit_price = 0, 
            $total_per_item = 0;
    public $totalByCategory;
    public $selectCategory, $selectSubCategory, $uom;
    public $total_all;
    public $exportPlan;

    // filter
    public $search;
    public $filters = [];
    public $fromToDate;
    public $timeFrame = [];
    public $fromDate = [];
    public $toDate = [];

    public $id;
    public $title;
    public $plan;

    public $totalPlan;
    


   
    
    


    public function render()
    {
        // dd($this->projectId);
        // $this->projectId = $projectId;

        $this->loadPlan();

        // filter
        $category = BudgetCategory::getAllCategory();
        $this->plans = $this->filter($this->plans);

        // hitung otomatis saat filter
        $this->total_all = $this->plans->sum('total_per_item');
        // $this->dispatch('planTotal', $this->total_all);
        
        return view('livewire.projects.budget.plan.show-plan', [
            'plans' => $this->plans,
            'categories' => $category,
            // 'projectId' => $this->projectId
        ]);
    }

    public function mount($title)
    {
        // $this->planId;
        // $this->projectId;
        // $this->plans = PlanPlan::getAllPlan($this->projectId);

        $projects = Project::getTitleProject($title);

        if ($projects) {
            $this->projectId = $projects->id;
            $this->loadPlan();
        } else {
             // Tangani jika proyek tidak ditemukan
             session()->flash('error', 'Project not found.');
             return redirect()->route('budget.show.budget'); // Redirect jika tidak ditemukan
        }

        // $plan = PlanPlan::getPlansByTitle($this->title);
    }

// ==================================================DELETE====================================================================================
    // DELETE
    public function delete($id)
    {
        // call method delete from model
        PlanPlan::delete($id);
        $this->js("alert('Budget Plan Deleted!')");
    }

// ==================================================HANDLE OFF CANVAS====================================================================================
    // OFF CANVAS CREATE
    public function btnPlan_Clicked()
    {
        $this->dispatch('show-create-offcanvas');
    }

// ==================================================LOAD OTOMATICALLY====================================================================================
    // LOAD OTOMATIS
    #[On('planUpdated')]
    public function loadPlan()
    {
        // dd($this->projectId);
        $this->plans = PlanPlan::getAllPlan($this->projectId);
        // dd($this->plans);
    }
    
// ==================================================DOWNLOAD WITH DOMPDF====================================================================================
     // DOWNLOAD
    public function generatePdf()
    {
        $data = [
            'exportPlan' => $this->exportPlan,
            'projectName' => Project::getById($this->projectId)->title,
            'plans' => $this->plans,
            'total_all' => $this->total_all
        ];

        // $pdf = Pdf::loadView('livewire.projects.budget.plan.show-plan', $data);
        $pdf = Pdf::loadView('pdf.budget-plan-pdf', $data);

        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->stream();
        }, 'BudgetPlan.pdf');
    }

// ==================================================FILTER====================================================================================
// FILTER
    //FILTER PLAN
    public function filter($plans)
    {
        // search
        if ($this->search) {
            $plans = PlanPlan::scopeSearch($plans, $this->search);
        }

        // filter kolom
        // dd($this->filters);
        if ($this->filters) {
            foreach ($this->filters as $column => $value) {
                if (!empty($value)) {
                    $plans = PlanPlan::scopeFilter($plans, $column, $value);
                }
            }
        }

        // filter time frame dan date range
        if ($this->timeFrame) {
            foreach ($this->timeFrame as $column => $this->fromToDate) {
                if ($this->fromToDate === 'custom-created') {
                    $plans = PlanPlan::scopeFilterByDateRange($plans, $this->fromDate, $this->toDate, $column);
                } else {
                    $plans = PlanPlan::scopeFilterByTimeFrame($plans, $column, $this->fromToDate);
                }
            }
        }
        return $plans;
    }

   

    
    // // RESET FILTER
    public function resetFilter()
    {
       $this->reset(['filters', 'search', 'timeFrame']);
    }

}
  
