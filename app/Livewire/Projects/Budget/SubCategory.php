<?php

namespace App\Livewire\Projects\Budget;

use App\Models\Category;
use App\Models\Projects\Budget\Category as BudgetCategory;
use App\Models\Projects\Budget\SubCategory as BudgetSubCategory;
use App\Models\SubCategory as ModelsSubCategory;
use Livewire\Attributes\On;
use Livewire\Component;

class SubCategory extends Component
{
    public $subcategories;
    public $categories;
    public $subcategory;
    public $subCategoryId;
    public $name, $category_id;
    public $projectId;

    public function render()
    {
        return view('livewire.projects.budget.sub-category', ['subcategories' => $this->subcategories]);
    }


    public function mount()
    {
        $this->categories = BudgetCategory::getAllCategory();
        $this->subcategories = BudgetSubCategory::getAllSubCategory();
    }

    // STORE (UPDATE & CREATE)
    public function store()
    {
        $this->validate([
            'category_id' => 'required',
            'name' => 'required|string|max:255',
        ]);

        try {
            if ($this->subCategoryId) {
                BudgetSubCategory::update([
                    'category_id' => $this->category_id,
                    'name' => $this->name
                ], $this->subCategoryId);
                session()->flash('success', 'Sub Category Updated Successfully!');
            } else {
                BudgetSubCategory::create([
                    'category_id' => $this->category_id,
                    'name' => $this->name
                ]);
                session()->flash('success', 'Sub Category Created Successfully!');
            }
            $this->js("alert('Sub Category Saved!')");
            $this->refresh();
        } catch (\Throwable $th) {
            session()->flash('error', 'Error: ' .$th->getMessage());
        }
    }


    // EDIT
    public function edit($id)
    {
        $subcategory = BudgetSubCategory::getSubCategoryById($id);

        if ($subcategory) {
            $this->subCategoryId = $subcategory->id;
            $this->name = $subcategory->name;
        }
        // EVENT HANDLE SHOW FOR EDIT OFFCANVAS
        $this->dispatch('show-edit-offcanvas');
    }


    // DELETE
    public function delete($id)
    {
        BudgetSubCategory::deleteSubCategory($id);
        $this->js("alert('Sub Category Saved!')");
        $this->dispatch('refresh');
    }


    // CLICK HANDLE
    public function btnSubCategory_Clicked()
    {
        $this->dispatch('show-create-offcanvas');
    }

    // DIRECT TO PLAN
    public function plan()
    {
        return $this->redirectRoute('projects.budget.show.plan', ['projectId' => $this->projectId]);
    }
    // DRICET TO TRACK
    public function track()
    {
        return $this->redirectRoute('projects.budget.show.track', ['projectId' => $this->projectId]);
    }

    #[On('refresh')]
    public function refresh() {
        $this->subcategories = BudgetSubCategory::getAllSubCategory();
    }
}
