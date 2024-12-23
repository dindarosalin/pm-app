<?php

namespace App\Livewire\Budget\Plan;

use App\Models\Category;
use App\Models\Plan as ModelsPlan;
use App\Models\SubCategory;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Http\Request;


class Plan extends Component
{
// INISIALISASI
    public $plans;
    public $categoryId, $sub_category_id, $name, $uom, $quantity = 0, $unit_price = 0, $total_per_item = 0, $total_all = 0; 
    public $planId;
    public $categories;
    public $sub_category = [];
    public $totalByCategory = [];
    



// RENDER
    public function render()
    {
        return view('livewire.budget.plan.plan', [
            // for count
            'plans' => $this->plans,
            'totalByCategory' => $this->totalByCategory,
            'total_all' => $this->total_all
        ]);

        // for count
        $plans = DB::table('plans')
        ->join('categories', 'plans.category_id', '=', 'categories.id')
        ->select(
                'categories.name as category_name',
                'plans.quantity',
                'plans.unit_price',
                'plans.total_per_item'
                )
        ->get();
    }

// MOUNT
    public function mount() 
    {
        $this->plans = ModelsPlan::getAllPlan();
        $this->categories = Category::getAllCategory();

        // for count
        $this->loadBudgets();
    }

// STORE
    public function store() 
    {
        try {
            if ($this->planId) {
                ModelsPlan::update($this->all(), $this->planId);
            } else {
                ModelsPlan::create($this->all());
            }
            $this->js("alert('Budget Plan Saved')");
            $this->refresh();
        } catch (\Throwable $th) {
            throw $th;
        }

        
    }

// EDIT
    public function editBudgetPLan($id)
    {
        $plan = ModelsPlan::getPlanById($id);
        if ($plan) {
            $this->planId = $plan->id;
            $this->categoryId = $plan->category_id;
            $this->sub_category_id = $plan->sub_category_id;
            $this->name = $plan->name;
            $this->uom = $plan->uom;
            $this->quantity = $plan->quantity;
            $this->unit_price = $plan->unit_price;
            $this->total_per_item = $plan->total_per_item;
            $this->total_all = $plan->total_all;
        }
        // event for show edit canvas
        $this->dispatch('show-edit-offcanvas');
    }
    

    // $budgetPlan = ModelsPlan::getBudgetPlanById($id);
    //         // $budgetPlan = DB::table('plans')->find($id);
    //         if ($budgetPlan) {
    //             $this->planId = $budgetPlan->id;
    //             $this->category_id = $budgetPlan->category_id;
    //             $this->sub_category_id = $budgetPlan->sub_category_id;
    //             $this->name = $budgetPlan->name;
    //             $this->uom = $budgetPlan->uom;
    //             $this->quantity = $budgetPlan->quantity;
    //             $this->unit_price = $budgetPlan->unit_price;
    //             $this->total_per_item = $budgetPlan->total_per_item;
    //             $this->total_all = $budgetPlan->total_all;
    //         }
    
    //         // EVENT FOR SHOW EDIT OFFCANVAS
    //         $this->dispatch('show-edit-offcanvas');
    //     }


// DELETE
    public function delete ($id)
    {
        // call function delete from model
        ModelsPlan::delete($id);
        // load data Budgets after deleting
        $this->loadBudgets();
        // refresh data plans after store
        $this->plans = ModelsPlan::getAllPlan();
    }

// REFRESH
#[On('refresh')]
public function refresh() {}

// CREATE
    public function show_create_offcanvas() 
    {
        $this->dispatch('show-offcanvas');
    }

// UPDATE
    public function updatedCategoryId() 
    {
        $this->sub_category = SubCategory::getSubCategoryByCategory($this->categoryId);
    }

// FOR COUNT
    public function updateCategoryId()
    {
        $this->sub_category = SubCategory::getSubCategoryByCategory($this->categoryId);
    }

    // method "updated" for automatically counting
    public function updated($propertyName)
    {
        if ($propertyName === 'quantity' || $propertyName === 'unit_price') {
            // count totalPerItem when quantity or unit price changes
            $this->total_per_item = $this->quantity * $this->unit_price;
        }
        // after count the totalPerItem, loop count total_all
        $this->loadBudgets();
    }

