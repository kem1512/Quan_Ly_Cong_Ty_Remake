<?php

namespace App\Http\Controllers;

use App\Models\equiment;
use App\Models\EquimentImport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Illuminate\Pagination\Paginator;
use Maatwebsite\Excel\Facades\Excel;

class EquimentsController extends Controller
{
    function Index()
    {
        $list_loai = DB::table('equipment_types')->get();
        $list_nha_cung_cap = DB::table('suppliers')->get();
        return view('pages.Equiments.Equiment.equiment', compact('list_loai', 'list_nha_cung_cap'));
    }

    public function Get($perpage, $curentpage, $status = null, $keyword = null)
    {
        $equiment_types = DB::table('equipment_types')
            ->select(['id', 'name'])
            ->get()
            ->toArray();
        $newtable = array();
        if ($keyword == null) {
            foreach ($equiment_types as $value) {

<<<<<<< Updated upstream
                $result = DB::table('equipments')
                    ->select(['id', 'image', 'name', 'status'])
                    ->where('equipment_type_id', '=', $value->id)
=======
        if ($keyword != null || $status != null) {
            foreach ($equimens as $value) {
                $result = DB::table('use_details as ud')
                    ->join('equipments as e', 'e.id', '=', 'ud.equipment_id')
                    ->leftJoin('users as u', 'u.id', '=', 'ud.user_id')
                    ->join('departments as de', 'de.id', '=', 'u.department_id')
                    ->select(['e.image', 'de.name as namedepartment', 'u.fullname as nameusser', 'e.status', 'ud.amount'])
                    ->where('e.id', $value->id)
                    ->where('e.status', $status)
>>>>>>> Stashed changes
                    ->get()
                    ->toArray();

                $list_equiment = $this->paginate($result, $perpage, $curentpage);

                if (count($list_equiment) != 0) {
                    $newtable['' . $value->name . ''] = $list_equiment;
                }

            }
        } else {
<<<<<<< Updated upstream
            foreach ($equiment_types as $value) {

                $result = DB::table('equipments')
                    ->select(['id', 'image', 'name', 'status'])
                    ->where([
                        ['equipment_type_id', '=', $value->id],
                        ['status', $keyword],
                    ])
=======
            foreach ($equimens as $value) {
                $result = DB::table('use_details as ud')
                    ->join('equipments as e', 'e.id', '=', 'ud.equipment_id')
                    ->leftJoin('users as u', 'u.id', '=', 'ud.user_id')
                    ->leftJoin('departments as de', 'de.id', '=', 'u.department_id')
                    ->select(['e.image', 'de.name as namedepartment', 'u.fullname as nameusser', 'e.status', 'ud.amount'])
                    ->where('e.id', $value->id)
>>>>>>> Stashed changes
                    ->get()
                    ->toArray();


                $list_equiment = $this->paginate($result, $perpage, $curentpage);

                if (count($list_equiment) != 0) {
                    $newtable['' . $value->name . ''] = $list_equiment;
                }

            }
        }
<<<<<<< Updated upstream
=======



>>>>>>> Stashed changes
        return $newtable;
    }

    function paginate($item, $perpage, $page)
    {
        $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $total = count($item);
        $curentpage = $page;
        $offset = ($curentpage * $perpage) - $perpage;
        $itemtoshow = array_slice($item, $offset, $perpage);
        return new \Illuminate\Pagination\LengthAwarePaginator($itemtoshow, $total, $perpage);
    }

    function Create(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'min:6'],
                'specifications' => ['required', 'min:6'],
                'price' => ['required', 'regex:/^[0-9]+$/'],
                'warranty_date' => ['date'],
                'out_of_date' => ['date'],
            ],
            [
                'name.required' => "Tên thiết bị không được để trống!",
                'name.min' => "Tên thiết bị phải lớn hơn 6 kí tự!",
                'specifications.required' => "Thông số thiết bị không được để trống!",
                'specifications.min' => "Thông số thiết bị phải lớn hơn 6 kí tự!",
                'price.required' => "Giá nhập không được để trống!",
                'price.regex' => "Giá nhập phải là số!",
                'warranty_date.date' => "Ngày không hợp lệ!",
                'out_of_date.date' => "Ngày không hợp lệ!",
            ]
        );

        if ($request->has('image')) {
            $file = $request->image;
            $file_name = $file->getClientOriginalName();
            $file->move(public_path('uploads'), $file_name);
        } else {
            $file_name = "";
        }

        $name = $request->name;
        $image = $file_name;
        $specifications = $request->specifications;
        $supplier_id = $request->supplier_id;
        $price = $request->price;
        $warranty_date = $request->warranty_date;
        $out_of_date = $request->out_of_date;
        $created = Carbon::Now();
        $updated = Carbon::Now();


        $equiment = new equiment;
        $equiment->name = $name;
        $equiment->image = $image;
        $equiment->specifications = $specifications;
        $equiment->supplier_id = $supplier_id;
        $equiment->price = $price;
        $equiment->warranty_date = $warranty_date;
        $equiment->out_of_date = $out_of_date;
        $equiment->created_at = $created;
        $equiment->updated_at = $updated;
        $equiment->save();
        $equiment->id;

        return response()->json([
            'equiment' => $equiment,
        ], 200);
    }

    function Delete($id)
    {
        $equipment = DB::table('equipments')->delete($id);
        $equipment == 0 ? $message = "Thất bại" : $message = "Thành công";
        return response()->json(
            [
                'message' => $message,
            ],
            200
        );
    }

    function GetById($id)
    {
        $equipment = DB::table('equipments')->find($id);
        return response()->json(
            [
                'equipment' => $equipment,
            ],
            200
        );
    }

    function Update($id, Request $request)
    {

        $request->validate(
            [
                'name' => ['required', 'min:6'],
                'specifications' => ['required', 'min:6'],
                'price' => ['required', 'regex:/^[0-9]+$/'],
                'warranty_date' => ['date'],
                'out_of_date' => ['date'],
            ],
            [
                'name.required' => "Tên thiết bị không được để trống!",
                'name.min' => "Tên thiết bị phải lớn hơn 6 kí tự!",
                'specifications.required' => "Thông số thiết bị không được để trống!",
                'specifications.min' => "Thông số thiết bị phải lớn hơn 6 kí tự!",
                'price.required' => "Giá nhập không được để trống!",
                'price.regex' => "Giá nhập phải là số!",
                'warranty_date.date' => "Ngày không hợp lệ!",
                'out_of_date.date' => "Ngày không hợp lệ!",
            ]
        );

        if ($request->has('image')) {
            $file = $request->image;
            $file_name = $file->getClientOriginalName();
            $file->move(public_path('uploads'), $file_name);
        } else {
            $file_name = "";
        }

        $name = $request->name;
        $image = $file_name;
        $specifications = $request->specifications;
        $supplier_id = $request->supplier_id;
        $price = $request->price;
        $warranty_date = $request->warranty_date;
        $out_of_date = $request->out_of_date;
        $created = Carbon::Now();
        $updated = Carbon::Now();

        $result = DB::table('equipments')
            ->where('id', $id)
            ->update([
                'name' => $name,
                'image' => $image,
                'specifications' => $specifications,
                'price' => $price,
                'warranty_date' => $warranty_date,
                'out_of_date' => $out_of_date,
                'supplier_id' => $supplier_id,
                'equipment_type_id' => $request->equiment_type_id,
                'created_at' => $created,
                'updated_at' => $updated,
            ]);

        $message = $result == 0 ? "Thất bại" : "Thành công";

        return response()->json([
            'message' => $message,
        ], 200);
    }
}