<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    public function department_childs(){
        return $this -> hasMany(Department::class, 'id_department_parent', 'id');
    }
}
