<?php

namespace App\Http\Controllers;

use App\Models\equiment;
use App\Models\EquimentImport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Maatwebsite\Excel\Facades\Excel;

class EquimentsController extends Controller
{
    function Index()
    {
        return view('pages.Equiments.Equiment.equiment');
    }

    public function Get($perpage, $curentpage, $status = null, $keyword = null)
    {
        $equimens = DB::table('equipments')->select(['id', 'name'])->get()->toArray();

        $newtable = array();

        if ($keyword != null) {
            foreach ($equimens as $value) {

                $result = DB::table('use_details as ud')
                    ->join('equipments as e', 'e.id', '=', 'ud.equipment_id')
                    ->leftJoin('departments as de', 'de.id', '=', 'ud.department_id')
                    ->leftJoin('users as u', 'u.id', '=', 'ud.user_id')
                    ->select(['e.image', 'de.name as namedepartment', 'u.fullname as nameusser', 'e.status', 'ud.amount'])
                    ->where('e.id', $value->id, )
                    ->Where('e.name', 'like', '%' . $keyword . '%')
                    ->OrWhere('de.name', 'like', '%' . $keyword . '%')
                    // ->where('u.fullname', 'like', '%' . $keyword . '%')
                    ->get()
                    ->toArray();

                $list_equiment = $this->paginate($result, $perpage, $curentpage);

                if (count($list_equiment) != 0) {
                    $newtable['' . $value->name . ''] = $list_equiment;
                }
            }
        } else {
            foreach ($equimens as $value) {
                $result = DB::table('use_details as ud')
                    ->join('equipments as e', 'e.id', '=', 'ud.equipment_id')
                    ->leftJoin('departments as de', 'de.id', '=', 'ud.department_id')
                    ->leftJoin('users as u', 'u.id', '=', 'ud.user_id')
                    ->select(['e.image', 'de.name as namedepartment', 'u.fullname as nameusser', 'e.status', 'ud.amount'])
                    ->where('e.id', $value->id)
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
}