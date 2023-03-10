<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_equipment',
        'id_type',
        'equipment_code',
        'warranty_expiration_date',
        'img',
        'status',
        'specifications',
        'date_added',
        'supplier_id',
        'note',
    ];
}
