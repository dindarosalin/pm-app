<?php

namespace App\Models\Approvals;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\DB;

class ApprovalProjectProcurement extends BaseModel
{
    public static function getAll()
    {
        return DB::table('approval_project_procurements')->get();
    }

    public static function getAllByUserId($auth)
    {
        return DB::table('approval_project_procurements')
        ->where('user_id', $auth)
        ->join('approval_statuses', 'approval_project_procurements.status_id', '=', 'approval_statuses.id')
        ->select(
            'approval_project_procurements.*',
            'approval_statuses.name as status_name'
        )
        ->get();
    }

    public static function getById($id)
    {
        return DB::table('approval_project_procurements')->where('id', $id)->first();
    }

    public static function create($storeData)
    {
        // dd($storeData);
        DB::table('approval_project_procurements')->insert([
            'user_id' => $storeData['user_id'],
            'approval_id' => $storeData['approval_id'],
            'status_id' => $storeData['status_id'],
            'last_updated' => now(),
            'submission_date' => now(),
            'accountable' => $storeData['accountable'],
            'description' => $storeData['description'],
            'project_name' => $storeData['project_name'],
            'client' => $storeData['client'],
            'budget' => $storeData['budget'],
            'start_date_estimation' => $storeData['start_date_estimation'],
            'end_date_estimation' => $storeData['end_date_estimation'],
        ]);
    }

    public static function update($id, $storeData)
    {
        // dd($storeData);
        DB::table('approval_project_procurements')->where('id', $id)->update([
            'user_id' => $storeData['user_id'],
            'approval_id' => $storeData['approval_id'],
            'status_id' => $storeData['status_id'],
            'last_updated' => now(),
            'submission_date' => $storeData['submission_date'],
            'accountable' => $storeData['accountable'],
            'description' => $storeData['description'],
            'project_name' => $storeData['project_name'],
            'client' => $storeData['client'],
            'budget' => $storeData['budget'],
            'start_date_estimation' => $storeData['start_date_estimation'],
            'end_date_estimation' => $storeData['end_date_estimation'],
            'updated_by' => $storeData['updated_by']
        ]);
    }

    public static function delete($id)
    {
        DB::table('approval_project_procurements')->where('id', $id)->delete();
    }
}
