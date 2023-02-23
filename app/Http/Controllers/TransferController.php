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

    public function GetStoreHouse($id_storehouse = null)
    {
        if ($id_storehouse == null) {
            $equipment_storehouse = DB::table('storehouse_details as td')
                ->join('equipments as e', 'e.id', '=', 'td.equipment_id')
                ->join('storehouses as sh', 'sh.id', '=', 'td.storehouse_id')
                ->select(['sh.name as name_storehouse', 'e.name as name_equipment', 'e.image', 'td.amount'])
                ->get();
        } else {
            $equipment_storehouse = DB::table('storehouse_details as td')
                ->join('equipments as e', 'e.id', '=', 'td.equipment_id')
                ->join('storehouses as sh', 'sh.id', '=', 'td.storehouse_id')
                ->select(['e.name', 'e.image', 'td.amount'])
                ->where('sh.id', $id_storehouse)
                ->get();
        }

        return response()->json([
            'equipment' => $equipment_storehouse,
        ]);
    }
}