<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use App\Models\Department;
use App\Models\nominee;

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
        'nominee_id',
        'email',
        'password',
        'fullname',
        'phone',
        'date_of_birth',
        'about',
        'gender',
        'about',
        'status',
        'recruitment_date',
        'img_url',
        'level',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function nominees()
    {
        return $this->belongsTo(nominee::class);
    }
    public static function getallUser()
    {
        $user = User::leftjoin('departments', 'users.department_id', 'departments.id')
            ->leftjoin('nominees', 'users.nominee_id', 'nominees.id')
            ->select('users.*', 'nominees.nominees', 'departments.name');
        return $user->paginate(7);
    }
    public static function fillter_status($searchst)
    {
        $user = User::leftjoin('departments', 'users.department_id', 'departments.id')
            ->leftjoin('nominees', 'users.nominee_id', 'nominees.id')
            ->select('users.*', 'nominees.nominees', 'departments.name')
            ->where('users.status', '=', "$searchst");
        return $user->paginate(7);
    }

    public static function fillter_dp($searchdp)
    {
        $user = User::leftjoin('departments', 'users.department_id', 'departments.id')
            ->leftjoin('nominees', 'users.nominee_id', 'nominees.id')
            ->select('users.*', 'nominees.nominees', 'departments.name')
            ->where('users.department_id', '=', "$searchdp");
        return $user->paginate(7);
    }
    public static function getUserDetail($id)
    {
        $user = User::leftjoin('departments', 'users.department_id', 'departments.id')
            ->leftjoin('nominees', 'users.nominee_id', 'nominees.id')
            ->select('users.*', 'nominees.nominees', 'departments.name')
            ->where('users.id', '=', "$id");
        return $user->get();
    }
    public static function interviewer($search)
    {
        $user = User::where('personnel_code', 'like', "%$search%")
            ->orWhere('fullname', 'like', "%$search%")
            ->orWhere('email', 'like', "%$search%")
            ->Where('position_id', '<', 8)
            ->limit(5)->get();
        return $user;
    }
    public static function getAllUser_p_d()
    {
        $result = User::leftjoin('departments', 'users.department_id', 'departments.id')
            ->leftjoin('nominees', 'users.nominee_id', 'nominees.id')
            ->select('users.*', 'nominees.nominees', 'departments.name');
        return $result->paginate(7);
    }
    public static function search_user($search)
    {
        $result = User::where('personnel_code', 'like', "%$search%")
            ->orWhere('fullname', 'like', "%$search%")
            ->orWhere('email', 'like', "%$search%")
            ->leftjoin('departments', 'users.department_id', 'departments.id')
            ->leftjoin('nominees', 'users.nominee_id', 'nominees.id')
            ->select('users.*', 'nominees.nominees', 'departments.name');
        return $result->paginate(7);
    }


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
        return $users->paginate(7);
    }
    public static function getAll()
    {
        $users = User::leftjoin('departments', 'users.department_id', 'departments.id')
            ->leftjoin('nominees', 'users.nominee_id', 'nominees.id')
            ->select('users.*', 'nominees.nominees', 'departments.name');
        return $users->paginate(7);
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
                        Trạng Thái</th>';
        if (Auth::user()->level == 2) {
            $html .= '  <th
                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        Chỉnh Sửa</th> ';
        }

        $html .= '     <th
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
            $html .= '<img src="./img/' . $ns->img_url . '" class="avatar me-3"
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
            if ($ns->nominee_id == '') {
                $html .= '   <p class="text-sm font-weight-bold  mb-0" >Chưa có chức vụ</p> ';
            } else {
                $html .= '   <p class="text-sm font-weight-bold  mb-0" >' . $ns->nominees . '</p> ';
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
            } else {
                $html .= '<span class="badge badge-sm bg-gradient-warning">Không xác định</span> ';
            }

            if (Auth::user()->level == 2) {
                $html .= '</td>
             <td><div class="form-check form-switch justify-content-center">';

                if ($ns->level != 0) {
                    $html .= '  <input class="form-check-input read-checkbox-level" user-data-src="' . $ns->id . '" type="checkbox" id="flexSwitchCheckDefault" checked >';
                } else {
                    $html .= '  <input class="form-check-input read-checkbox-level" user-data-src="' . $ns->id . '" type="checkbox" id="flexSwitchCheckDefault" >';
                }
                $html .= '</div></td>';
            }



            $html .= '   <td class="align-middle text-end">
                            <div class="d-flex px-3 py-1 justify-content-center align-items-center"> ';
            if (!Auth::user()->level == 0) {
                $html .= '<a class="text-sm font-weight-bold mb-0 " id="btn-del"
                                    onclick="onDelete(' . $ns->id . ')">
                                    Xóa
                                </a> |';
                if ($ns->position_id == '') {
                    $html .= '     <a id="btn-edit" data-bs-toggle="offcanvas"
                                    onclick="getdetail(' . $ns->id . ')"
                                    data-pos="xxx"
                                    data-bs-target="#offcanvasNavbarupdate"
                                    class="text-sm font-weight-bold mb-0 ps-2">
                                    Sửa
                                </a> ';
                } else {
                    $html .= '     <a id="btn-edit" data-bs-toggle="offcanvas"
                                    onclick="getdetail(' . $ns->id . ')"
                                    data-pos="' . $ns->position_id . '"
                                    data-bs-target="#offcanvasNavbarupdate"
                                    class="text-sm font-weight-bold mb-0 ps-2">
                                    Sửa
                                </a> ';
                }
            } else {
                $html .= '      <a id="btn-edit" data-bs-toggle="offcanvas"
                                    onclick="getdetailview(' . $ns->id . ')"
                                    data-bs-target="#offcanvasNavbarupdate"
                                    class="text-sm font-weight-bold mb-0 ps-2">
                                    Xem
                                </a> ';
            }

            $html .= '</div>
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
