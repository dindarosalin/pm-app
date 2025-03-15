<?php

namespace App\Livewire\Dashboard;

use App\Models\Projects\Project;
use Livewire\Component;

class DashboardAll extends Component
{
    public $percentagesProgress;

    public function getDataOnsite()
    {
        
    }

    public function getDataWfh()
    {
        
    }

    public function projectOnSuchedule()
    {
        
    }

    public function projectBehindSchedule()
    {
        
    }

    public function totalResources()
    {
        
    }

    public function health()
    {
        
    }

    public function projectProgress()
    {
        return $progress = Project::getAll();
        // dd($this->percentagesProgress);
    }

    public function mount()
    {
        $this->percentagesProgress = $this->projectProgress();
    }
    

    
    public function render()
    {
        return view('livewire.dashboard.dashboard-all');
    }
}
