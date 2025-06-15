<?php

namespace App\Models\Master;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\DB;

class WfhStatuses extends BaseModel
{
    protected $table = 'wfh_statuses';

    protected $fillable = [
        'status_name',
        'description',
        'created_at',
        'updated_at',
    ];

    public function getAllStatus()
    {
        return DB::table('status_wfh')
            ->select('id', 'status_wfh', 'code', 'created_at', 'updated_at')
            ->get();
    }
}
