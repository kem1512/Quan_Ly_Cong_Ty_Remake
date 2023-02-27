<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class EquipmentsController extends Controller
{
    public function Index($id = null)
    {
        return view('pages.Equiments.Equipment.equipment');
    }

    public function GetEquipment($id)
    {
        $equipments = DB::table('storehouse_details as sd')
            ->join('equipments as e', 'e.id', '=', 'sd.equipment_id')
            ->join('storehouses as s', 's.id', '=', 'sd.storehouse_id')
            ->where('s.id', $id)
            ->get();

        return $equipments;
    }
}