<?php

namespace App\Models\Approvals;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\Clock\now;

class ApprovalReimburse extends BaseModel
{
    public static function getAll()
    {
        return DB::table('approval_reimburses')->get();
    }

        public static function getAllByUserId($auth)
    {
        return DB::table('approval_reimburses')
        ->where('user_id', $auth)
        ->join('approval_statuses', 'approval_reimburses.status_id', '=', 'approval_statuses.id')
        ->join('approval_types', 'approval_reimburses.approval_id', '=', 'approval_types.id' )
        ->select(
            'approval_reimburses.*',
            'approval_statuses.name as status_name',
            'approval_types.name as approval_name'
        )
        ->get();
    }

    public static function getById($id)
    {
        return DB::table('approval_reimburses')->where('id', $id)->first();
    }

    public static function create($storeData)
    {
        DB::table('approval_reimburses')->insert([
            'approval_id' => $storeData['approvalId'],
            'status_id' => $storeData['statusId'],
            'subject' => $storeData['subject'],
            'last_updated' => now(),
            'submission_date' => now(),
            'total' => $storeData['total'],
            'user_id' => $storeData['auth'],
            'file_path' => $storeData['filePath'],
            'file_name' => $storeData['fileName'],
            'description' => $storeData['description']
        ]);
    }

    public static function update($id, $storeData)
    {
        DB::table('approval_reimburses')
            ->where('id', $id)
            ->update([
                'approval_id' => $storeData['approvalId'],
                'status_id' => $storeData['statusId'],
                'subject' => $storeData['subject'],
                'last_updated' => now(),
                'submission_date' => $storeData['subDate'],
                'total' => $storeData['total'],
                'user_id' => $storeData['auth'],
                'file_path' => $storeData['filePath'],
                'file_name' => $storeData['fileName'],
                'description' => $storeData['description']
            ]);
    }

    public static function delete($id)
    {
        DB::table('approval_reimburses')->where('id', $id)->delete();
    }

    public static function updateTotal($id)
    {
        $total = ApprovalReimburseDetail::getByReimburseId($id);

        DB::table('approval_reimburses')->where('id', $id)->update([
            'total' => $total
        ]);
    }
}
