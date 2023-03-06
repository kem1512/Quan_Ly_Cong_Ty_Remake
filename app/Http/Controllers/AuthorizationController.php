<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthoInsertRequest;
use App\Models\Authority;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;


class AuthorizationController extends Controller
{
    function index(Request $request)
    {
        if ($request->ajax()) {
            $body = Authority::paginate(7);
            return response()->json(['status' => 'success', 'body' => $body]);
        }
        $authos = Authority::paginate(7);
        return view('pages.authorization', compact('authos'));
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
        ];
        $autho->personnel = json_encode($personnel);
        $autho->departments = 'null';
        $autho->equipment = 'null';
        $autho->save();
        $body = Authority::paginate(7);
        return response()->json(['status' => 'success', 'body' => $body]);
    }
    public function getAutho_Detail_By_Id(Request $request)
    {
        $body = Authority::find($request->id);
        $body->personnel = json_decode($body->personnel);
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
