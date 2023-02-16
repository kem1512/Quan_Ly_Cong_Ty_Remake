<?php

namespace App\Http\Controllers;

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
        return view('pages.Equiments.Equiment.equiment', compact('list_loai'));
    }
    public function Get($perpage, $curentpage, $keyword = null)
    {
        if ($keyword == null) {
            $equiment_types = DB::table('equipment_types')
                ->select(['id', 'name'])
                ->get()
                ->toArray();


            $newtable = array();

            foreach ($equiment_types as $value) {

                $result = DB::table('equipments')
                    ->select(['id', 'image', 'name', 'status'])
                    ->where('equiment_type_id', '=', $value->id)
                    ->get()
                    ->toArray();


                $list_equiment = $this->paginate($result, $perpage, $curentpage);

                if (count($list_equiment) != 0) {
                    $newtable['' . $value->name . ''] = $list_equiment;
                }

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

    function Create(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'min:6'],
                'image' => ['required'],
                'specifications' => ['required', 'min:6'],
                'manufacture' => ['required', 'min:6'],
                'price' => ['required', 'regex:/^[0-9]+$/'],
                'warranty_date' => ['date'],
                'out_of_date' => ['date'],
            ],
            [
                'name.required' => "Tên thiết bị không được để trống!",
                'name.min' => "Tên thiết bị phải lớn hơn 6 kí tự!",
                'image.required' => "Ảnh thiết bị không được để trống!",
                'specifications.required' => "Thông số thiết bị không được để trống!",
                'specifications.min' => "Thông số thiết bị phải lớn hơn 6 kí tự!",
                'manufacture.required' => "Nhà cung cấp không được để trống!",
                'manufacture.min' => "Nhà cung cấp phải lớn hơn 6 kí tự!",
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
        }

        $name = $request->name;
        $image = $file_name;
        $specifications = $request->specifications;
        $manufacture = $request->manufacture;
        $price = $request->price;
        $warranty_date = $request->warranty_date;
        $out_of_date = $request->out_of_date;
        $created = Carbon::Now();
        $updated = Carbon::Now();

        $result = DB::table('equipments')
            ->insert([
                'name' => $name,
                'image' => $image,
                'specifications' => $specifications,
                'manufacture' => $manufacture,
                'price' => $price,
                'warranty_date' => $warranty_date,
                'out_of_date' => $out_of_date,
                'equiment_type_id' => $request->equiment_type_id,
                'created_at' => $created,
                'updated_at' => $updated,
            ]);

        $message = $result == 1 ? "Thành công" : "Thất bại";

        return response()->json([
            'message' => $message
        ], 200);
    }

    function ImportExcel()
    {
        $data = Excel::get(request()->file('file'));

        dd($data);
    }
}