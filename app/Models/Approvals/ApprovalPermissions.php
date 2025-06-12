<?php

namespace App\Models\Approvals;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\DB;

class ApprovalPermissions extends BaseModel
{
    public static function getAll()
    {
        return DB::table('approval_permission')
            ->join('approval_permission_types', 'approval_permission.subject', '=', 'approval_permission_types.id')
            ->select('approval_permission.*', 'approval_permission_types.name as subject_name')
            ->get();
    }

    public static function getAllByUserId($auth)
    {
        return DB::table('approval_permission')
            ->where('user_id', $auth)
            ->join('approval_permission_types', 'approval_permission.subject', '=', 'approval_permission_types.id')
            ->join('approval_statuses', 'approval_permission.status_id', '=', 'approval_statuses.id')
            ->join('approval_types', 'approval_permission.approval_id', '=', 'approval_types.id' )
            ->select(
                'approval_permission.*',
                'approval_permission_types.name as subject_name',
                'approval_statuses.name as status_name',
                'approval_types.name as approval_name'
                )
            ->get();
    }

    public static function getById($id)
    {
        return DB::table('approval_permission')->where('id', $id)->first();
    }

    public static function create($storeData)
    {
        // dd($storeData);
        DB::table('approval_permission')->insert([
            'user_id' => $storeData['auth'],
            'subject' => $storeData['subject'],
            'accountable' => (int) $storeData['accountable'],
            'approval_id' => $storeData['approvalId'],
            'permission_detail' => $storeData['permDetail'],
            'start_date' => $storeData['startDate'],
            'end_date' => $storeData['endDate'],
            'total_days' => $storeData['totalDays'],
            'emergency_contact' => $storeData['emergencyContact'],
            'relationship_emergency_contact' => $storeData['relationship'],
            'delegation' => (int) $storeData['delegation'],
            'delegation_detail' => $storeData['noteDelegation'],
            'status_id' => $storeData['statusId'],
            'last_updated' => now(),
            'submission_date' => now(),
            'file_name' => $storeData['fileName'],
            'file_path' => $storeData['filePath'],
            'note' => $storeData['noteDelegation'],
        ]);
    }

    public static function update($id, $storeData)
    {
        // dd($storeData);

        DB::table('approval_permission')
            ->where('id', $id)
            ->update([
                'user_id' => $storeData['auth'],
                'subject' => $storeData['subject'],
                'accountable' => (int) $storeData['accountable'],
                'approval_id' => $storeData['approvalId'],
                'permission_detail' => $storeData['permDetail'],
                'start_date' => $storeData['startDate'],
                'end_date' => $storeData['endDate'],
                'total_days' => $storeData['totalDays'],
                'emergency_contact' => $storeData['emergencyContact'],
                'relationship_emergency_contact' => $storeData['relationship'],
                'delegation' => (int) $storeData['delegation'],
                'delegation_detail' => $storeData['noteDelegation'],
                'status_id' => $storeData['statusId'],
                'last_updated' => now(),
                'submission_date' => $storeData['submitDate'],
                'file_name' => $storeData['fileName'],
                'file_path' => $storeData['filePath'],
                'note' => $storeData['noteDelegation'],
            ]);
    }

    public static function delete($id)
    {
        DB::table('approval_permission')->where('id', $id)->delete();
    }
}
