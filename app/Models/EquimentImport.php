<?php

namespace App\Models;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

// class EquimentImport implements ToModel, WithHeadingRow
// {
//     public function model(array $row)
//     {
//         return new equiment([
//             'name' => $row['name'],
//             'specifications' => $row['specifications'],
//             'supplier_id' => $row['supplier_id'],
//             'warranty_date' => date('Y-m-d H:i:s', strtotime($row['warranty_date'])),
//             'out_of_date' => date('Y-m-d H:i:s', strtotime($row['out_of_date'])),
//             'price' => $row['price'],
//             'equipment_type_id' => $row['equipment_type_id'],
//             'status' => $row['status'],
//         ]);
//     }
// }