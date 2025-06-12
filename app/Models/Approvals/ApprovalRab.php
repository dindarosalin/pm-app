<?php

namespace App\Models\Approvals;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\DB;

class ApprovalRab extends BaseModel
{
    public static function getAll()
    {
        return DB::table('approval_rab')->get();
    }

    public static function getAllByUserId($auth)
    {
        return DB::table('approval_rab')
        ->where('user_id', $auth)
        ->join('approval_statuses', 'approval_rab.status_id', '=', 'approval_statuses.id')
        ->select(
            'approval_rab.*',
            'approval_statuses.name as status_name'
        )
        ->get();
    }

    public static function getById($id)
    {
        return DB::table('approval_rab')->where('id', $id)->first();
    }

    public static function create($storeData)
    {
        // dd($storeData);
        DB::table('approval_rab')->insert([
            'user_id' => $storeData['auth'],
            'subject' => $storeData['subject'],
            'approval_id' => $storeData['approvalId'],
            'status_id' => $storeData['statusId'],
            'last_updated' => now(),
            'submission_date' => now(),
            'description' => $storeData['rabDesc'],
            'total' => $storeData['total']
        ]);
    }

    public static function update($id, $storeData)
    {
        // dd($storeData);
        DB::table('approval_rab')->where('id', $id)->update([
            'user_id' => $storeData['auth'],
            'subject' => $storeData['subject'],
            'approval_id' => $storeData['approvalId'],
            'status_id' => $storeData['statusId'],
            'last_updated' => now(),
            'submission_date' => $storeData['subDate'],
            'description' => $storeData['rabDesc'],
            'total' => $storeData['total']
        ]);
    }

    public static function delete($id)
    {
        DB::table('approval_rab')->where('id', $id)->delete();
    }

    public static function updateTotal($id)
    {
        $total = ApprovalRabDetail::getByRabId($id);

        DB::table('approval_rab')->where('id', $id)->update([
            'total' => $total
        ]);
    }
}
