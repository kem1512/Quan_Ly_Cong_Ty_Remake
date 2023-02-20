<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

class TransferController extends Controller
{
    public function GetNhanSu($id = null)
    {
        $user = Auth::user();
        $users = DB::table('users')->select(['img_url', 'id', 'fullname'])->where([['id', '<>', $id], ['id', '<>', $user->id]])->get();

        return response()->json([
            'users' => $users,
        ]);
    }
}