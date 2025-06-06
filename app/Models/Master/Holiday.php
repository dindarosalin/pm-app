<?php

namespace App\Models\Master;
use Illuminate\Support\Facades\DB;
use App\Models\Base\BaseModel;
use function Laravel\Prompts\table;

class Holiday extends BaseModel
{
    public static function getAll()
    {
        return DB::table('holidays')->get();
    }

    public static function getById($id)
    {
        return DB::table('holidays')->where('id', $id)->first();
    }

    public static function create($storeData)
    {
        DB::table('holidays')->insert(
            [
                'name' => $storeData['holidayName'],
                'date' => $storeData['holidayDate'],
                'description' => $storeData['holidayDescription'],
                'is_national' => $storeData['holidayType'],
            ]
        );
    }

    public static function update($id, $storeData)
    {
        // dd($storeData);
        DB::table('holidays')
        ->where('id',  $id)
        ->update(
            [
                'name' => $storeData['holidayName'],
                'date' => $storeData['holidayDate'],
                'description' => $storeData['holidayDescription'],
                'is_national' => $storeData['holidayType'],
            ]
        );
    }

    public static function getActiveDayMonth($month, $year)
    {
        // Total hari dalam bulan yang diberikan
        $totalDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        // Buat array untuk menyimpan semua hari libur dalam bulan tersebut
        $holidays = DB::table('holidays')
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->pluck('date') // Mengambil hanya kolom tanggal
            ->toArray();

        // Hitung hari kerja dengan mengurangi akhir pekan dan hari libur
        $activeDays = 0;

        for ($day = 1; $day <= $totalDaysInMonth; $day++) {
            $currentDate = date("Y-m-d", strtotime("$year-$month-$day"));

            // Periksa apakah hari adalah akhir pekan (Sabtu atau Minggu)
            $dayOfWeek = date('N', strtotime($currentDate));
            $isWeekend = ($dayOfWeek == 6 || $dayOfWeek == 7);

            // Periksa apakah tanggal termasuk hari libur
            $isHoliday = in_array($currentDate, $holidays);

            // Jika bukan akhir pekan atau hari libur, tambahkan sebagai hari aktif
            if (!$isWeekend && !$isHoliday) {
                $activeDays++;
            }
        }

        // jumlah active days = jumlah hari 1 bulan - weekend - holidays
        return $activeDays;
    }

    public static function delete($id)
    {
        DB::table('holidays')->where('id', $id)->delete();
    }

}
