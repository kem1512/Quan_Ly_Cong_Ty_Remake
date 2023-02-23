<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FormDataRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\Department;
use App\Models\Position;
use App\Models\nominee;
use Illuminate\Support\Collection;
use App\Models\User;
use Illuminate\Http\Request;
use  Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate as FacadesGate;

class DepartmentController extends Controller
{
    public function index()
    {
        return view('auth.department.form');
    }

    public function create_or_update(FormDataRequest $request)
    {
        if (!$request->validated()) {
            return response()->json(['status' => 0, 'msg' => $request->errors()]);
        } else {
            $department_parent = Department::withDepth()->find($request->id_department_parent);

            if ($request->id) {
                $department = Department::find($request->id);
            } else {
                $department = new Department;
            }

            $department->code = $request->code;
            $department->name = $request->name;
            $department->status = $request->status == 'on' ? 1 : 0;

            if ($department_parent != null) {
                if ($department_parent->depth >= 3) {
                    return response()->json(['status' => 0, 'msg' => 'Không Hỗ Trợ Từ 3 Cấp Trở Lên']);
                } else {
                    $department->appendToNode($department_parent)->save();
                    return response()->json(['status' => 1, 'msg' => 'Cập nhật thành công']);
                }
            } else {
                $result = Department::withDepth()->where('code', $request->code)->get();
                if ($result->count() > 0) {
                    if (Department::find($department->id) != null) {
                        // #1 Implicit save
                        $department->saveAsRoot();

                        // #2 Explicit save
                        $department->makeRoot()->save();

                        return response()->json(['status' => 1, 'msg' => 'Cập Nhật Thành Công']);
                    } else {
                        return response()->json(['status' => 0, 'msg' => 'Mã Đã Tồn Tại']);
                    }
                } else {
                    // #1 Implicit save
                    $department->saveAsRoot();

                    // #2 Explicit save
                    $department->makeRoot()->save();
                    return response()->json(['status' => 1, 'msg' => 'Thêm Thành Công']);
                }
            }
            return response()->json(['status' => 0, 'msg' => 'Thao tác thất bại']);
        }
    }

    public function search(Request $request)
    {
        $search = $request->search;

        if (!empty($search)) {
            $departments = Department::orderby('name', 'asc')->select('id', 'name')->where('name', 'like', '%' . $search . '%')->limit(5)->get();
        }

        $response = array();
        foreach ($departments as $department) {
            $response[] = array("value" => $department->id, "label" => $department->name);
        }

        return response()->json($response);
    }

    public function searchUsers(Request $request)
    {
        $search = $request->search;

        if (!empty($search)) {
            $users = User::orderby('fullname', 'asc')->select('id', 'fullname', 'phone', 'gender')->where('fullname', 'like', '%' . $search . '%')->whereNull('department_id')->limit(5)->get();
        }

        $response = array();
        foreach ($users as $user) {
            $response[] = array("value" => $user->id, "label" => $user->fullname, 'phone' => $user->phone, 'gender' => $user->gender);
        }

        return response()->json($response);
    }

    public function user(Request $request)
    {
        $department = Department::with('users')->where('id', $request->id)->limit(1)->get();
        // if(Auth::user() -> level > 3 || $department[0] -> id == Auth::user() -> department_id){
        //     $positions = Position::with('nominees')->get();
        //     return view('auth.department.user.index', compact('department', 'positions'));
        // }else{
        //     abort(403, "Bạn Không Được Phép Sửa Phòng Ban Này");
        // }
        $positions = Position::with('nominees')->get();
        return view('auth.department.user.index', compact('department', 'positions'));
    }

    public function addUser(Request $request)
    {
        if ($request->id) {
            $user = User::find($request->id);
            $user->department_id = $request->department_id;
            $user->position_id = 10;
            $user->nominee_id = 57;

            $user->nominee = nominee::find(57)->nominees;

            if ($user->save()) {
                return response()->json(['status' => 1, 'msg' => 'Thêm thành công']);
            } else {
                return response()->json(['status' => 0, 'msg' => 'Thêm thất bại']);
            }
        } else {
            return response()->json(['status' => 0, 'msg' => 'Thêm thất bại']);
        }
    }

    public function deleteUser(Request $request)
    {
        if ($request->id) {
            $user = User::findOrFail($request->id);
            if ($user) {
                $user->department_id = NULL;
                $user->save();
                return response()->json(['status' => 1, 'msg' => 'Xóa thành công']);
            } else {
                return response()->json(['status' => 0, 'msg' => 'Xóa thất bại']);
            }
        } else {
            return response()->json(['status' => 0, 'msg' => 'Xóa thất bại']);
        }
    }
    public function updateUser(Request $request)
    {
        if ($request->id) {
            $user = User::find($request->id);
            $user->position_id = $request->position_id;
            $user->nominee_id = $request->nominee_id;
            $user->nominee = nominee::find($request->nominee_id)->nominees;
            if ($user->save()) {
                return response()->json(['status' => 1, 'msg' => 'Sửa thành công']);
            } else {
                return response()->json(['status' => 0, 'msg' => 'Sửa thất bại']);
            }
        } else {
            return response()->json(['status' => 0, 'msg' => 'Sửa thất bại']);
        }
    }

    public function get_users(Request $request)
    {
        if ($request->id) {
            $positions = Position::with('nominees')->get();
            $users = User::with('position')->where('department_id', $request->id)->get();
            return view('auth.department.user.data', compact('users', 'positions'));
        }
    }

    public function display($id)
    {
        $department = Department::find($id);
        return response()->json($department);
    }

    public function filter(Request $request)
    {
        $status = $request->status ?? '';
        $per_page = $request->per_page ?? 5;
        $name = $request->name ?? '';
        $datetime = $request->datetime ?? date('Y-m-d H:i:s');

        $departments = Department::where([
            ['status', 'like', '%' . $status . '%'],
            ['name', 'like', '%' . $name . '%']
        ])->whereDate('created_at', '<=', $datetime)->orderby('id', 'desc')->paginate($per_page);
        return view('auth.department.data', compact('departments'));
    }

    public function delete(Request $request)
    {
        $department = Department::findOrFail($request->id);
        if ($department) {
            $department->delete();
            return response()->json(['status' => 1, 'msg' => 'Xóa thành công']);
        }
    }

    public function overview()
    {
        $departments = Department::with("users")->get()->toTree();
        return view('auth.department.overview', compact('departments'));
    }

    public function get_departments()
    {
        $departments = Department::paginate(5);
        return view('auth.department.data', compact('departments'));
    }
}
