<?php

namespace App\Http\Controllers\equipment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index()
    {
        return view('pages.Equiments.equipment');
    }
}
