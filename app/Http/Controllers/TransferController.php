<?php

namespace App\Http\Controllers;

use App\Models\storehouse;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

class TransferController extends Controller
{
    public function Index()
    {
        $user = Auth::user();
        $this->authorize('update', $user);
        $storehouse = storehouse::all();
        return view('pages.Equiments.Transfer.transfer', compact('user', 'storehouse'));
    }

    public function GetNhanSu($id = null)
    {
        $user = Auth::user();
        $users = DB::table('users')->select(['img_url', 'id', 'fullname'])->where([['id', '<>', $id], ['id', '<>', $user->id]])->get();

        return response()->json([
            'users' => $users,
        ]);
    }

    public function GetStoreHouse($keyword = null)
    {
        if ($keyword == null) {
            $equipment_storehouse = DB::table('storehouse_details as td')
                ->join('equipments as e', 'e.id', '=', 'td.equipment_id')
                ->join('storehouses as sh', 'sh.id', '=', 'td.storehouse_id')
                ->select(['e.name', 'e.image', 'td.amount'])
                ->get();
        } else {
            $equipment_storehouse = DB::table('storehouse_details as td')
                ->join('equipments as e', 'e.id', '=', 'td.equipment_id')
                ->join('storehouses as sh', 'sh.id', '=', 'td.storehouse_id')
                ->select(['e.name', 'e.image', 'td.amount'])
                ->where('sh.id', $keyword)
                ->get();
        }

        return response()->json([
            'equipment' => $equipment_storehouse,
        ]);
    }

    public function GetUseDetail($id = null)
    {
        $usedetail = DB::table('use_details as ud')
            ->join('equipments as e', 'e.id', '=', 'ud.equipment_id')
            ->join('users as u', 'u.id', '=', 'ud.user_id')
            ->select(['u.id', 'u.fullname', 'u.img_url', 'e.name', 'e.image', 'ud.amount'])
            ->where('u.id', $id)
            ->get();

        return response()->json([
            'usedetails' => $usedetail,
        ]);
    }

    public function UpdateAmount(Request $request)
    {
        $result = DB::table('storehouse_details')
            ->where('id', $request->id)
            ->update(['amount' => $request->amount]);

        return response()->json([
            'result' => $result,
        ]);
    }
}