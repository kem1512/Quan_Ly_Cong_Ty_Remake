<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class equiment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'specifications',
        'manufacture',
        'warranty_date',
        'out_of_date',
        'price',
        'status',
        'equiment_type_id',
    ];
}
