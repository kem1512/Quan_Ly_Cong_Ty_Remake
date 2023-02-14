<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'position_id',
        'department_id',
        'personnel_code',
        'title',
        'email',
        'password',
        'fullname',
        'phone',
        'date_of_birth',
        'address',
        'gender',
        'about',
        'status',
        'recruitment_date',
        'img_url',
        'level',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Always encrypt the password when it is updated.
     *
     * @param $value
     * @return string
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public static function getUsers()
    {
        $users = DB::table('users');
        return $users->paginate(8);
    }



    public static function UserBuild($nhansu)
    {
        $html = '
        <div class="table-responsive p-0">
        <table class="table align-items-center mb-0">
            <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Mã
                        Nhân
                        Sự</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Họ
                        Tên
                    </th>
                    <th
                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                        Email</th>
                    <th <th
                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                        Chức Vụ</th>
                    <th
                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        Phòng Ban</th>
                    <th
                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        Trạng Thái</th>
                    <th
                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        Action</th>
                </tr>
            </thead>
            <tbody> ';
        if ($nhansu == null) {
            $html .= '<p>không có dữ liệu</p>';
        }
        foreach ($nhansu as $ns) {
            $html .= '
                    <tr>
                        <td class="">
                            <p class="text-sm font-weight-bold mb-0">' . $ns->personnel_code . '</p>
                        </td>
                        <td>
                            <div class="d-flex px-3 py-1">
                                <div>';
            if ($ns->img_url == '') {
                $ns->img_url = 'avatar2.png';
            }
            $html .= '<img src="./file/' . $ns->img_url . '" class="avatar me-3"
                                        alt="Avatar">
                                </div>
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">' . $ns->fullname . '</h6>
                                </div>
                            </div>
                        </td>

                        <td>
                        <p class="text-sm font-weight-bold mb-0">' . $ns->email . '</p>
                        </td>

                        <td>';
            if (!$ns->title == '') {
                $html .= '   <p class="text-sm font-weight-bold mb-0">' . $ns->title . '</p> ';
            } else {
                if ($ns->position_id === 1) {
                    $html .= ' <p class="text-sm font-weight-bold mb-0">Tổng Giám Đốc</p>';
                } else if ($ns->position_id === 2) {
                    $html .= ' <p class="text-sm font-weight-bold mb-0">Giám Đốc</p>';
                } else if ($ns->position_id === 3) {
                    $html .= ' <p class="text-sm font-weight-bold mb-0">Trưởng Phòng</p>';
                } else if ($ns->position_id === 4) {
                    $html .= ' <p class="text-sm font-weight-bold mb-0">Tổ Trưởng</p>';
                } else if ($ns->position_id === 5) {
                    $html .= ' <p class="text-sm font-weight-bold mb-0">Nhóm Trưởng</p>';
                } else if ($ns->position_id === 6) {
                    $html .= ' <p class="text-sm font-weight-bold mb-0">Chuyên Viên</p>';
                } else if ($ns->position_id === 7) {
                    $html .= ' <p class="text-sm font-weight-bold mb-0">Nhân Viên</p>';
                } else if ($ns->position_id === 8) {
                    $html .= ' <p class="text-sm font-weight-bold mb-0">Thử Việc</p>';
                } else if ($ns->position_id === 9) {
                    $html .= ' <p class="text-sm font-weight-bold mb-0">Học Việc</p>';
                } else if ($ns->position_id === 10) {
                    $html .= ' <p class="text-sm font-weight-bold mb-0">Thực Tập Sinh</p>';
                } else {
                    $html .= ' <p class="text-sm font-weight-bold mb-0">Chưa Có</p>';
                }
            }

            $html .= '</td>
                        <td class="align-middle text-center text-sm">
                        <!-- sau sử dụng dữ liệu default = 0 , và thêm điều kiện if else  -->';

            if (!$ns->name == '') {
                $html .= ' <p class="text-sm font-weight-bold mb-0">' . $ns->name . '</p>';
            } else {
                $html .= ' <p class="text-sm font-weight-bold mb-0">Chưa vào phòng ban</p>';
            }

            $html .= ' </td>
                        <td class="align-middle text-center text-sm"> ';

            if ($ns->status === 0) {
                $html .= '
                <span class ="badge badge-sm bg-gradient-secondary">Chưa kích hoạt</span>';
            } else if ($ns->status === 1) {
                $html .= '<span class="badge badge-sm bg-gradient-success">Hoạt Động</span> ';
            } else if ($ns->status === 2) {
                $html .= '<span class="badge badge-sm bg-gradient-light">Nghỉ Phép</span> ';
            } else if ($ns->status === 3) {
                $html .= '<span class="badge badge-sm bg-gradient-danger">Khoá</span> ';
            } else if ($ns->status === 4) {
                $html .= '<span class="badge badge-sm bg-gradient-danger">Nghỉ Việc</span> ';
            }
             else {
                $html .= '<span class="badge badge-sm bg-gradient-warning">Không xác định</span> ';
            }

            $html .= '</td>
                        <td class="align-middle text-end">
                            <div class="d-flex px-3 py-1 justify-content-center align-items-center">    
                                <a class="text-sm font-weight-bold mb-0 " id="btn-del"
                                    onclick="onDelete(' . $ns->id . ')">
                                    Delete
                                </a>
                                <a id="btn-edit" data-bs-toggle="offcanvas"
                                    onclick="getdetail(' . $ns->id . ')"
                                    data-bs-target="#offcanvasNavbarupdate"
                                    class="text-sm font-weight-bold mb-0 ps-2">
                                    Edit
                                </a>
                            </div>
                        </td>
                    </tr> ';
        }
        $html .= '
            </tbody>
        </table>
        ' . $nhansu->links() . '
    </div> ';
        return $html;
    }
}
