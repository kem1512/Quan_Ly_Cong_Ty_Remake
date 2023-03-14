<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_equipment',
        'equipment_code',
        'imei',
        'warranty_expiration_date',
        'img',
        'status',
        'specifications',
        'date_added',
        'supplier_id',
        'note',
    ];
    public static function get_equipment_detail_by_equipment($equiments)
    {
        $equiments_detail = EquipmentDetail::where('id_equipment', $equiments)
            ->leftjoin('suppliers', 'equipment_details.supplier_id', 'suppliers.id')
            ->select('equipment_details.*', 'suppliers.name as supplier')
            ->paginate(config('const.EQUIPMENT.PAGE_SIZE_EQUIPMENT_DETAIL'));
        // dd($equiments_detail);
        return $equiments_detail;
    }
    public static function build_equipment_detail($equipment_details, $equipment)
    {
        $html = '
        <div class="text-center" id="wraper_equipment_name" code="' . $equipment->id . '">
        <h5>' . $equipment->name . '</h5>
        </div>
        <div class="table-responsive p-0"
            style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th
                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                            Mã Sản Phẩm</th>
                        <th
                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            Hạn Bảo Hành</th>
                        <th
                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            Nhà Cung Cấp</th>
                        <th
                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            Trạng Thái</th>
                        <th
                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            Thao Tác</th>
                    </tr>
                </thead>
                <tbody>';
        if (count($equipment_details) == 0) {
            $html .= '<tr class="">
                        <td colspan="5" class="table-active text-center "><p class="text-sm font-weight-bold  mb-0">Không Có Sản Phẩm</p></td>
                      </tr>';
        }
        foreach ($equipment_details as $eq_detail) {
            $html .=
                '
             <tr>
                <td>
                 <div class="d-flex px-3 py-1">
                                <div>';
            if (empty($eq_detail->img)) {
                $eq_detail->img = 'thumbnail.png';
            }
            $html .= '<img src="./img/' . $eq_detail->img . '" class="avatar me-3"
                                        alt="Avatar">
                                </div>
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">' . $eq_detail->equipment_code . '</h6>
                                </div>
                            </div>
                </td>
                <td>
                <p class="text-sm font-weight-bold  mb-0" >' . $eq_detail->warranty_expiration_date . '</p>
                </td>
                <td class="d-flex justify-content-center">
                <p class="text-sm font-weight-bold  mb-0" >' . $eq_detail->supplier . '</p>
                </td>
                <td class="align-middle text-center text-sm">';
            if ($eq_detail->status == 0) {
                $html .= '  <span class="badge badge-sm bg-gradient-success">Chưa sử dụng</span>';
            } else {
                $html .= '  <span class="badge badge-sm bg-gradient-danger">Chưa cài trạng thái</span>';
            }
            $html .= '</td>
                <td class="d-flex justify-content-center mt-3">
                 <a href="" class="text-sm font-weight-bold  " >Sửa</a>
                </td>
            </tr>
            ';
        }

        $html .= '  </tbody>
             </table>
             ' . $equipment_details->links() . '
        </div>';
        return $html;
    }
}
