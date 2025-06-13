<?php

namespace App\Models\Approvals;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ApprovalAbsences extends BaseModel
{
    public static function getAll()
    {
        return DB::table('approval_absences')
            ->join('approval_absence_types', 'approval_absences.subject', '=', 'approval_absence_types.id')
            ->select('approval_absences.*', 'approval_absence_types.name as subject_name') // sesuaikan dengan kolom yang dibutuhkan
            ->get();
    }

    public static function getById($id)
    {
        return DB::table('approval_absences')->where('id', $id)->first();
    }

    public static function create($storeData)
    {
        DB::table('approval_absences')->insert([
            'user_id' => $storeData['auth'],
            'subject' => $storeData['subject'],
            'accountable' => (int) $storeData['accountable'],
            'approval_id' => $storeData['approvalId'],
            'absence_detail' => $storeData['absDetail'],
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
        ]);
    }

    public static function update($id, $storeData)
    {
        DB::table('approval_absences')
            ->where('id', $id)
            ->update([
                'user_id' => $storeData['auth'],
                'subject' => $storeData['subject'],
                'accountable' => (int) $storeData['accountable'],
                'approval_id' => $storeData['approvalId'],
                'absence_detail' => $storeData['absDetail'],
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
            ]);
    }

    public static function delete($id)
    {
        DB::table('approval_absences')
            ->where('id', $id)
            ->delete();
    }
}
