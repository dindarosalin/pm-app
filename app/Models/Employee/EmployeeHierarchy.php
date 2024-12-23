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
}
