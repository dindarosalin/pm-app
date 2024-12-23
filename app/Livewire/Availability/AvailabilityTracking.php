<?php

namespace App\Livewire\Availability;

use App\Models\Employee\Department;
use App\Models\Employee\Employee;
use App\Models\Employee\Role;
use App\Models\EmployeeSalary;
use App\Models\Master\Holiday;
use App\Models\Projects\Project;
use App\Models\Projects\Task\Task;
use App\Models\TimeCard\TimeCard;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;


class AvailabilityTracking extends Component
{
    public $employees, $departments, $roles;
    public $avails;

    public $search = '';
    public $sortColumn = null;
    public $sortDirection = 'asc';
    public $filters = [];

    public $fromNumber = [];
    public $toNumber = [];

    public $timeFrame = [];
    public $fromToDate;

    public $fromDate = [];
    public $toDate = [];

    // COST
    public $workTime;
    public $defaultTime = 8;
    public $salaryId;
    public $dayWeek = 5;
    public $dayWork;
    public $year;
    public $month;
    public $id;
    public $salary;
    public $pvWeek;
    public $pvMonth;
    public $startDate;
    public $endDate;
    public $employeeId;
    public $evWeek;
    public $evMonth;
    public $userId;
    public $gajiPokok;
    public $gajiValue;
    public $spiWeek;
    public $cpiWeek;
    public $status;
    public $label;
    public $spiMonth;
    public $cpiMonth;
    public $kondisi;
    public $situasi;
    // public $employeeId;



    public function render()
    {
        $this->loadData();
        $this->employees = $this->filter($this->employees);
        return view('livewire.availability.availability-tracking');
    }

    public function loadData()
    {
        $employees = User::get();

        foreach ($employees as $employee) {
            $employee->tasks = Task::getTaskByAssignTo($employee->user_id);
            $employee->projects = Project::getProjectByAuth($employee->user_id);
            $employee->timecards = TimeCard::getByAuth($employee->user_id);
        }

        $this->employees = $employees;

        // dd($this->employees);
    }

    // GET PROJECT BY ID
    #[On('showById')]
    public function showById($id)
    {
        $employee = Employee::getById($id);

        $employee->tasks = Task::getTaskByAssignTo($id);
        $employee->projects = Project::getProjectByAuth($id);
        $employee->timecards = TimeCard::getByAuth($id);

        $this->avails = $employee;
        // dd($this->avails);
        $this->dispatch('show-view-offcanvas');
    }

    public function filter($avails)
    {
        // Pencarian
        if ($this->search) {
            $avails = Employee::scopeSearch($avails, $this->search);
        }

        // Sorting
        if ($this->sortColumn) {
            $avails = Project::scopeSorting($avails, $this->sortColumn, $this->sortDirection);
        }

        foreach ($this->fromNumber as $column => $fromValue) {
            $toValue = $this->toNumber[$column] ?? null;
            $avails = Project::scopeFilterByNumberRange($avails, $column, $fromValue, $toValue);
        }

        if ($this->filters) {
            foreach ($this->filters as $column => $value) {
                if (!empty($value)) {
                    $avails = Project::scopeFilter($avails, $column, $value);
                }
            }
        }

        // Filter berdasarkan time frame dan date range
        if ($this->timeFrame) {
            foreach ($this->timeFrame as $column => $this->fromToDate) {
                if ($this->fromToDate === 'custom-date') {
                    $avails = Project::scopeFilterByDateRange($avails, $this->fromDate, $this->toDate, $column);
                } else {
                    $avails = Employee::scopeFilterByTimeFrame($avails, $column, $this->fromToDate);
                }
            }
        }

        return $avails;
    }

    public function applySortBy($column)
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortColumn = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function resetFilter()
    {
        $this->reset();
    }

// ====================================================COST PERFORMA===========================================================================
// GET TIME TO WORK 
    public function getTimeWork($year, $month)
    {
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;

        $workDay = Holiday::getActiveDayMonth($month, $year);
        // dd($workDay);

        // calculate total work time
        $this->workTime = $workDay * $this->defaultTime; //bulan
        $this->dayWork = $this->dayWeek * $this->defaultTime; //minggu
        // dd($this->workTime, $this->dayWork);
    }

