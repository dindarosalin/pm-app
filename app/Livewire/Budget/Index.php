<?php

namespace App\Livewire\Budget;

use App\Models\Budget;
use Illuminate\Support\Facades\DB;

use Livewire\Component;

class Index extends Component
{
    public $budgets;

    // public function mount()
    // {
    //     $this->budgets = Budget::all();
    // }
    // {
    //     $this->budgets = [
    //         [
    //             'id'=> 1,
    //             'project' => 'Nusapala Parking',
    //             'time_estimation' => '23 Februari 2024 - 14 Januari 2025',
    //         ],
    //         [
    //             'id'=> 2,
    //             'project' => 'Bima Autobotics',
    //             'time_estimation' => '`7 Juni 2023` - 16 Desember 2026',
    //         ],
    //         [
    //             'id'=> 3,
    //             'project' => 'Nusapala Ticket',
    //             'time_estimation' => '23 Februari 2021 - 14 Januari 2025',
    //         ],
    //         [
    //             'id'=> 4,
    //             'project' => 'Nusapala Scan',
    //             'time_estimation' => '26 Mei 2024 - 14 Mei 2025',
    //         ],
    //         [
    //             'id'=> 5,
    //             'project' => 'Nusapala Parking',
    //             'time_estimation' => '23 Februari 2024 - 14 Januari 2025',
    //         ],
    //     ];
    // }
    
    
    public function render()
    {
        $projects = DB::table('projects')->get();
        return view('livewire.budget.index', compact('projects'));
    }
}
