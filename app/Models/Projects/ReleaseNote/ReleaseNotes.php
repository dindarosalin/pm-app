<?php

namespace App\Models\Projects\ReleaseNote;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Client\Request;
use App\Http\Controllers\ReleaseNote;
use App\Models\Base\BaseModel;

class ReleaseNotes extends BaseModel
{
    public static function update(array $storeData)
    {
        return DB::table('release_notes')
        ->where('id', $storeData['releaseId'])
        ->update([
            'title'=> $storeData['title'],
            'tag' => $storeData['tag'],
            'content' => $storeData['content'],
            'attachments'=> $storeData['newattachments'],
            'updated_at'=>now(),
            'id_project' => $storeData['projectId'],
        ]);
        ;
    }

    public static function create(array $storeData){
        // dd($storeData);
        return  DB::table('release_notes')
        ->insert(
            [
                'title'         =>$storeData['title'],
                'tag'           =>$storeData['tag'],
                'content'       =>$storeData['content'],
                'attachments'   =>$storeData['newattachments'],
                'created_at' => now(),
                'id_project'       =>$storeData['projectId'],
                ]
            );
            
    }

    // Get all data release notes
    // and join with projects
    public static function getAll($projectId){
        return DB::table('release_notes')
        ->where('release_notes.id_project', $projectId)
        ->select('release_notes.*', 'projects.title as pj_title')
        ->orderBy('release_notes.id', 'desc')
        ->leftJoin('projects', 'release_notes.id_project', '=' , 'projects.id')
        // ->latest(release_notes);
        ->get();
    }

    //Get detail from release notes
    public static function detail($id){
        return DB::table('release_notes')
        ->select('release_notes.*', 'projects.title as pj_title')
        ->join('projects', 'release_notes.id_project', '=' , 'projects.id')
        ->where('release_notes.id', $id)
        ->get();
    }

    public static function delete($id)
    {
        return DB::table('release_notes')
        ->where('id', $id)
        ->delete();
    }

    /**
     * FILTER DATA
     */

    //SEARCH BY KEYWORD
    public static function scopeSearch($query, $searchTerm)
    {
        return $query->filter(function ($releaseNote) use ($searchTerm) {
            return stripos($releaseNote->title, $searchTerm) !== false ||
                stripos($releaseNote->tag, $searchTerm) !== false;
                // stripos($releaseNote->client, $searchTerm) !== false ||
                // stripos($releaseNote->pm_name, $searchTerm) !== false ||
                // stripos($releaseNote->budget, $searchTerm) !== false ||
                // stripos($releaseNote->team, $searchTerm) !== false ||
                // stripos($releaseNote->completion, $searchTerm) !== false;
        });
    }

    // FILTER DAILY-WEEKLY-MONTHLY-ALL
    public static function scopeFilterByTimeFrame($query, $timeFrame)
    {
        // $currentDate = now()->startOfDay();
        $currentDate = Carbon::now();

        if ($timeFrame === 'daily') {
            // Filter for today
            $startDate = $currentDate->copy()->startOfDay();
            $endDate = $currentDate->copy()->endOfDay();
        } elseif ($timeFrame === 'weekly') {
            $startDate = $currentDate->copy()->startOfWeek();
            $endDate = $currentDate->copy()->endOfWeek();
        } elseif ($timeFrame === 'monthly') {
            $startDate = $currentDate->copy()->startOfMonth();
            $endDate = $currentDate->copy()->endOfMonth();
        } elseif ($timeFrame === 'yearly') {
            // Filter for this year
            $startDate = $currentDate->copy()->startOfYear();
            $endDate = $currentDate->copy()->endOfYear();
        } else {
            return $query;
        }

        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    public static function scopeFilterByDateRange($query, $fromDate, $toDate)
    {
        if ($fromDate && $toDate) {
            return $query->whereBetween('created_at', [$fromDate, $toDate]);
        }

        return $query;
    }


}
