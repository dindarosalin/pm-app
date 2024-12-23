<?php

namespace App\Livewire\Master\TaskCategory;

use Livewire\Component;
use App\Models\Projects\Master\TaskCategory;
use Livewire\Attributes\On;

class ShowTaskCategory extends Component
{
    public $taskCategories;
    public $taskCategoryId;
    public $categoryName, $categoryCode;

    public function render()
    {
        $this->taskCategories = TaskCategory::getAll();

        return view('livewire.master.task-category.show-task-category');
    }

    public function save(){
        // dd('masuk save');
        if ($this->taskCategoryId) {
            TaskCategory::Update($this->all(), $this->taskCategoryId);
        } else {
            TaskCategory::Create($this->all());
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
        $this->dispatch('show-offcanvas-category');
        $var = TaskCategory::getById($id);

        $this->taskCategoryId = $var->id;
        $this->categoryName = $var->category_name;
        $this->categoryCode = $var->category_code;
    }

    public function alertConfirm($id)
    {
        $this->dispatch('swal:confirm', [
            'type' => 'warning',
            'message' => 'Are you sure?',
            'text' => 'You won\'t be able to revert this!',
            'id' => $id,
            'dispatch' => 'delete-task-category'
        ]);
    }

    #[On('delete-task-category')]
    public function delete($id)
    {
        TaskCategory::delete($id);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.'
        ]);
    }
}
