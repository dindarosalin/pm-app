<?php

namespace App\Livewire\Master\BudgetCategory;

use Livewire\Component;
use App\Models\Projects\Budget\Category;
use App\Models\Projects\Budget\SubCategory;
use Livewire\Attributes\On;

class ShowBudgetSubCategory extends Component
{
    public $subcategories;
    public $categories;
    public $subcategory;
    public $subCategoryId;
    public $name, $category_id;

    public function render()
    {
        $this->categories = Category::getAllCategory();
        $this->subcategories = SubCategory::getAllSubCategory();

        return view('livewire.master.budget-category.show-budget-sub-category',[
            'subcategories' => $this->subcategories
        ]);
    }

    public function store()
    {
        // $this->validate([
        //     'category_id' => 'required',
        //     'name' => 'required|string|max:255',
        // ]);

        //     if ($this->subCategoryId) {
        //         SubCategory::update([
        //             'category_id' => $this->category_id,
        //             'name' => $this->name
        //         ], $this->subCategoryId);
        //     } else {
        //         SubCategory::create([
        //             'category_id' => $this->category_id,
        //             'name' => $this->name
        //         ]);
        //     }
        //     $this->js("alert('Sub Category Saved!')");

        if ($this->subCategoryId) {
            SubCategory::Update($this->all(), $this->subCategoryId);
        } else {
            SubCategory::Create($this->all());
        }

        $this->reset();
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.'
        ]);

    }

    #[On('edit')]
    public function edit($id)
    {
        $subcategory = SubCategory::getSubCategoryById($id);

        $this->subCategoryId = $subcategory->id;
        $this->name = $subcategory->name;
        $this->category_id = $subcategory->category_id;

        $this->dispatch('show-offcanvas-project');
    }

    public function alertConfirm($id)
    {
        $this->dispatch('swal:confirm', [
            'type' => 'warning',
            'message' => 'Are you sure?',
            'text' => 'You won\'t be able to revert this!',
            'id' => $id,
            'dispatch' => 'delete'
        ]);
    }

    #[On('delete')]
    public function delete($id)
    {
        SubCategory::deleteSubCategory($id);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.'
        ]);    }
}
