<?php
/**
 * Note
 * Component master dari release notes
 */

namespace App\Livewire\Projects\Release;

use Livewire\Component;

class ReleaseNotes extends Component
{
    //Menampung nilai projectId dari route
    public $projectId;

    public function render()
    {
        // dd($this->projectId);
        $this->dispatch('handle-project-id', $this->projectId);
        return view('livewire.projects.release.release-notes');
    }
}
