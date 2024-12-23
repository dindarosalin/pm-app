<?php

namespace App\Livewire\Availability;

use App\Models\Employee\Employee;
use App\Models\TimeCard\TimeCard;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Performa extends Component
{
    public $id;
    public $defaultTime = 8;
    public $year, $month;
    public $employeeId;
    // public $workWeek;

    public $pvDaily;
    public $pvWeekly;
    public $pvMonthly;

    public $activityDate;
    public $evDaily;
    public $day;
    public $evWeeklyArray;
    public $evCurrentWeek;
    public $workWeek;
    public $evDailyArray;
    public $workTime;
    public $evMonthly;

    public $spiDaily;
    public $spiDailyArray;

    // public $chartData;
    
  
  

    public function render()
    {
        // COBA
        // $this->chartData = $this->getChartData();


        // $this->planedValue($this->employeeId);
        // $this->earnedValue($this->employeeId);
        // $this->spiValue($this->employeeId);
        return view('livewire.availability.performa');
    }

// =============================================================MONTHLY, WEEKLY, DAILY====================================================================================
    public function getMonth($year, $month) //work day based month in year
    {
        $workMonth = [];

        // loop every month (jan - des)
        for ($month = 1; $month<=12; $month++) {
            $workDays = 0;

        // get work day in month
            $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
            $endOFMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();
            $workPeriod = CarbonPeriod::create($startOfMonth, $endOFMonth);

        // count working day in month
            foreach ($workPeriod as $day) {
                if ($day->isWeekday()) {
                    $workDays++;
                }
            }

        // store the result/month in array
            $workMonth[$month] = [
                'bulan'  =>  $month,
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

        // get work day in month
        $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endOFMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();
        $workPeriod = CarbonPeriod::create($startOfMonth, $endOFMonth);

        foreach ($workPeriod as $day) {
            if ($day->isWeekday()) {
                $workDays[] = $day->toDateString(); //count working day in current week

                if (count($workDays) == 5) {
                    $workWeek["Minggu $weeklyCounter"] = [
                        'hari_kerja' => $workDays,
                        'total_jam' => count($workDays) * $this->defaultTime,
                    ];
                    $workDays = []; // Reset minggu
                    $weeklyCounter++;
                }
                // dd($this->workWeek);
            }
        }
        return $workWeek;
   }

// ===============================================PV, EV, SPI (MONTHLY, WEEKLY, DAILY)=======================================================================
    public function planedValue($employeeId)
    {
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;

        $salary = (float)Employee::getById($employeeId)->salary;

        // monthly
        $workMonthByYear = $this->getMonth($year, $month);
        $totalWorkMonth = $workMonthByYear[$month]['total_jam']; //working total hours actual this monthly
        $this->pvMonthly = $totalWorkMonth * $salary;
        $this->dispatch('get-pv-monthly', $this->pvMonthly);
    
        
        // weekly
        $workWeekByMonth = $this->getWeek($year, $month);
        $totalWorkMonth = $workWeekByMonth['Minggu 1']['total_jam'];
        $this->pvWeekly = $totalWorkMonth * $salary;
        $this->dispatch('get-pv-weekly', $this->pvWeekly);
    

        // daily
        $this->pvDaily = $this->defaultTime * $salary;
        $this->dispatch('get-pv-daily', $this->pvDaily);
      
    }

    public function earnedValue ($employeeId)
    {
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;
        $day = Carbon::now()->day;
        $pvByDaily = (int)$this->pvDaily;
        $countDate = Carbon::createFromDate($year, $month)->daysInMonth;
        $salary = (float)Employee::getById($employeeId)->salary;

        // Monthly
        $employeeDuration = TimeCard::getTaskByEmployee($employeeId, $month, $day);
        $this->workTime = $this->getMonth($year, $month);
        $workPlan = (int)$this->workTime * $this->defaultTime;
        $bac = $workPlan * $salary;
        $progressEarned = ($employeeDuration / $workPlan) * 100;
        $this->evMonthly = round(($progressEarned / 100)* $bac, 2);
        // dd($this->evMonthly, $this->workTime, $workPlan);

         // Weekly
         $weeklyCounter = 1;
         $this->evCurrentWeek = 0;
         $this->workWeek = $this->getWeek($year, $month);
         $this->evWeeklyArray = [];
 

        // Daily
        $this->evDailyArray = [];
        // $this->activityDate = [];

        // fetch all acitivy date for the employee in the specified month
        // $activityDates = TimeCard::activityDate($employeeId, $month)->toArray();

        // for ($day = 1; $day <= $countDate; $day++) {
        //     $currentDate = Carbon::create(Carbon::now()->year, $month, $day)->toDateString();

        //     // cek jika currentdate adalah activity date
        //     if (in_array($currentDate, $activityDates)) {
        //         $earnedTime = TimeCard::getTaskByEmployee($employeeId, $month, $day);
        //         $this->evDaily = ($earnedTime / $this->defaultTime) * $pvByDaily;
        //         $this->activityDate[] = $currentDate; //log thr activity date
        //     } else {
        //         $this->evDaily = 0;
        //     }

        //     $this->evDailyArray[] = $this->evDaily;
        //     $this->evCurrentWeek += $this->evDaily;

        //     // store weekly ev ( 5 working days)
        //     if (count($this->workWeek["Minggu $weeklyCounter"]['hari_kerja']) == count($this->evDailyArray)) {
        //         $this->evWeeklyArray["Minggu $weeklyCounter"] = $this->evCurrentWeek;
        //         $weeklyCounter++;
        //         $this->evCurrentWeek = 0;
        //     }
        //     dd($this->activityDate, $this->evDailyArray);
        // }
       

        for ($day = 1; $day <= $countDate; $day++) {
            $earnedTime = TimeCard::getTaskByEmployee($employeeId, $month, $day);

            if ($earnedTime > 0) {
                $this->evDaily = ($earnedTime / $this->defaultTime) * $pvByDaily;
            } else {
                $this->evDaily = 0;
            }
            $this->evDailyArray[] = $this->evDaily;  
            $this->evCurrentWeek += $this->evDaily;

            // store ev tiap minggu (5 hari kerja)
            if (count($this->workWeek["Minggu $weeklyCounter"]['hari_kerja']) == count($this->evDailyArray)) {
                $this->evWeeklyArray["Minggu $weeklyCounter"] = $this->evCurrentWeek;
                $weeklyCounter++;
                $this->evCurrentWeek = 0;
            }
        }

        // dd($this->evCurrentWeek, $this->evDailyArray);
       
       

              

   
        $this->dispatch('get-ev-daily', $this->evDailyArray);
        $this->dispatch('get-ev-weekly', $this->evWeeklyArray);
        // $this->dispatch('get-ev-time', $this->activityDate);
       
    }

    public function spiValue($employeeId)
    {
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;
        $pvByDaily = (int)$this->pvDaily;
        // $countDate = Carbon::createFromDate($year, $month)->daysInMonth;

        $this->spiDailyArray = [];
        
        foreach ($this->evDailyArray as $evByDaily) {
            $this->spiDaily = $evByDaily > 0 ? $evByDaily / $pvByDaily : 0;
            $this->spiDailyArray[] = $this->spiDaily;
        }
        // dd($this->spiDailyArray);
        $this->dispatch('get-spi-daily', $this->spiDailyArray);

        // for ($day = 1; $day < $countDate; $day++) {
        //     if ( $this->evDailyArray > 0) {
        //         $this->spiDaily = $this->evDailyArray / $pvByDaily;
        //     } else {
        //         $this->spiDaily = 0;
        //     }
        //     $this->spiDailyArray[] = $this->spiDaily;
        //     dd($this->spiDaily);
        // }
    }


    public function mount($employeeId)
    {
       $this->employeeId = $employeeId;
    }
// ============================================COBA================================================================================================================
    // public function getChartData()
    // {
    //     $month = Carbon::now()->month;
    //     $year = Carbon::now()->year;

    //     $this->earnedValue($this->employeeId);
    //     $this->planedValue($this->employeeId);

    //     $daysInMonth = Carbon::createFromDate($year, $month)->daysInMonth;

    //     $chartData = [
    //         'labels' => [],
    //         'pv' => [],
    //         'ev' => [],
    //         'spi' => []
    //     ];

    //     for ($day = 1; $day < $daysInMonth; $day++) {
    //         $date = Carbon::createFromDate($year, $month, $day)->toDateString();
    //         $chartData['labels'][] = $date;
    //         $chartData['pv'][] = $this->pvDaily; //pv daily constant
    //         $chartData['ev'][] = $this->evDailyArray[$day - 1] ?? 0;
    //         $chartData['spi'][] = $this->spiDailyArray[$day - 1] ?? 0;
    //     }
    //     return $chartData;
    // }
}

// // $this->planMonthly = $this->workMonthByYear * $this->defaultTime;
        // $pvMonthly = $this->planMonthly * $salary;
        // return $pvMonthly;s

        // weekly
        // $this->workWeekly = $this->getWeekly($year, $month);
        // $pvWeekly = $this->workWeekly * $salary;
        // return $pvWeekly;

        // daily
        // $this->dailyWorkHours = $this->getDaily($year, $month);
        // $this->pvDaily = $dailyWorkHours->$this->hours * $salary;

        