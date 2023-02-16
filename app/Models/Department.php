<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Department extends Model
{
    use HasFactory;
    use NodeTrait;

    public function department_childs(){
        return $this -> belongsTo(Department::class, 'parent_id');
    }
}