    public function planedValue ($userId)
    {
        // get salary
        $this->salary = EmployeeSalary::getSalaryById($userId);
        $salaryValue = (int)$this->salary[0]->salary;
       
        $this->pvWeek = $this->dayWork * $salaryValue;
        $this->pvMonth = $this->workTime * $salaryValue;
        // dd($this->pvWeek, $this->pvMonth);
    }
    
    public function earnedValue ($employeeId)
    {
        $this->dispatch('open-getPerforma');
        $this->salary = EmployeeSalary::getSalaryById($employeeId);
        $salaryValue = (int)$this->salary[0]->salary;
        // $this->employeeId = $this->employeeId;
        $durationWeek = TimeCard::getWeekDuration($employeeId);  
        $durationMonth = TimeCard::getMonthDuration($employeeId);
        // $timeWeek = (int)$durationWeek[0]->duration;
        
        $this->evMonth = $salaryValue * $durationMonth;
        $this->evWeek = $salaryValue * $durationWeek;
            // dd($durationMonth, $this->evMonth, $durationWeek, $this->evWeek);
            // dd($durationMonth, $durationWeek, $this->dayWork, $this->workTime);          
        }

        public function actualCost($employeeId)
        {
            $this->gajiPokok = EmployeeSalary::getPokokById($employeeId);
            $this->gajiValue = (int)$this->gajiPokok[0]->gaji_pokok;

            // dd($gajiValue);
        }


    
    public function calculateAll($employeeId){
        $this->planedValue($employeeId);
        $this->earnedValue($employeeId);
        $this->actualCost($employeeId);
        $this->spiWeek = $this->evWeek / $this->pvWeek;
        $this->cpiWeek = $this->evWeek / $this->gajiValue;
        $this->spiMonth = $this->evMonth / $this->pvMonth;
        $this->cpiMonth = $this->evMonth / $this->gajiValue;

        // kondisi spi week
        if ($this->spiWeek < 1) {
            $this->status = 'Behind Schedule';
        } else if ($this->spiWeek > 1) {
            $this->status = 'Ahead Schedule';
        } else if($this->spiWeek = 1) {
            $this->status =  'On Time';
        } else {
            $this->status = "";
        }

        // kondisi CPI week
        if ($this->cpiWeek < 1) {
            $this->label = 'Over Budget';
        } else if ($this->cpiWeek > 1) {
            $this->label = 'Under Budget';
        } else if ($this->cpiWeek = 1) {
            $this->label = 'Planed';
        } else {
            $this->label = "";
        }

        // kondisi spi month
        if ($this->spiMonth < 1) {
            $this->kondisi = 'Behind Schedule';
        } else if ($this->spiMonth > 1) {
            $this->kondisi = 'Ahead Schedule';
        } else if($this->spiMonth = 1) {
            $this->kondisi =  'On Time';
        } else {
            $this->kondisi = "";
        }

        // kondisi CPI week
        if ($this->cpiMonth < 1) {
            $this->situasi = 'Over Budget';
        } else if ($this->cpiMonth > 1) {
            $this->situasi = 'Under Budget';
        } else if ($this->cpiMonth = 1) {
            $this->situasi = 'Planed';
        } else {
            $this->situasi = "";
        }
    }


    public function mount()
    {
        // $this->planedValue($this->salaryId);
        $this->getTimeWork($this->year, $this->month);
    }
    












// GET TASK IN MONTH
    // public function getWorkMonth($year, $month)
    // {
    //     // get day work of the month
    //     $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
    //     $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();

    //     // create peroid from start to end of the month
    //     $workPeriod = CarbonPeriod::create($startOfMonth, $endOfMonth);

    //     $workDay = 0;

    //     foreach ($workPeriod as $date){
    //         if ($date->isWeekday()) {
    //             $workDay++;
    //         }
    //     }

    //     return $workDay;

    //     $this->workTime = $workDay * $defaulTime;
    //     return $this->workTime;

    // }


    // PV (Planed Value based on actual hours task)
    // public function planedValue($employeeId)
    // {
    //     $defaultTime = 8; //jam default kerja

