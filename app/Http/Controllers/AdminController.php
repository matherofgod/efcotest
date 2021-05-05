<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Graf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $filterfio = $request->query('filterfio');

        if (!empty($filterfio)) {
            $tbl = DB::table('grafs')
                ->leftjoin('users',"grafs.user_id",'=','users.id')
                ->where('users.name', 'like', '%'.$filterfio.'%')
                ->where([['grafs.checked','=','expectation']])
                ->get();
               // dd($products);
        } else {
            $tbl = DB::table('grafs')->select(array('grafs.id','users.name','grafs.checked','grafs.visible','grafs.vacation','grafs.vacationlast'))
            ->leftjoin('users',"grafs.user_id",'=','users.id')
            ->where([['grafs.checked','=','expectation']])
            ->get();
        }
         return view('admin',['tbl'=>$tbl,'filterfio'=> $filterfio]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if($request->dataid){
            $data = Graf::find($request->dataid);
       
            $data->checked = "confirmed";
            $data->visible = true;
            $data->update();
        }elseif($request->dataiddel){
            $data = Graf::find($request->dataiddel);
       
            $data->checked = "rejected";
            $data->visible = false;
            $data->update();
        }
        //
        //dd($request->dataid);
        
        //dd($data->update());
    return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
