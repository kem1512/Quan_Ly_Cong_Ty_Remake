<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;

class WareHousesController extends Controller
{
    public function Get($perpage, $orderby, $keyword = null)
    {
        if ($keyword == null) {
            $list = DB::table('storehouses')
                ->orderBy('created_at', $orderby)
                ->paginate($perpage);
            return response()->json(
                ['warehouses' => $list],
                200
            );
        }

        $list = DB::table('storehouses')
            ->where('name', 'like', '%' . $keyword . '%')
            ->orWhere('address', 'like', '%' . $keyword . '%')
            ->orderBy('created_at', $orderby)
            ->paginate($perpage);

        return response()->json(
            ['warehouses' => $list],
            200
        );
    }

    public function Delete($id)
    {
        $mesage = "";
        $check = DB::table('storehouse_details')->where('storehouse_id', '=', $id)->get();
        if ($check->count() > 0) {
            $mesage = "Không thể xóa";
        } else {
            $result = DB::table('storehouses')->where('id', '=', $id)->delete();
            if ($result == 0) {
                $mesage = "Thất bại";
            } else {
                $mesage = "Thành công";
            }
        }

        return response()->json([
            'message' => $mesage,
        ], 200);
    }

    public function GetById($id)
    {
        $result = DB::table('storehouses')->find($id);

        return response()->json([
            'warehouse' => $result,
        ], 200);
    }

    public function Create(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'min:6'],
                'address' => ['required', 'min:6'],
            ],
            [
                'name.required' => "Tên kho không được để trống!",
                'name.min' => "Tên kho phải lớn hơn 6 kí tự!",
                'address.required' => "Địa chỉ không được để trống!",
                'address.min' => "Địa chỉ phải lớn hơn 6 kí tự!",
            ]
        );

        if ($request->has('image')) {
            $file = $request->image;
            $file_name = $file->getClientOriginalName();
            $file->move(public_path('uploads'), $file_name);
        }

        $name = $request->name;
        $address = $request->address;
        $image = "uploads/" . $file_name;
        $status = $request->status == 'on' ? 1 : 0;

        $result = DB::table('storehouses')->insert([
            'name' => $name,
            'address' => $address,
            'image' => $image,
            'status' => $status,
        ]);

        $message = $result == 0 ? "Không thành công" : "Thành công";

        return response()->json([
            'message' => $message,
        ], 200);
    }

    public function Update($id, Request $request)
    {
        $image_old = DB::table('storehouses')->where('id', $id)->select(['image'])->get();

        $request->validate(
            [
                'name' => ['required', 'min:6'],
                'address' => ['required', 'min:6'],
            ],
            [
                'name.required' => "Tên kho không được để trống!",
                'name.min' => "Tên kho phải lớn hơn 6 kí tự!",
                'address.required' => "Địa chỉ không được để trống!",
                'address.min' => "Địa chỉ phải lớn hơn 6 kí tự!",
            ]
        );

        $file_name = "";

        if ($request->has('image')) {
            $file = $request->image;
            $file_name = $file->getClientOriginalName();
            $file->move(public_path('uploads'), $file_name);
        } else {
            $file_name = str_replace('uploads/', '', $image_old[0]->image);
        }

        $name = $request->name;
        $address = $request->address;
        $image = "uploads/" . $file_name;
        $status = $request->status == 'on' ? 1 : 0;

        $result = DB::table('storehouses')
            ->where('id', $id)
            ->update([
                'name' => $name,
                'address' => $address,
                'image' => $image,
                'status' => $status,
            ]);


        $message = $result == 0 ? "Không thành công" : "Thành công";

        return response()->json([
            'message' => $message,
        ], 200);
    }

    public function GetEquiments($perpage, $curentpage, $id, $keyword = null)
    {
        $equiment_types = DB::table('equipment_types')
            ->select(['id', 'name'])
            ->get()
            ->toArray();

        $newtable = array();

        foreach ($equiment_types as $value) {
            $result = DB::table('storehouse_details as sd')
                ->join('equipments as e', 'e.id', '=', 'sd.equipment_id')
                ->select(['e.name', 'e.image'])
                ->where([
                    ['e.equipment_type_id', '=', $value->id],
                    ['sd.storehouse_id', $id],
                ])
                ->get()
                ->toArray();

            $list_equiment = $this->paginate($result, $perpage, $curentpage);

            if (count($list_equiment) != 0) {
                $newtable['' . $value->name . ''] = $list_equiment;
            }
        }
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
}