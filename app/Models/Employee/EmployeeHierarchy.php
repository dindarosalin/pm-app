<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EmployeeHierarchy extends Model
{
    use HasFactory;

    protected $table = 'employee_hierarchy';

    protected $fillable = ['parent_id', 'user_id'];

    public function parent(){
        return $this->belongsTo('App\Models\Employee\EmployeeHierarchy', 'parent_id', 'user_id');
    }

    public function child(){
        return $this->hasMany('App\Models\Employee\EmployeeHierarchy', 'parent_id', 'user_id');
    }

    public function getEmploye(){
        return DB::table('app_user')
            ->where('user_id', $this->user_id)
            ->first();
    }

    public static function getHierarchyUp($auth){
        // dd($auth);
        $parent = EmployeeHierarchy::where('user_id', $auth)->whereHas('parent')->first();
        // dd($parent);
        $current = $parent->parent;
        $atasan = [];
        while($current!=null){
            $parentEmployee = EmployeeHierarchy::where('user_id', $current->user_id)->first();
            $paramAtasan = [
                'id' => $parentEmployee->user_id,
                'name' => $parentEmployee->getEmploye()->user_name,
                'email' => $parentEmployee->getEmploye()->user_email
            ];
            array_push($atasan, $paramAtasan);
            $current = $current->parent;
        }

        // dd($atasan);
        return $atasan;
    }

    public static function getHierarchyDown($auth) {
        $dataBawahanLangsung = [];
        // Get bawahan dari user login
        $employee = EmployeeHierarchy::where('user_id', $auth)->whereHas('child')->first();

        if ($employee) {
            foreach($employee->child as $e){
                $param = [
                    'id' => $e->user_id,
                    'name' => $e->getEmploye()->user_name,
                    'email' => $e->getEmploye()->user_email
                ];

                $dataBawahanLangsung[] = $param;
            }

            // Get All bawahan
            $usr = EmployeeHierarchy::where('parent_id', $employee->user_id)->get();
            $dataSemuaBawahan = [];
            $no = 1;

            while(count($usr) > 0){
                $nextUsr = [];
                foreach ($usr as $c) {
                    $param = [
                        'id' => $c->user_id,
                        'name' => $c->getEmploye()->user_name,
                        'email' => $c->getEmploye()->user_email
                    ];
                    array_push($dataSemuaBawahan, $param);
                    $nextUsr = array_merge($nextUsr, $c->child->all());
                }
                $no++;
                $usr = $nextUsr;
            }

            // dd($dataSemuaBawahan);
            return $dataSemuaBawahan;
        }

        // return $dataBawahanLangsung;
    }
}
