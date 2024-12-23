<?php

namespace App\Livewire\Projects\Budget;

use App\Models\Budget;
use Livewire\Attributes\On;
use Livewire\Component;

class MasterBudget extends Component
{
    public function render()
    {
        return view('livewire.projects.budget.master-budget');
    }
}
