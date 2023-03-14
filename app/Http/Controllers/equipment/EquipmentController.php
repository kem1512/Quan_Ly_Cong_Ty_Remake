<?php

namespace App\Http\Controllers\equipment;

use App\Http\Controllers\Controller;
use App\Http\Requests\InsertEquipmentRequest;
use App\Http\Requests\InsertEquipmentTypesRequest;
use App\Models\Equipment;
use App\Models\EquipmentDetail;
use App\Models\EquipmentType;
use App\Models\Supplier;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{


    public function index(Request $request)
    {
        $equiment = Equipment::first();
        if ($request->ajax()) {
            $equipments = Equipment::paginate(config('const.EQUIPMENT.PAGE_SIZE_EQUIPMENT'));
            $build = Equipment::biuld_equipment($equipments);
            $equipment_detail = EquipmentDetail::paginate(config('const.EQUIPMENT.PAGE_SIZE_EQUIPMENT_DETAIL'));
            $equipment_build = EquipmentDetail::build_equipment_detail($equipment_detail, $equipments[0]);
            return  response()->json(['status' => 'success', 'location' => 'build_equipment', 'body' => $build]);
        }
        $equipments = Equipment::getAll_Equipment_AND_TYPE();
        $equipment_detail = EquipmentDetail::get_equipment_detail_by_equipment($equiment->id);
        $equipment_detail->setPath('equiment_detail/paginate');
        return view('pages.Equiments.equipment', compact('equipments', 'equipment_detail', 'equiment'));
    }
    public function get_equipment_detail_by_equipment(Request $request)
    {
        $equipment = Equipment::find($request->id);
        $equipment_details = EquipmentDetail::get_equipment_detail_by_equipment($request->id);
        $equipment_details->setPath('equiment_detail/paginate');
        $build = EquipmentDetail::build_equipment_detail($equipment_details, $equipment);
        return  response()->json(['status' => 'success', 'body' => $build]);
    }
    public function get_all_equipment_paginate(Request $request)
    {
        $equipment = Equipment::find($request->id);
        $equipment_details = EquipmentDetail::get_equipment_detail_by_equipment($request->id);
        $equipment_details->setPath('equiment_detail/paginate');
        $build = EquipmentDetail::build_equipment_detail($equipment_details, $equipment);
        return  response()->json(['status' => 'success', 'location' => 'equipment_detail', 'body' => $build]);
    }
    public function get_all_equipment_type()
    {
        $build = EquipmentType::all();
        return  response()->json(['status' => 'success', 'equipment_types' => $build]);
    }
    public function get_all_equipment_supplier()
    {
        $build = Supplier::all();
        return  response()->json(['status' => 'success', 'suppliers' => $build]);
    }
    public function insert_emquipment_types(InsertEquipmentTypesRequest $request)
    {

        if (empty($request->id)) {
            $types = new EquipmentType();
            $request->validate([
                'equipment_type_code_insert' => 'unique:equipment_types,code'
            ], [
                'equipment_type_code_insert.unique' => 'Mã thể loại đã tồn tại !',
            ]);
        } else {
            $types = EquipmentType::find($request->id);
            if ($request->equipment_type_code_insert !== $types->code) {
                $request->validate([
                    'equipment_type_code_insert' => 'unique:equipment_types,code'
                ], [
                    'equipment_type_code_insert.unique' => 'Mã thể loại đã tồn tại !',
                ]);
            }
        }
        $types->name = $request->equipment_type;
        $types->code = strtoupper($request->equipment_type_code_insert);
        $types->accessory = $request->accessory == "false" ? 0 : 1;
        $types->save();
        return  response()->json(['status' => 'success']);
    }
    public function get_equipment_type_by_id(Request $request)
    {
        $type = EquipmentType::find($request->id);
        return response()->json(['status' => 'success', 'equipment_type' => $type]);
    }
    public function delete_equipment_type_by_id(Request $request)
    {
        $type = EquipmentType::find($request->id);
        $type->delete();
        return response()->json(['status' => 'success', 'message' => "Xóa Thành Công !"]);
    }
    public function insert_equipment(InsertEquipmentRequest $request)
    {
        // dd($request);
        if ($request->equipment_quantity < 1) {
            return  response()->json(['status' => 'error', 'message' => 'Số lượng thiết bị quá nhỏ !']);
        }
        $equipment = new Equipment();
        //set code equipment
        $max = Equipment::orderBy('id', 'DESC')->first();
        if (strlen($max->id) < 2) {
            $equipment->code = 'SKU00000' . $max->id + 1;
        } else if (strlen($max->id) < 3) {
            $equipment->code = 'SKU0000' . $max->id + 1;
        } else if (strlen($max->id) < 4) {
            $equipment->code = 'SKU000' . $max->id + 1;
        } else if (strlen($max->id) < 5) {
            $equipment->code = 'SKU00' . $max->id + 1;
        } else if (strlen($max->id) < 6) {
            $equipment->code = 'SKU0' . $max->id + 1;
        } else if (strlen($max->id) < 7) {
            $equipment->code = 'SKU' . $max->id + 1;
        }
        $equipment->id_type = $request->equipment_type;
        $equipment->name = $request->equipment_name;
        $equipment->save();

        $eq = Equipment::where('equipment.code', $equipment->code)
            ->leftjoin('equipment_types', 'equipment.id_type', 'equipment_types.id')
            ->select('equipment.*', 'equipment_types.code as equipment_type_code')->get();

        $max_for = (int) $request->equipment_quantity;

        for ($i = 0; $i <= $max_for; $i++) {
            $eq_detail = new EquipmentDetail();
            $eq_detail->id_equipment = $eq[0]->id;
            $eq_detail->supplier_id = $request->equipment_supplier;
            $eq_detail->warranty_expiration_date = $request->equipment_warranty_expiration_date;
            $eq_detail->specifications = $request->equipment_specifications;
            $eq_detail->note = $request->equipment_note;
            $eq_detail->date_added = $request->equipment_date_added;
            $max_detail = EquipmentDetail::orderBy('id', 'DESC')->first();

            if (strlen($max_detail->id) < 2) {
                $eq_detail->equipment_code = $eq[0]->equipment_type_code . '00000' . $max_detail->id;
            } else if (strlen($max_detail->id) < 3) {
                $eq_detail->equipment_code = $eq[0]->equipment_type_code . '0000' . $max_detail->id;
            } else if (strlen($max_detail->id) < 4) {
                $eq_detail->equipment_code = $eq[0]->equipment_type_code . '000' . $max_detail->id;
            } else if (strlen($max_detail->id) < 5) {
                $eq_detail->equipment_code = $eq[0]->equipment_type_code . '00' . $max_detail->id;
            } else if (strlen($max_detail->id) < 6) {
                $eq_detail->equipment_code = $eq[0]->equipment_type_code . '0' . $max_detail->id;
            } else if (strlen($max_detail->id) < 7) {
                $eq_detail->equipment_code = $eq[0]->equipment_type_code . '' . $max_detail->id;
            }

            $eq_detail->save();
        }

        return  response()->json(['status' => 'success', 'message' => 'Thêm Mới Thiết Bị Mới Thành Công !']);
    }
}
