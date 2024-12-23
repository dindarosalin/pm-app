<?php

namespace App\Livewire\Report;

use Livewire\Component;
use Livewire\WithPagination;
use App\Livewire\Projects\Tasks;
use App\Models\Projects\Task\Task;
// use Illuminate\Support\Facades\DB;

class ShowReport extends Component
{

    public function render()
    {
        $reports = Task::getAllReport();
        // dd($reports);
        return view('livewire.report.show-report', compact('reports'));
    }
}
