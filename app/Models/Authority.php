<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authority extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_autho',
        'personnel',
        'departments',
        'equipment',
    ];
}
