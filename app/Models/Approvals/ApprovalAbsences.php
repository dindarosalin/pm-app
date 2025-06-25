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
        ->join('app_user', 'approval_absences.user_id', '=', 'app_user.user_id')
        ->join('approval_absence_types', 'approval_absences.subject', '=', 'approval_absence_types.id')
        ->join('approval_statuses', 'approval_absences.status_id', '=', 'approval_statuses.code')
        ->join('approval_types', 'approval_absences.approval_id', '=', 'approval_types.id' )
        ->select(
            'approval_absences.*',
            'app_user.user_name as user_name',
            'approval_absence_types.name as subject_name',
            'approval_statuses.name as status_name',
            'approval_types.name as approval_name'
            )
        ->get();
    }

    public static function getAllByRole($auth)
    {
        $hr = DB::table('app_role_user')->where('user_id', $auth)->where('role_id', '10')->value('user_id');

        if ($auth == $hr) {
            return DB::table('approval_absences')
                ->join('approval_statuses', 'approval_absences.status_id', '=', 'approval_statuses.code')
                ->join('approval_types', 'approval_absences.approval_id', '=', 'approval_types.id' )
                ->select(
                    'approval_reimburses.*',
                    'approval_statuses.name as status_name',
                    'approval_types.name as approval_name'
                )
                ->get();
        }

    }

    public static function getAllByUserId($auth)
    {
        return DB::table('approval_absences')
            ->where('user_id', $auth)
            ->join('approval_absence_types', 'approval_absences.subject', '=', 'approval_absence_types.id')
            ->join('approval_statuses', 'approval_absences.status_id', '=', 'approval_statuses.code')
            ->join('approval_types', 'approval_absences.approval_id', '=', 'approval_types.id' )
            ->select(
                'approval_absences.*',
                'approval_absence_types.name as subject_name',
                'approval_statuses.name as status_name',
                'approval_types.name as approval_name'
                )
            ->get();
    }

    public static function getById($id)
    {
        return DB::table('approval_absences')
        ->where('approval_absences.id', $id)
        ->join('app_user', 'approval_absences.user_id', '=', 'app_user.user_id')
        ->join('approval_absence_types', 'approval_absences.subject', '=', 'approval_absence_types.id')
        ->join('approval_statuses', 'approval_absences.status_id', '=', 'approval_statuses.code')
        ->join('approval_types', 'approval_absences.approval_id', '=', 'approval_types.id' )
        ->select(
            'approval_absences.*',
            'app_user.user_name as user_name',
            'approval_absence_types.name as subject_name',
            'approval_statuses.name as status_name',
            'approval_types.name as approval_name'
        )
        ->first();
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
            'note' => $storeData['noteDelegation'],
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
                'note' => $storeData['noteDelegation'],
            ]);
    }

    public static function delete($id)
    {
        DB::table('approval_absences')
            ->where('id', $id)
            ->delete();
    }

    public static function getByAccountable($id)
    {
        // dd($id);
        return DB::table('approval_absences')
            ->where('accountable', $id)
            ->join('app_user', 'approval_absences.user_id', '=', 'app_user.user_id')
            ->join('approval_absence_types', 'approval_absences.subject', '=', 'approval_absence_types.id')
            ->join('approval_statuses', 'approval_absences.status_id', '=', 'approval_statuses.code')
            ->join('approval_types', 'approval_absences.approval_id', '=', 'approval_types.id')
            ->select(
                'approval_absences.*',
                'app_user.user_name as user_name',
                'approval_absence_types.name as subject_name',
                'approval_statuses.name as status_name',
                'approval_types.name as approval_name'
            )
            ->get();
    }

    public static function updateStatus($id, $statusCode, $note)
    {
        DB::table('approval_absences')
        ->where('id', $id)
        ->update([
            'status_id' => $statusCode,
            'last_updated' => now(),
            'note' => $note
        ]);
    }

    public static function updateNote($id, $note)
    {
        DB::table('approval_absences')
        ->where('id', $id)
        ->update([
            'last_updated' => now(),
            'note' => $note
        ]);
    }
}
