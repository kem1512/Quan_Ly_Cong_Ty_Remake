<?php

namespace App\Models;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EquimentImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new equiment([
            'name' => $row['name'],
            'image' => $row['image'],
            'specifications' => $row['specifications'],
            'manufacture' => $row['manufacture'],
            'warranty_date' => $row['warranty_date'],
            'out_of_date' => $row['out_of_date'],
            'price' => $row['price'],
            'status' => $row['status'],
            'equiment_type_id' => $row['equiment_type_id'],
        ]);
    }
}