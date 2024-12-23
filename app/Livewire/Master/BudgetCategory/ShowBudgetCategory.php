<?php

namespace App\Livewire\Master\BudgetCategory;

use Livewire\Component;
use App\Models\Projects\Budget\Category;
use Livewire\Attributes\On;

class ShowBudgetCategory extends Component
{
    public $name, $categoryId;
    public $categories;
    
    public function render()
    {
        $this->categories = Category::getAllCategory();
        return view('livewire.master.budget-category.show-budget-category', [
            'categories' => $this->categories
        ]);
    }

    public function save(){
        // dd('masuk save');
        if ($this->categoryId) {
            Category::Update($this->all(), $this->categoryId);
        } else {
            Category::Create($this->all());
        }
        $this->reset();
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.'
        ]);
    }

    #[On('edit')]
    public function edit($id) {
        $this->dispatch('show-offcanvas-project');
        $var = Category::getCategoryById($id);
        $this->categoryId = $var->id;
        $this->name = $var->name;
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
        Category::delete($id);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.'
        ]);
    }
}
