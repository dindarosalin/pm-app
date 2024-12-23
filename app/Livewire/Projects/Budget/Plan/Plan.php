<?php

namespace App\Livewire\Projects\Budget\Plan;

use App\Models\Plan as ModelsPlan;
use Livewire\Attributes\On;
use Livewire\Component;

class Plan extends Component
{
    public $plans;
    public $planId;
    public $projectId;


    public function render()
    {
        return view('livewire.projects.budget.plan.plan');
    }
}