    // count total_all
    public function loadBudgets()
    {

        // get total price per category
        $this->totalByCategory = DB::table('plans')
        ->join('categories', 'plans.category_id', '=', 'categories.id')
        ->select(
                'categories.id as category_id',
                'categories.name as category_name',
                DB::raw("SUM(plans.total_per_item) as total_item")
            )
        ->groupBy('categories.id', 'categories.name')
        ->get()
        ->keyBy('category_id');

        // count total all

        $this->total_all = (DB::table('plans')->sum('total_per_item', 0));
    }


}
// // LOAD
//     #[On('refresh')]
//     public function refresh() 
//     {
//         $this->plans = ModelsPlan::getAllBudgetPlan();
//     }

// // RENDER
//     public function render()
//     {
//         return view('livewire.budget.plan.plan');
//     }

// // MOUNT
//     public function mount()
//     {

//         // // load initial data for categories
//         $this->categories = Category::getAllCategory();
//         $this->plans = ModelsPlan::getAllBudgetPlan();
//         // dd($this->plans);

//     }  
    
// // EDIT
//     public function editBudgetPLan($id)
//     {
//         $budgetPlan = ModelsPlan::getBudgetPlanById($id);
//         // $budgetPlan = DB::table('plans')->find($id);
//         if ($budgetPlan) {
//             $this->planId = $budgetPlan->id;
//             $this->category_id = $budgetPlan->category_id;
//             $this->sub_category_id = $budgetPlan->sub_category_id;
//             $this->name = $budgetPlan->name;
//             $this->uom = $budgetPlan->uom;
//             $this->quantity = $budgetPlan->quantity;
//             $this->unit_price = $budgetPlan->unit_price;
//             $this->total_per_item = $budgetPlan->total_per_item;
//             $this->total_all = $budgetPlan->total_all;
//         }

//         // EVENT FOR SHOW EDIT OFFCANVAS
//         $this->dispatch('show-edit-offcanvas');
//     }


// // STORE
//     public function store()
//     {
//         dd($this->category_id, $this->sub_category_id, $this->name, $this->uom, $this->quantity, $this->unit_price, $this->total_per_item, $this->total_all);
//         // input validation
//         $this->validate([
//             'category_id' => 'required|exists:categories,id',
//             'sub_category_id' => 'required|exists:sub_categories,id',
//             'name' => 'required|string|max:255',
//             'uom' => 'required|string|max:255',
//             'quantity' => 'required|numeric|min:1',
//             'unit_price' => 'required|numeric|min:0',
//             'total_per_item' => 'required|numeric|min:0',
//             'total_all' => 'required|numeric|min:0',
//         ]);

//         // logic for store and updating
//         try {
//             if ($this->planId) {
//                 ModelsPlan::updateBudgetPlan($this->all(), $this->planId);
//                 // Jika planId ada, update data yang sudah ada
//                 // DB::table('plans')->where('id', $this->planId)->update([
//                 //     'category_id' => $this->category_id,
//                 //     'sub_category_id' => $this->sub_category_id,
//                 //     'name' => $this->name,
//                 //     'uom' => $this->uom,
//                 //     'quantity' => $this->quantity,
//                 //     'unit_price' => $this->unit_price,
//                 //     'total_per_item' => $this->total_per_item,
//                 //     'total_all' => $this->total_all,
//                 //     'updated_at' => now(),
//                 // ]);
//                 session()->flash('success', ' Budget Plan Updated Successfully!');
//             } else {
//                 // Jika planId tidak ada, buat entri baru
//                 ModelsPlan::createBudgetPlan($this->all());

