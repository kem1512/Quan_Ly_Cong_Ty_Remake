<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthoInsertRequest;
use App\Models\Authority;
use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorizationController extends Controller
{

    function index(Request $request)
    {
        $this->authorize("authentication", Auth::user());

        if ($request->ajax()) {
            $body = Authority::paginate(7);
            $user = User::build_autho();
            $use = User::Autho_Build($user);
            $count = count($user);
            return response()->json(['status' => 'success', 'body' => $body, 'location' => 'auth', 'count' => $count, 'table_user' => $use]);
        }
        $authos = Authority::paginate(7);
        $authority = Authority::all();
        $users = User::build_autho();
        $departments = Department::all();
        return view('pages.authorization', compact('authos', 'departments', 'authority', 'users'));
    }
    function set_role_user(Request $request)
    {
        $user = User::find($request->id_user);
        if ($request->checked === 'true') {
            $user->autho = $request->id_auth;
            $mes = 'Cấp quyền thành công !';
        } else {
            $a = null;
            $user->autho = $a;
            $mes = 'Thu hồi quyền thành công !';
        }
        $user->save();
        return response()->json(['status' => 'success', 'message' => $mes]);
    }
    function get_user_by_department(Request $request)
    {
        if ($request->id == 0) {
            $users = User::build_autho();
        } else {
            $users = User::build_autho_by_department($request->id);
        }
        $data = User::Autho_Build($users);
        return response()->json(['status' => 'success', 'location' => 'auth', 'table_user' => $data]);
    }
    function set_autho_for_user(Request $request)
    {
        foreach ($request->arr_user as $item) {
            $users = User::find($item);
            $users->autho = $request->id_autho;
            $users->save();
        }
        return  response()->json(['status' => 'success', 'message' => 'Cấp quyền thành công !']);
    }
    function save(AuthoInsertRequest $request)
    {
        if (empty($request->id)) {
            $autho = new Authority();
            $request->validate([
                'autho_name' => 'unique:authorities,name_autho'
            ], [
                'autho_name.unique' => 'Tên nhóm quyền đã tồn tại !'
            ]);
        } else {
            $autho = Authority::find($request->id);
            if ($request->autho_name !== $autho->name_autho) {
                $request->validate([
                    'autho_name' => 'unique:authorities,name_autho'
                ], [
                    'autho_name.unique' => 'Tên nhóm quyền đã tồn tại !'
                ]);
            }
        }
        $autho->name_autho = $request->autho_name;

        if (
            $request->accept_cv_autho == "true" ||
            $request->delete_personnel == "true" ||
            $request->eva_cv_autho == "true" ||
            $request->inter_cv_autho == "true" ||
            $request->offer_cv_autho == "true" ||
            $request->update_cv_autho == "true" ||
            $request->insert_personnel == "true" ||
            $request->faild_inter_autho == "true" ||
            $request->faild_cv_autho == "true" ||
            $request->update_personnel == "true"
        ) {
            $personnel = [
                'personnel_autho_access' => "true",
                'insert_personnel' => $request->insert_personnel,
                'update_personnel' => $request->update_personnel,
                'delete_personnel' => $request->delete_personnel,
                'accept_cv_autho' => $request->accept_cv_autho,
                'update_cv_autho' => $request->update_cv_autho,
                'inter_cv_autho' => $request->inter_cv_autho,
                'eva_cv_autho' => $request->eva_cv_autho,
                'offer_cv_autho' => $request->offer_cv_autho,
                'faild_cv_autho' => $request->faild_cv_autho,
            ];
        } else {
            $personnel = [
                'personnel_autho_access' => $request->personnel_autho_access,
                'insert_personnel' => $request->insert_personnel,
                'update_personnel' => $request->update_personnel,
                'delete_personnel' => $request->delete_personnel,
                'accept_cv_autho' => $request->accept_cv_autho,
                'update_cv_autho' => $request->update_cv_autho,
                'inter_cv_autho' => $request->inter_cv_autho,
                'eva_cv_autho' => $request->eva_cv_autho,
                'offer_cv_autho' => $request->offer_cv_autho,
                'faild_cv_autho' => $request->faild_cv_autho,
            ];
        }

        $autho->authority = json_encode($request->authority);
        $autho->personnel = json_encode($personnel);
        $autho->departments = 'null';
        $autho->equipment = 'null';
        $autho->save();
        return response()->json(['status' => 'success']);
    }
    public function getAutho_Detail_By_Id(Request $request)
    {
        $body = Authority::find($request->id);
        $body->personnel = json_decode($body->personnel);
        $body->authority = json_decode($body->authority);
        return response()->json(['status' => 'success', 'body' => $body]);
    }
    public function delete(Request $request)
    {
        $user = User::where('autho', $request->id)->get();
        if (count($user) !== 0) {
            return response()->json(['status' => 'error', 'message' => 'Có nhân sự đang sử dụng quyền này !']);
        }
        $body = Authority::find($request->id);
        $body->delete();
        return response()->json(['status' => 'success', 'body' => $body]);
    }
}
