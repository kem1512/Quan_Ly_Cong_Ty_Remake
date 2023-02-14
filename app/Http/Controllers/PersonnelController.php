<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PersonnelController extends Controller
{
    public function show(){
        $nhansu = User::paginate(5);       
        return view('pages.personnel', compact('nhansu'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $rq)
    {
        $id = $rq->input('count_type');
        $nhansu =  User::find($id);
        $nhansu->delete();
        return redirect()-> route('home');
    }

    public function store(Request $rq)
    {
    
         User::create($rq->all());
        return redirect()-> route('personnel');
    }
}
