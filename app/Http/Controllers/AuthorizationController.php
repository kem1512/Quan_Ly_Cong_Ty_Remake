<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;


class AuthorizationController extends Controller
{
    function index(Request $request)
    {
        $positions = Position::all();

        return view('pages.authorization', compact('positions'));
    }
}