//                 //  DB::table('plans')->insert([
//                 //     'category_id' => $this->category_id,
//                 //     'sub_category_id' => $this->sub_category_id,
//                 //     'name' => $this->name,
//                 //     'uom' => $this->uom,
//                 //     'quantity' => $this->quantity,
//                 //     'unit_price' => $this->unit_price,
//                 //     'total_per_item' => $this->total_per_item,
//                 //     'total_all' => $this->total_all,
//                 //     'created_at' => now(),
//                 //     'updated_at' => now(),
//                 // ]);
//                 session()->flash('success', 'Budget Plan Created Successfully!');
//             }
//             // reset form fields cegah binding
//             $this->reset();
//             $this->js("alert('Budget plan Saved!')");
//             // $this->refresh();
//         } catch (\Throwable $th) {
//             session()->flash('error', 'Error: ' .$th->getMessage());
//         }
//     }

// // GET BUDGET PLAN BY ID
//     public function getBudgetPlanById($id)
//     {
//         try {
//             $this->planShow = ModelsPlan::getBudgetPlanById($id);
//             $this->dispatch('show-view-offcanvas');
//         } catch (\Throwable $th) {
//             throw $th;
//         }
//     }

// // DELETE
// public function delete($id)
// {
//     ModelsPlan::deleteBudgetPlan($id);
//     $this->reset(); //reset form field after deletion
//      $this->js("alert('Budget Plan Deleted!')");
//      $this->dispatch('refresh');
// }

// // SHOE OFFCANVAS WHEN CREATE
//     public function btnCreatePlan_Clicked()
//     {
//         $this->reset();
//         $this->dispatch('show-create-offcanvas');
//     }


// // FOR SELECTED

// // SELECT CATEGORY
//     public function updatedSelectedCategory($categoryId)
//     {
       
//         $this->subcategories = ModelsPlan::getSubCategories($categoryId);
//         // $this->subcategories = SubCategory::getSubCategoryByCategory($this->selectedCategory);
//         // $this->selectedSubCategory = null; //reset subcategory
//     }

// }


// KODE INI SUDAH BISA DIJALANKAN NAMUN BELUM SEMPURNA UNTUK COUNT DAN DATA BELUM TERSIMPAN DENGAN BENAR DI DATABASE
// {
//     //INISIALISASI
//     public $planId;
//     public $category_id, $sub_category_id, $name, $uom, $quantity, $unit_price, $total_per_item, $total_all;
//     public $plans;
//     public $planShow;
//     public $categories = [];
//     public $subcategories = []; 

//     public $selectedCategory = null;
//     public $selectedSubCategory = null;

//     // LOAD OTOMATIS
//     #[On('refresh')]
//     public function refresh() 
//     {
//         $this->plans = $this->getAllBudget();
//     }

//     // RENDER AND VIEW
//     public function render()
//     {
//         return view('livewire.budget.plan.plan', [
//             'plans' => $this->plans
//         ]);

//     }

//     // MOUNT
//     public function mount()
//     {
//         $this->plans = ModelsPlan::getAllBudgetPlan();
//         // for selected
//         $this->categories = DB::table('categories')->pluck('name', 'id');
//     }


// // KODE AWAL YANG BISA JALAN
//     // EVENT LISTENER FOR CHANGE CATEGORY
//     public function updateCategoryId($categoryId)
//     {
//         if ($categoryId) {
//             // get sub category based on category when choose
//             $this->subcategories = DB::table('sub_categories')
//             ->where('category_id', $categoryId)
//             ->pluck('name', 'id');
//             $this->selectedSubCategory = null; //reset pilihan sub kategori
//         } else {
//             $this->subcategories = [];
//         }
//     }

//     // EDIT
//     public function editBudgetPLan($id)
//     {
//         $budgetPlan = DB::table('plans')->where('id', $id)->first();
//         if ($budgetPlan) {
//             $this->planId = $budgetPlan->id;
//             $this->category_id = $budgetPlan->category_id;
//             $this->sub_category_id = $budgetPlan->sub_category_id;
//             $this->name = $budgetPlan->name;
//             $this->uom = $budgetPlan->uom;
//             $this->quantity = $budgetPlan->quantity;
//             $this->unit_price = $budgetPlan->unit_price;
//             $this->total_per_item = $budgetPlan->total_per_item;
//             $this->total_all = $budgetPlan->total_all;
//         }
//         // EVENT FOR SHOW OFF CANVAS
//         $this->dispatch('show-edit-offcanvas');
//     }

