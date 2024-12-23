<?php

namespace App\Models\Projects\Task;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\DB;

class Comment extends BaseModel
{
    public static function getById($taskId)
    {
        // return DB::table('comments')
        //     ->where('id_task', $taskId)
        //     ->where('parent', null)
        //     ->join('app_user', 'comments.id_employee', '=', 'app_user.user_id')
        //     ->select('comments.*', 'app_user.user_name')
        //     ->get();

        // Mengambil komentar induk beserta balasannya
        $comments = DB::table('comments')
            ->where('id_task', $taskId) // Menyaring berdasarkan taskId
            ->whereNull('parent') // Menyaring hanya komentar induk
            ->LeftJoin('app_user', 'comments.id_employee', '=', 'app_user.user_id') // Gabungkan dengan tabel pengguna
            ->select('comments.*', 'app_user.user_name') // Ambil data komentar dan nama pengguna
            ->orderBy('created_at', 'desc')
            ->get();

        // Untuk setiap komentar induk, ambil balasan terkait
        foreach ($comments as $comment) {
            // Memastikan bahwa user_name tersedia di komentar
            $comment->user_name = $comment->user_name ?? 'Unknown'; // Menambahkan nilai default jika tidak ada

            $replies = DB::table('comments')
                ->where('parent', $comment->id) // Ambil balasan untuk komentar ini
                ->leftJoin('app_user', 'comments.id_employee', '=', 'app_user.user_id') // Gabungkan dengan tabel pengguna untuk balasan
                ->select('comments.*', 'app_user.user_name') // Ambil data komentar dan nama pengguna
                // ->orderBy('created_at', 'desc')
                ->get();

            // Menambahkan balasan ke objek komentar
            $comment->replies = $replies;
        }

        return $comments;
    }

    public static function create($storeData)
    {
        // dd($storeData);
        $id_comment = DB::table('comments')
            ->insertGetId(
                [
                    'id_task' => $storeData['id_task'],
                    'id_employee' => $storeData['id_employee'],
                    'parent' => $storeData['parent'],
                    'comment' => $storeData['comment'],
                    'created_at' => now()
                ]
            );

        // return $id_comment;
    }

    public static function delete($id)
    {
        // dd($id);
        return DB::table('comments')->where('id', $id)->delete();
    }

    public static function countByTask($id)
    {
        return DB::table('comments')->where('id_task', $id)->count();
    }

    public static function reply($taskId, $id)
    {
        return DB::table('comments')
            ->where('id_task', $taskId)
            ->where('parent', $id)
            ->leftJoin('app_user', 'comments.id_employee', '=', 'app_user.user_id')
            ->select('comments.*', 'app_user.user_name')
            ->orderBy('created_at', 'desc')
            // ->paginate(5);
            ->get();
    }
}
