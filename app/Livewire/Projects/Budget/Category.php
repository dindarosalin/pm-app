<?php

namespace App\Livewire\Projects\Budget;

use App\Models\Category as ModelsCategory;
use App\Models\Projects\Budget\Category as BudgetCategory;
use Livewire\Attributes\On;
use Livewire\Component;

class Category extends Component
{
    public $categories;
    public $categoryId;
    public $name;
    public $category;
    public $projectId;



    #[On('refresh')]
    public function refresh() {
        // load automatic for data Category
        $this->categories = BudgetCategory::getAllCategory();
    }


    public function render()
    {
        // send all data in table category for show on the view blade
        return view('livewire.projects.budget.category', ['categories' => $this->categories]);
    }


    public function mount()
    {
        // call the function in model to forward on render
        $this->categories = BudgetCategory::getAllCategory();
    }


    // STORE (UPDATE & CREATE)
    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            if ($this->categoryId) {
                BudgetCategory::update(['name' => $this->name], $this->categoryId);
                session()->flash('success', 'Category Updated Successfully!');
            } else {
                BudgetCategory::create(['name' => $this->name]);
                session()->flash('success', 'Category Created Successfully!');
            } 
            $this->js("alert('Category Saved')");
            // load data after save
            $this->refresh();
        } catch (\Throwable $th) {
            session()->flash('error', 'Error: ' .$th->getMessage());
        }
    }


    // EDIT
    public function edit($id)
    {
        // find Category based on ID
        $category = BudgetCategory::getCategoryById($id);

        if ($category) {
            $this->categoryId = $category->id;
            $this->name = $category->name;
        }
        // event to handle show the edit offcanvas
        $this->dispatch('show-edit-offcanvas'); 
    }


    // DELETE
    public function delete($id)
    {
        BudgetCategory::delete($id);
        $this->js("alert('Category Deleted!')");
        $this->dispatch('refresh');
    }


    // SHOW CREATE OFF CANVAS
    public function btnCategory_Clicked()
    {
        $this->dispatch('show-create-offcanvas');
    }


    // DIRECT TO PLAN
    public function plan()
    {
        return $this->redirectRoute('projects.budget.show.plan', ['projectId' => $this->projectId]);
    }

    // DIRECT TO TRACK
    public function track()
    {
        return $this->redirectRoute('projects.budget.show.track', ['projectId' => $this->projectId]);
    }
}