//      // STORE
//      public function store()
//      {
//          $this->validate([
//              'category_id' => 'required|exists:categories,id',
//              'sub_category_id' => 'required|exists:sub_categories,id',
//              'name' => 'required|string|max:255',
//              'uom' => 'required|string|max:255',
//              'quantity' => 'required|integer|min:1',
//              'unit_price' => 'required|numeric|min:0',
//              'total_per_item' => 'required|numeric|min:0',
//              'total_all' => 'required|numeric|min:0',
//          ]);
 
//         //  logic 
//          try {
//              if ($this->planId) {
//                  DB::table('plans')
//                  ->where('id', $this->planId)
//                  ->update([
//                      'name' => $this->name,
//                      'category_id' => $this->category_id,
//                      'sub_category_id' => $this->sub_category_id,
//                      'uom' => $this->uom,
//                      'quantity' => $this->quantity,
//                      'unit_price' => $this->unit_price,
//                      'total_per_item' => $this->total_per_item,
//                      'total_all' => $this->total_all,
//                      'updated_at' => now(),
//                  ]);
//                  session()->flash('success', 'Budget Plan Updated Successfully!');
//              } else {
//                  DB::table('plans')->insert([
//                      'name' => $this->name,
//                      'category_id' => $this->category_id,
//                      'sub_category_id' => $this->sub_category_id,
//                      'uom' => $this->uom,
//                      'quantity' => $this->quantity,
//                      'unit_price' => $this->unit_price,
//                      'total_per_item' => $this->total_per_item,
//                      'total_all' => $this->total_all,
//                      'created_at' => now(),
//                      'updated_at' => now(),
//                  ]);
//                  session()->flash('success', 'Budget Plan Created Successfully!');
//              }
 
//              $this->js("alert('Budget Plan Saved!')");
//              $this->refresh();
//          } catch (\Throwable $th) {
//              session()->flash('error', 'Error: ' . $th->getMessage());
//          }
//      }

//     // GET BUDGET PLAN BY ID
//     public function getBudgetPlanById($id)
//     {
//         try {
//             $this->planShow = DB::table('plans')
//             ->join('categories', 'plans.category_id', '=', 'categories.id')
//             ->join('sub_categories', 'plans.sub_category_id', '=', 'sub_categories.id')
//             ->where('plans.id', $id)
//             ->select('plans.*',
//                         'categories.name as category_name',
//                         'sub_categories.name as sub_category_name')
//             ->first();

//             $this->dispatch('show-view-offcanvas');
//         } catch (\Throwable $th) {
//             throw $th;
//         }
//     }

//     // EVENT LISTENER FOR COUNT TOTAL_PER_ITEM
//     public function Quantity()
//     {
//         $this->countTotalPerItem();
//     }
//     public function unitPrice()
//     {
//         $this->countTotalPerItem();
//     }
//     public function countTotalPerItem()
//     {
//         if ($this->quantity && $this->unit_price) {
//             $this->total_per_item = $this->quantity * $this->unit_price;
//         } else {
//             $this->total_per_item = 0;
//         }
//         $this->countTotalAll();
//     }

//     // COUNT TOTALALL
//     public function countTotalAll()
//     {
//         $this->total_all = $this->plans->sum('total_per_item');
//     }                                

    

//     // DELETE
//     public function deleteBudgetPlan($id) 
//     {
//         DB::table('plans')->where('id', $id)->delete();
//         $this->js("alert('Budget Plan Deleted!')");
//         $this->dispatch('refresh');

//     }

//     // SHOW OFF CANVAS WHEN CREATE
//     public function btnCreatePlan_Clicked()
//     {
//         $this->dispatch('show-create-offcanvas');
//     }

//     // FOR SELECTED CATEGORY CHANGE EVENT (for dropdown)
//     public  function categoryChanged()
//     {
//     //    get all category from table categories
//     return DB::table('categories')->pluck('name', 'id');
//     }
//     public function SubCategoryChanged()
//     {
//         // get sub category based on id Kategori
//        return DB::table('sub_categories')
//        ->where('category_id', $this->category_id)
//        ->pluck('name','id');
//     }
// }