    //    // get the current year and month dynamically
    //    $year = Carbon::now()->year;
    //    $month = Carbon::now()->month;

    //    // get Salary
    //    $salary = (float)Employee::getById($employeeId)->salary;

    //    $this->workTime = $this->getWorkMonth($year, $month);
    //    $this->workPlan = $this->workTime * $defaultTime;

    // //    dd($this->workTime, $this->workPlan);

    //     $pv = $this->workPlan * $salary;
    //     return $pv;
    // }

    // public function earnedValue($employeeId)
    // {
    //     $defaultTime = 8;

    //     // get the current year and month dynamically
    //     $year = Carbon::now()->year;
    //     $month = Carbon::now()->month;
    //     $day = Carbon::now()->day;
    //     // $date = Carbon::now()->date;

    //     // $this->employeeDuration = TimeCard::getTaskByEmployee($employeeId, $month, $day);
    //     $this->employeeDuration = TimeCard::getDuration($employeeId, Carbon::create($year, $month, $day));
        
    //     // get Salary
    //     $salary = (float)Employee::getById($employeeId)->salary;
       
    //     $this->workTime = $this->getWorkMonth($year, $month);
    //     $this->workPlan = $this->workTime * $defaultTime;

    //     $bac = $this->workPlan * $salary;
       

    //     $progressEarned = ($this->employeeDuration / $this->workPlan)* 100;
    //     // dd($progressEarned, $this->workPlan, $this->employeeDuration);

    //     $ev = round(($progressEarned / 100)* $bac, 2);
    //     return $ev;
    // }


        // foreach ($employee->tasks as $task) {
            // $taskId = $task->id; // Mengambil taskId dari setiap task
            // $taskPlan = Task::taskPlanDay($taskId); // Memanggil taskPlanDay berdasarkan taskId

            // Misalkan $taskPlan mengembalikan nilai yang ingin dijumlahkan
        //     $totalAllDay += $taskPlan->sum('total_days');  // Menambah nilai ke dalam $totalAllDay
        // }

        // dd($totalAllDay);

        // $taskPlanHours = $totalAllDay * $defaulTime;
        
        // get task hours and sum total duration task yang sudah dikerjakan dari timecarde
        // $taskHours = DB::table('time_cards')
        //     ->where('employee_id', $employeeId)
        //     ->sum('duration');

        // hitung progress
        // $this->progress = ($taskHours / $taskPlanHours) * 100;
        
        // ev
        // return ( $this->progress / 100) * $salary;
        // dd($ev);

        
    // }

    // public function actualCost()
    // {
    //     // get the current year and month dynamically
    //     $year = Carbon::now()->year;
    //     $month = Carbon::now()->month;

    //     $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth(); // 1 used to specify the first day of the month.
    //     $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();

    //     // ambil actual cost dari track per project , tapi dalam waktu sebulan
    //     $ac = DB::table('tracks')
    //             ->whereBetween('purchase_date', [$startOfMonth, $endOfMonth])
    //             ->sum('total_per_item');
        
    //     return $ac;
    // }

    // public function getCost($employeeId)
    // {
    //     $this->pv = $this->planedValue($employeeId);
    //     $this->ev = $this->earnedValue($employeeId);
    //     $this->ac = $this->actualCost();
    //     $this->spi = $this->ev / $this->pv;
    //     $this->cpi = $this->ev / $this->ac;


    //     // kondisi status spi
    //     if ($this->spi < 1) {
    //         $this->status = 'Behind Schedule';
    //     } else if ($this->spi > 1) {
    //         $this->status = 'Ahead Schedule';
    //     } else if($this->spi = 1) {
    //         $this->status =  'On Time';
    //     } else {
    //         $this->status = "";
    //     }

    //     // kondisi CPI
    //     if ($this->cpi < 1) {
    //         $this->label = 'Over Budget';
    //     } else if ($this->cpi > 1) {
    //         $this->label = 'Under Budget';
    //     } else if ($this->cpi = 1) {
    //         $this->label = 'Planed';
    //     } else {
    //         $this->label = "";
    //     }

    //     $this->dispatch('open-getcost');
    // }
}
