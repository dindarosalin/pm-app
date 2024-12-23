<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\DB;

class ButtonStart extends BaseModel
{

    public $isButtonDisabled;

    public static function create($data)
    {
        $buttonDisabled = DB::table('button_starts')
            ->updateOrInsert(
                ['employee_id' => $data['employee_id']], // Kondisi
                [
                    'button_disabled_at' => now(),
                    'created_at' => now()
                ] // Data yang diupdate atau dibuat
            );
            
    }

    public static function getById($id)
    {
        return DB::table('button_starts')
        ->where('employee_id', $id)
        ->select('button_disabled_at')
        ->get();
    }
}
