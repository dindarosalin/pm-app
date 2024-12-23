<?php

namespace App\Livewire\Projects\Projects;

use App\Models\Projects\Project;
use Livewire\Component;

class ArchivedProject extends Component
{
    public $archivedProjects;

    public function render()
    {
        $this->loadData();
        // dd($this->archivedProjects);
        return view('livewire.projects.projects.archived-project');
    }

    public function loadData()
    {
        $this->archivedProjects = Project::getArchivedProjects();
    }

    public function restore($id)
    {
        Project::restoreProject($id);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Restored',
            'text' => 'It will list on the table.'
        ]);
    }

    #[On('alertConfirm')]
    public function alertConfirm($id)
    {
        // dd('apakah delete');
        $this->dispatch('swal:confirm', [
            'type' => 'warning',
            'message' => 'Are you sure?',
            'text' => 'You won\'t be able to revert this!',
            'id' => $id,
            'dispatch' => 'delete-project',
        ]);
    }

    #[On('delete-project')]
    public function delete($id)
    {
        // dd('apakah delete');
        Project::delete($id);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.'
        ]);
    }
}
