<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'id_type',
        'status',
    ];
    public static function getAll_Equipment_AND_TYPE()
    {
        $eq = Equipment::leftjoin('equipment_types', 'equipment.id_type', 'equipment_types.id')
            ->select('equipment.*', 'equipment_types.name as equipment_type')->paginate(config('const.EQUIPMENT.PAGE_SIZE_EQUIPMENT'));
        // dd($eq);
        return $eq;
    }
    public static function biuld_equipment($equiments)
    {
        $i = 0;
        $html = '
        <div class="table-responsive p-0 h-100"
             style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
             <table class="table  table-hover align-items-center mb-0">
                 <thead>
                     <tr>
                         <th
                             class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                             Mã Thiết Bị</th>
                         <th
                             class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                             Thiết Bị</th>
                         <th
                             class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                             Thể Loại</th>
                         <th
                             class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                             Thao Tác</th>
                     </tr>
                 </thead>
                 <tbody>';
        foreach ($equiments as $eq) {
            $i = $i + 1;
            if ($i == 1) {
                $html .= ' <tr id="data-row-' . $i . '" class="poiter equipment-table-row bgr-selected" data-get="' . $eq->id . '">';
            } else {
                $html .= ' <tr id="data-row-' . $i . '" class="poiter equipment-table-row" data-get="' . $eq->id . '">';
            }
            $html .= '  <td>
                 <p class="text-sm font-weight-bold  mb-0" >' . $eq->code . '</p>
                </td>
                <td>
                <p class="text-sm font-weight-bold  mb-0" >' . $eq->name . '</p>
                </td>
                <td>
                <p class="text-sm font-weight-bold  mb-0 text-center" >' . $eq->equipment_type . '</p>
                </td>
                <td class="d-flex justify-content-center">
                 <a class="text-sm font-weight-bold  mb-0"  >Sửa</a>
                </td>
            </tr>
            ';
        }

        $html .= '  </tbody>
             </table>
             ' . $equiments->links() . '
        </div>';
        return $html;
    }
}
