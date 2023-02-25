<?php

namespace App\Http\Controllers;

use App\Models\storehouse;
use App\Models\storehouse_detail;
use App\Models\transfer;
use App\Models\transfer_detail;
use App\Models\use_detail;

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
                ->select(['td.id as id_storehouse_detail', 'e.id', 'e.name', 'e.image', 'td.amount'])
                ->get();
        } else {
            $equipment_storehouse = DB::table('storehouse_details as td')
                ->join('equipments as e', 'e.id', '=', 'td.equipment_id')
                ->join('storehouses as sh', 'sh.id', '=', 'td.storehouse_id')
                ->select(['td.id as id_storehouse_detail', 'e.id', 'e.name', 'e.image', 'td.amount'])
                ->where('td.id', $keyword)
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

    public function GetEquimentById($id = null)
    {
        $equipment = DB::table('storehouse_details as td')
            ->join('equipments as e', 'e.id', '=', 'td.equipment_id')
            ->join('storehouses as sh', 'sh.id', '=', 'td.storehouse_id')
            ->select(['td.id as id_storehousedetail', 'e.id', 'e.name', 'e.image', 'td.amount'])
            ->where('td.id', $id)
            ->get();

        return response()->json([
            'equipment' => $equipment,
        ]);
    }

    public function CreateTransfer(Request $request)
    {
        $user_transfer_id = $request->user_transfer_id;
        $user_receive_id = $request->user_receive_id;
        $performer_id = $request->performer_id;
        $transfer_type = $request->transfer_type;
        $transfer_detail = $request->transfer_detail;

        $transfer = new transfer();
        $transfer->user_transfer_id = $user_transfer_id;
        $transfer->user_receive_id = $user_receive_id;
        $transfer->performer_id = $performer_id;
        $transfer->transfer_type = $transfer_type;
        $transfer->transfer_detail = $transfer_detail;
        $transfer->save();

        return response()->json([
            'transfer' => $transfer,
        ]);
    }

    public function CreateTransferDetail(Request $request)
    {
        $equipment_id = $request->equipment_id;
        $transfer_id = $request->transfer_id;
        $amount = $request->amount;

        $transfer_detail = new transfer_detail();
        $transfer_detail->equipment_id = $equipment_id;
        $transfer_detail->transfer_id = $transfer_id;
        $transfer_detail->amount = $amount;
        $transfer_detail->save();

        return response()->json([
            'transfer_detail' => $transfer_detail,
        ]);
    }

    public function UpdateAmountStoreHouse($id_storehouse_detail = null, $amountchoose = null)
    {
        $storehouse_detail = storehouse_detail::find($id_storehouse_detail);
        $amount_storeHouse = $storehouse_detail->amount;
        $amountchange = $amount_storeHouse - $amountchoose;

        if ($amountchange == 0) {
            $storehouse_detail->delete();
        } else {
            $storehouse_detail->amount = $amountchange;
            $storehouse_detail->save();
        }

        return response()->json([
            'storehouse_detail' => $storehouse_detail,
        ]);
    }

    public function AddOrUpdateUseDetail(Request $request)
    {
        $equipment_id = $request->equipment_id;
        $user_id = $request->user_id;
        $amount = $request->amount;

        $usedetail = use_detail::get()
            ->where('equipment_id', $equipment_id)
            ->where('user_id', $user_id)
            ->toArray();

        if (count($usedetail) == 0) {
            $usedetail = new use_detail();
            $usedetail->equipment_id = $equipment_id;
            $usedetail->user_id = $user_id;
            $usedetail->amount = $amount;
            $usedetail->save();

            return response()->json(['usedetail' => $usedetail]);
        } else {
            $usedetail = DB::table('use_details')
                ->where('equipment_id', $equipment_id)
                ->where('user_id', $user_id)
                ->update(['amount' => $amount]);

            return response()->json(['usedetail' => $usedetail]);
        }
    }
}