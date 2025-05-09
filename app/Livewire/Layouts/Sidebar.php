<?php

namespace App\Livewire\Layouts;
use Livewire\Component;

class Sidebar extends Component
{
    public $projectId;

    public function mount()
    {
        // Mengambil ID project dari URL
        $this->projectId = request()->route('projectId');
    }

    public function render()
    {
        // dd($this->projectId);
        return view('livewire.layouts.sidebar', [
            'projectId' => $this->projectId
        ]);
    }

}
