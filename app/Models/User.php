<?php

namespace App\Models;

use App\Http\Controllers\AuthorizationController;
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
        'autho',
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
    public static function search_user_autho($search)
    {
        $result = User::where('personnel_code', 'like', "%$search%")
            ->orWhere('fullname', 'like', "%$search%")
            ->orWhere('email', 'like', "%$search%")
            ->leftjoin('departments', 'users.department_id', 'departments.id')
            ->leftjoin('nominees', 'users.nominee_id', 'nominees.id')
            ->leftjoin('authorities', 'users.autho', 'authorities.id')
            ->select('users.*', 'nominees.nominees', 'departments.name', 'authorities.name_autho');
        return $result;
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

    public static function build_autho_by_department($id)
    {
        $users = User::where('users.department_id', $id)
            ->leftjoin('departments', 'users.department_id', 'departments.id')
            ->leftjoin('nominees', 'users.nominee_id', 'nominees.id')
            ->leftjoin('authorities', 'users.autho', 'authorities.id')
            ->select('users.*', 'nominees.nominees', 'departments.name', 'authorities.name_autho');
        return $users;
    }
    public static function build_autho()
    {
        $users = User::leftjoin('departments', 'users.department_id', 'departments.id')
            ->leftjoin('nominees', 'users.nominee_id', 'nominees.id')
            ->leftjoin('authorities', 'users.autho', 'authorities.id')
            ->select('users.*', 'nominees.nominees', 'departments.name', 'authorities.name_autho');
        // dd($users);
        return $users;
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
        $authentication = Authority::get_Roles_By_Id_User(Auth::user()->id);
        $html = '
        <div class="table-responsive p-0">
        <table class="table align-items-center mb-0">
            <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">M??
                        Nh??n
                        S???</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">H???
                        T??n
                    </th>
                    <th
                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                        Email</th>
                    <th <th
                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                        Ch???c V???</th>
                    <th
                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        Ph??ng Ban</th>
                    <th
                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        Tr???ng Th??i</th> 
                        
                    <th
                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        Action</th>
                </tr>
            </thead>
            <tbody> ';


        if ($nhansu == null) {
            $html .= '<p>kh??ng c?? d??? li???u</p>';
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
                $html .= '   <p class="text-sm font-weight-bold  mb-0" >Ch??a c?? ch???c v???</p> ';
            } else {
                $html .= '   <p class="text-sm font-weight-bold  mb-0" >' . $ns->nominees . '</p> ';
            }

            $html .= '</td>
                        <td class="align-middle text-center text-sm">
                        <!-- sau s??? d???ng d??? li???u default = 0 , v?? th??m ??i???u ki???n if else  -->';

            if (!$ns->name == '') {
                $html .= ' <p class="text-sm font-weight-bold mb-0">' . $ns->name . '</p>';
            } else {
                $html .= ' <p class="text-sm font-weight-bold mb-0">Ch??a v??o ph??ng ban</p>';
            }

            $html .= ' </td>
                        <td class="align-middle text-center text-sm"> ';

            if ($ns->status === 0) {
                $html .= '
                <span class ="badge badge-sm bg-gradient-secondary">Ch??a k??ch ho???t</span>';
            } else if ($ns->status === 1) {
                $html .= '<span class="badge badge-sm bg-gradient-success">Ho???t ?????ng</span> ';
            } else if ($ns->status === 2) {
                $html .= '<span class="badge badge-sm bg-gradient-light">Ngh??? Ph??p</span> ';
            } else if ($ns->status === 3) {
                $html .= '<span class="badge badge-sm bg-gradient-danger">Kho??</span> ';
            } else if ($ns->status === 4) {
                $html .= '<span class="badge badge-sm bg-gradient-danger">Ngh??? Vi???c</span> ';
            } else {
                $html .= '<span class="badge badge-sm bg-gradient-warning">Kh??ng x??c ?????nh</span> ';
            }
            $html .= '</td>';
            $html .= '   <td class="align-middle text-end">
                            <div class="d-flex px-3 py-1 justify-content-center align-items-center"> ';
            if ($authentication->personnel->delete_personnel === "true") {
                $html .= '<a class="text-sm font-weight-bold mb-0 " id="btn-del"
                                    onclick="onDelete(' . $ns->id . ')">
                                    X??a
                                </a> ';
            }
            if ($authentication->personnel->update_personnel) {
                $html .= '   | <a id="btn-edit" data-bs-toggle="offcanvas"
                                    onclick="getdetail(' . $ns->id . ')"
                                    data-pos="' . $ns->position_id . '"
                                    data-bs-target="#offcanvasNavbarupdate"
                                    class="text-sm font-weight-bold mb-0 ps-2">
                                    S???a
                                </a> ';
            }
            $html .= '     | <a id="btn-edit" data-bs-toggle="offcanvas"
                                    onclick="getdetailview(' . $ns->id . ')"
                                    data-bs-target="#offcanvasNavbarupdate"
                                    class="text-sm font-weight-bold mb-0 ps-2">
                                    Xem
                                </a> |';


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

    public static function Autho_Build($nhansu)
    {
        $index = 0;
        $html = '<div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"> M?? Nh??n S???</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">H??? T??n</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ch???c V???</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Ph??ng Ban</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Nh??m quy???n hi???n t???i</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7  ps-1">C???p Quy???n</th>
                            </tr>
                        </thead>
                        <tbody>';
        // if (empty($nhansu)) {
        //     $html .= '<tr><td><p>kh??ng c?? d??? li???u</p></td></tr>';
        // } else {
        foreach ($nhansu as $ns) {
            $index = $index + 1;
            $html .= '<tr>
                        <td>
                            <p class="text-sm font-weight-bold mb-0">' . $ns->personnel_code . '</p>
                        </td>
                        <td>
                            <div class="d-flex px-3 py-1">
                                <div>';
            if ($ns->img_url == '') {
                $ns->img_url = 'avatar2.png';
            }
            $html .= '  <img src="./img/' . $ns->img_url . '" class="avatar me-3" alt="Avatar">
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
            if (empty($ns->nominees)) {
                $ns->nominees = 'Ch??a th??m ch???c v???';
            }
            $html .= '   <p class="text-sm font-weight-bold mb-0">' . $ns->nominees . '</p>
                                        </td>
                                        <td>';
            if (empty($ns->name)) {
                $ns->name = 'Ch??a v??o ph??ng ban';
            }
            $html .= ' <p class="text-sm font-weight-bold mb-0 ">' . $ns->name . '</p>
                                        </td> 
                                        <td>';
            if (empty($ns->name_autho)) {
                $ns->name_autho = 'Ch??a c?? nh??m quy???n';
            }
            $html .= '   <p class="text-sm font-weight-bold mb-0 text-center">' . $ns->name_autho . '</p>';
            $html .= '  </td>
                                        <td>
                                            <div class="form-check justify-content-center">
                                                <input class="form-check-input set_role_user " id="table_user_col_' . $index . '" style="margin-left:10%;" type="checkbox" data-user="' . $ns->id . '">
                                            </div>
                                        </td>
                                    </tr>';
        }
        // }

        $html .= '               </tbody>
                            </table>
                              <div class="row">
                              
                             <div class="col-11">' . $nhansu->links() . '</div>
                             <div class="col-1">
                             <div class="form-group">
                        <select class="form-control "id="count_result_autho">
                            <option value="7">7 K???t Qu???</option>
                            <option value="10">10 K???t Qu???</option>
                            <option value="20">20 K???t Qu???</option>
                            <option value="50">50 K???t Qu???</option>
                        </select>
                    </div>
                             </div>
                            </div>

                        </div>';
        return $html;
    }
}
