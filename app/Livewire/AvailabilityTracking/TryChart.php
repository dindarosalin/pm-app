<?php

namespace App\Livewire\AvailabilityTracking;

use App\Models\Employee\Employee;
use App\Models\TimeCard\TimeCard;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Livewire\Component;

class TryChart extends Component
{
    public $defaultTime = 8;
    public $employeeId;
    public $year, $month;

    public $pvMonthly;
    public $pvWeekly;
    public $pvDaily;

    public $evDailyArray;
    public $evDaily;

    public $spiDailyArray;
    public $spiDaily;

    


    public function render()
    {
        $this->planedValue($this->employeeId);
        $this->earnedValue($this->employeeId);
        $this->spiValue($this->employeeId);

        return view('livewire.availability-tracking.try-chart');
    }

// ==============================================================TIME=====================================================================
    public function getMonth($year, $month)
    {
        $workMonth = [];

        for ($month = 1; $month <= 12; $month++) {
            $workDays = 0;

            $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
            $endOFMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();
            $workPeriod = CarbonPeriod::create($startOfMonth, $endOFMonth);

            foreach ($workPeriod as $day) {
                if ($day->isWeekday()) {
                    $workDays++;
                }
            }
            $workMonth[$month] = [
                'bulan' => $month,
                'hari_kerja' => $workDays,
                'total_jam' => $workDays * $this->defaultTime,
            ];
        }
        return $workMonth;
    }

    public function getWeek($year, $month)
    {
        $workWeek = [];
        $workDays = [];
        $weeklyCounter = 1;

        $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endOFMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();
        $workPeriod = CarbonPeriod::create($startOfMonth, $endOFMonth);

        foreach ($workPeriod as $day) {
            if ($day->isWeekday()) {
                $workDays[] = $day->toDateString();

                if (count($workDays) == 5) {
                    $workWeek["Minggu $weeklyCounter"] = [
                        'hari_kerja' => $workDays,
                        'total_jam' => count($workDays) * $this->defaultTime,
                    ];
                    $workDays = [];
                    $weeklyCounter++;
                }
            }
        }
        return $workWeek;
    }
    
// ==============================================================PV, EV, SPI FOR DAILY, WEEKLY, MONTHLY=====================================================================
    public function planedValue($employeeId)
    {
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;

        $salary = (float)Employee::getById($employeeId)->salary;

        // MONTHLY
        $workMonthByYear = $this->getMonth($year, $month);
        $totalWorkMonth = $workMonthByYear[$month]['total_jam'];
        $this->pvMonthly = $totalWorkMonth * $salary;

        // WEEKLY
        $workWeekByMonth = $this->getWeek($year, $month);
        $totalWorkMonth = $workWeekByMonth['Minggu 1']['total_jam'];
        $this->pvWeekly = $totalWorkMonth * $salary;

        // DAILY
        $this->pvDaily = [];
        for ($day = 1; $day <= Carbon::createFromDate($year, $month)->daysInMonth; $day++) {
            $date = Carbon::createFromDate($year, $month, $day)->toDateString();
            $this->pvDaily[] = [
                'date' => $date,
                'value' => $this->defaultTime * $salary,
            ];
        }
        $this->dispatch('get-pv-daily', $this->pvDaily);


        // KODE AWAL
        // $this->pvDaily = $this->defaultTime * $salary;
        // $this->dispatch('get-pv-daily', $this->pvDaily);
    }

    public function earnedValue ($employeeId)
    {
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;

        $countDate = Carbon::createFromDate($year, $month)->daysInMonth;
        
        // DAILY
        $pvByDaily = (int)$this->pvDaily;
       
        $this->evDailyArray = [];
        
        for ($day = 1; $day <= $countDate; $day++) {
            $earnedTime = TimeCard::getTaskByEmployee($employeeId, $month, $day);

            if ($earnedTime > 0) {
                $this->evDaily = ($earnedTime / $this->defaultTime) * $pvByDaily;
            } else {
                $this->evDaily = 0;
            }
            $this->evDailyArray[] = $this->evDaily;
        }
        $this->dispatch('get-ev-daily', $this->evDailyArray);
    }

    public function spiValue($employeeId)
    {
        // DAILY
        $pvByDaily = (int)$this->pvDaily;
        $this->spiDailyArray = [];

        foreach ($this->evDailyArray as $evByDaily) {
            $this->spiDaily = $evByDaily > 0 ? $evByDaily / $pvByDaily : 0;
            $this->spiDailyArray[] = $this->spiDaily;
        }
        $this->dispatch('get-spi-daily', $this->spiDailyArray);
    }

    public function mount($employeeId)
    {
        $this->employeeId = $employeeId;
    }
}



