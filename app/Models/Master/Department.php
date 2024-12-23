<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    protected $table = 'master_department';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'created_by',
    ];
}
