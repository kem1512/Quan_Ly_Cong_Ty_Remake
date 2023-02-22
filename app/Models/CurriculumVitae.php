<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurriculumVitae extends Model
{
    use HasFactory;
    protected $fillable = [
        'email',
        'name',
        'phone',
        'interview_date',
        'interview_time',
        'date_of_birth',
        'position_id',
        'nominee',
        'gender',
        'address',
        'status', // 0 default | 1 faild cv | 2 pass cv or đợi xếp lịch pv  | 4 đã xếp lịch phỏng vấn | 5 phỏng vấn faild | 6 pv Pass | 7 no nhận ofer | 8 chuyển sang thử việc 
        'interview_date', // ngày phỏng vấn
        'note',
        'url_cv',
        'created_at',
        'updated_at'
    ];
    public static function getAllCV()
    {
        $cv = CurriculumVitae::where('status', '=', 0)->orWhere('status', '=', 1)->orWhere('status', '=', 2)
            ->leftjoin('nominees', 'curriculum_vitaes.nominee', 'nominees.id')
            ->select('curriculum_vitaes.*', 'nominees.nominees');
        return $cv->paginate(12);
    }

    public static function UTBuild($cvs)
    {
        $html = '<div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tên Ứng Viên</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Số Điện Thoại</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Chức Vụ Ứng Tuyển</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trạng Thái</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                            </tr>
                        </thead>
                        <tbody>';
        if ($cvs == null) {
            $html .= '<p>không có dữ liệu</p>';
        }
        foreach ($cvs as $cv) {
            $html .= '<tr>
                        <td><p class="text-sm font-weight-bold mb-0">' . $cv->name . '</p></td>
                        <td><p class="text-sm font-weight-bold mb-0">' . $cv->email . '</p></td>
                        <td><p class="text-sm font-weight-bold mb-0">' . $cv->phone . '</p></td>
                        <td><p class="text-sm font-weight-bold mb-0">' . $cv->nominees . '</p></td>
                        <td class="text-center">';

            if ($cv->status == 0) {
                $html .= ' <p class="text-sm font-weight-bold mb-0">Chưa Duyệt</p>';
            } else if ($cv->status == 2) {
                $html .= ' <p class="text-sm font-weight-bold mb-0">Đã Duyệt</p>';
            } else if ($cv->status == 1) {
                $html .= ' <p class="text-sm font-weight-bold mb-0">Từ Chối</p>';
            }

            $html .= '  </td>
                        <td class="text-center">';
            if ($cv->status == 0) {
                $html .= ' <a id="btn-edit" data-bs-toggle="offcanvas"  data-bs-target="#offcanvasNavbarevaluatecv" onclick="get_CV_By_ID_eva(' . $cv->id .
                    ')" class="text-sm font-weight-bold mb-0 ps-2">Evaluate</a>';
            }
            $html .= '   <a id="btn-edit" data-bs-toggle="offcanvas"  data-bs-target="#offcanvasNavbareditcv" data-pos="' . $cv->position_id . '" onclick="get_CV_By_ID_edit(' . $cv->id . ')" class="text-sm font-weight-bold mb-0 ps-2">Edit</a> 
                       </td>

                    </tr>';
        }

        $html .= '   </tbody>
                </table>
                     ' . $cvs->LINKS() . '
            </div>';
        return $html;
    }
}
