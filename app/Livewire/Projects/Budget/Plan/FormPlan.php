<?php

namespace App\Livewire\Projects\Budget\Plan;

use App\Models\Category;
use App\Models\Plan;
use App\Models\Projects\Budget\Category as BudgetCategory;
use App\Models\Projects\Budget\Plan\Plan as PlanPlan;
use App\Models\Projects\Budget\SubCategory as BudgetSubCategory;
use App\Models\Projects\Project;
use App\Models\SubCategory;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Throwable;

class FormPlan extends Component
{
    // PROPS FORM
    public $categoryId, $sub_category_id, $name, $uom, $quantity = 1, $unit_price = 0;
    public $total_per_item;
    public $selectCategory;
    public $selectSubCategory;
    public $planId;
    public $projectId;
    public $sub_categories = [];
    public $categories;
    public $plans;
    public $title;
   
    
   
    



    public function render()
    {
        // ambil berulang all data category agar tidak hilang ketika reset
        $this->categories = BudgetCategory::getAllCategory();

        // $this->total_all = $this->totalAll($this->total_per_item);
        return view('livewire.projects.budget.plan.form-plan'
            // 'total_all' => $this->total_all,
        );
    }


    // public function mount()
    // // public function mount($projectId)
    // {
    //     // $this->projectId = $projectId;
    //     $this->projectId = request()->route('projectId'); //get projectId dari route
    //     $this->plans = PlanPlan::getAllPlan($this->projectId);
    //     //// dd($this->plans);
      
    // }

    public function mount($title)
    {
        // get projectId based on title
        $project = Project::getTitleProject($title);

        if ($project){
            $this->projectId = $project->id;
            $this->plans = PlanPlan::getAllPlan($this->projectId);
        } else {
            // Tangani jika proyek tidak ditemukan
            session()->flash('error', 'Project not found.');
            return redirect()->route('budget.show.budget'); // Redirect jika tidak ditemukan
        }
    }


    // FORM
    // CREATE & UPDATE (STORE)
        public function store()
        {
            $this->validate([
                'selectCategory' => 'required',
                'selectSubCategory' => 'required',
                'name' => 'required|string|max:255',
                'uom' => 'required|string|max:50',
                'quantity' => 'required|min:1',
                'unit_price' => 'required|min:0',
            ]);

            // penanganan eror dan berhsilnya data ketika create dan update
            try {
                if ($this->planId) {
                    // hitung total per item
                    $this->total_per_item = $this->totalItem($this->quantity, $this->unit_price);
                    // cek data kebutuhan update
                    PlanPlan::update([
                        'name' => $this->name,
                        'selectCategory' => $this->selectCategory,
                        'selectSubCategory' => $this->selectSubCategory,
                        'uom' => $this->uom,
                        'quantity' => $this->quantity,
                        'unit_price' => $this->unit_price,
                        'total_per_item' => $this->total_per_item,
                        'projectId' => $this->projectId,
                    ], $this->planId);
                    $this->dispatch('swal:modal', [
                        'type' => 'success',
                        'message' => 'Data Saved',
                        'text' => 'It will list on the table soon.'
                    ]);
                } else {
                    $this->total_per_item = $this->totalItem($this->quantity, $this->unit_price);
                    PlanPlan::create([
                        'name' => $this->name,
                        'selectCategory' => $this->selectCategory,
                        'selectSubCategory' => $this->selectSubCategory,
                        'uom' => $this->uom,
                        'quantity' => $this->quantity,
                        'unit_price' => $this->unit_price,
                        'total_per_item' => $this->total_per_item,
                        'projectId' => $this->projectId,
                    ]); 
                    $this->dispatch('swal:modal', [
                        'type' => 'success',
                        'message' => 'Data Saved',
                        'text' => 'It will list on the table soon.'
                    ]);
                }
                $this->dispatch('close-offcanvas'); //offcanvas tutup otomatis
                $this->dispatch('planUpdated'); //load otomatis 
                $this->resetForm(); //reset otomatis
            } catch (\Throwable $th) {
                $this->js("alert('Budget Plan Fail!')");
            }
            // dd($this->all());
        }



    // EDIT
    #[On('edit')] //get data for dispatch
    public function edit($id)
    {
        // get data for form edit
        $plan = PlanPlan::getPlanById($id);
       
            $this->planId = $plan->id;
            $this->selectCategory = $plan->category_id;
            $this->selectSubCategory = $plan->sub_category_id;
            $this->name = $plan->name;
            $this->uom = $plan->uom;
            $this->quantity = $plan->quantity;
            $this->unit_price = $plan->unit_price;

            $this->dispatch('show-edit-offcanvas'); //event to show edit offcanvas
        
    }
    
     // COUNT TOTAL PER ITEM 
    public function totalItem($qty, $price)
    {
        return $this->total_per_item = $qty * $price;
    }

    

    // DEPENDENT DROPDOWN
    public function loadSubCategory()
    {
        // dd($this->all());
        if ($this->selectCategory) {
            $this->sub_categories = BudgetSubCategory::getSubCategoryByCategory($this->selectCategory);
        }
    }


    // HANDLE CLOSE OFF CANVAS
    public function btnClose_Offcanvas()
    {
        $this->resetForm();
        $this->dispatch('close_offcanvas');
    }
   
   
    public function resetForm()
    {
        $this->selectCategory = '';
        $this->selectSubCategory = '';
        $this->name = '';
        $this->uom = '';
        $this->quantity = '';
        $this->unit_price = '';
        $this->planId = '';
    }

}








