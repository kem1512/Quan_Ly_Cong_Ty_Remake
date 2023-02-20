<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FormDataRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\Department;
use Illuminate\Support\Collection;
use App\Models\User;
use Illuminate\Http\Request;
use  Carbon\Carbon;

class DepartmentController extends Controller
{
    public function index(){
        return view('auth.department.form');
    }

    public function createOrUpdate(FormDataRequest $request){    
        if(!$request -> validated())
        {
            return response()->json(['status' => 0,'msg' => $request->errors()]);
        }else{
            $department_parent = Department::find($request -> id_department_parent);

            if($request -> id){
                $department = Department::find($request -> id);
            }else{
                $department = new Department;
            }

            $department -> code = $request -> code;
            $department -> name = $request -> name;
            $department -> status = $request -> status == 'on' ? 1 : 0;
        
            if($request -> id_department_parent){
                $department->appendToNode($department_parent)->save();
                return response()->json(['status' => 1,'msg' => 'Cập nhật thành công']);
            }else{
                // #1 Implicit save
                $department->saveAsRoot();

                // #2 Explicit save
                $department->makeRoot()->save();

                return response()->json(['status' => 1,'msg' => 'Thêm mới thành công']);
            }
            return response()->json(['status' => 0,'msg' => 'Thao tác thất bại']);
        }
    }

    public function search(Request $request) {
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

    public function searchUsers(Request $request){
        $search = $request->search;

		if (!empty($search)) {
            $users = User::orderby('fullname', 'asc')->select('id', 'fullname', 'phone', 'gender')->where('fullname', 'like', '%' . $search . '%')->limit(5)->get();
		}

		$response = array();
		foreach ($users as $user) {
			$response[] = array("value" => $user->id, "label" => $user->fullname, 'phone' => $user -> phone, 'gender' => $user -> gender);
		}

		return response()->json($response);
    }

    public function user(Request $request){
        $department = Department::with('users')->where('id', $request -> id)->limit(1)->get();
        return view('auth.department.user', compact('department'));
    }

    public function addUserToDepartment(Request $request){
        foreach($request->input('users') as $user){
            $result = User::find($user);
            $result -> department_id = $request -> department_id;
            $result -> save();
        }
    }

    public function getEmployeeInDepartment(Request $request){
        if($request -> id){
            $users = User::where('department_id', $request -> id)->get();
            if($users -> count() > 0)
                return response()->json(['status' => 0, 'msg' => 'Lấy Dữ Liệu Thành Công', 'data' => $users]);
        }
        return response()->json(['status' => 0, 'msg' => 'Lấy Dữ Liệu Thất Bại']);
    }

    public function display($id)
    {
        $department = Department::find($id);
        return response() -> json($department);
    }

    public function filter(Request $request){
        $status = $request -> status ?? '';
        $per_page = $request -> per_page ?? 5;
        $name = $request -> name ?? '';
        $datetime = $request -> datetime ?? date('Y-m-d H:i:s');

        $departments = Department::with('department_childs')->where([
            ['status', 'like', '%' . $status . '%'],
            ['name', 'like', '%' . $name . '%']
        ])->whereDate('created_at', '<=', $datetime)->orderby('id', 'desc')->paginate($per_page);
        return view('auth.department.data', compact('departments'));
    }

    public function delete(Request $request)
    {
        $department = Department::findOrFail($request -> id);
        if($department){
            $department->delete();
            return response()->json(['status' => 1, 'msg' => 'Xóa thành công']);
        }
    }

    public function overview(){
        $departments = Department::with('department_childs')->orderby('id', 'asc')->where('id_department_parent', 1)->get();
        return view('auth.department.overview', compact('departments'));
    }

    public function getDepartment(){
        $departments = Department::paginate(5);
        return view('auth.department.data', compact('departments'));
    }

    public function test(){
        $departments = Department::with('ancestors')->get()->toTree();

        $traverse = function ($departments, $prefix = '-') use (&$traverse) {
            foreach ($departments as $department) {
                echo '<br>'.$prefix.' '.$department->name;
        
                $traverse($department->children, $prefix.'-');
            }
        };
        $traverse($departments);
    }
}
