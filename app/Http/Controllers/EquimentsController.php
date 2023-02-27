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

    public function Get($perpage, $curentpage)
    {
        $newtable = array();


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