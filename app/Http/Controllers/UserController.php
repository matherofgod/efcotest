<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Graf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
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
                ->get();
               // dd($products);
        } else {
            $tbl = DB::table('grafs')->select(array('grafs.id as grafs_id','users.name','users.id','grafs.checked','grafs.visible','grafs.vacation','grafs.vacationlast'))
            ->leftjoin('users',"grafs.user_id",'=','users.id')
            ->get();
           // dd($tbl);
        }

      $day=DB::table('users')
        ->join('positions',"users.position_id",'=','positions.id')
        ->where([['users.id','=',Auth::id()]])
        ->get();
 
            

        return view('user',['tbl'=>$tbl,'day'=>$day,'filterfio'=> $filterfio]);
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
        $grafs= new Graf;
        $grafs->user_id = Auth::id();
        $grafs->checked = "expectation";
        $grafs->visible = false;
        $grafs->vacation=$request->input('vacation');
        $grafs->vacationlast=$request->input("vacationlast");
        $grafs->save();
        return back();
      
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
        //
        //dd($request->recipientname);
        $data = Graf::find($request->recipientname);
        $data->checked = "expectation";
        $data->visible = false;
        $data->vacation=$request->input('vacationupdate');
        $data->vacationlast=$request->input("vacationlastupdate");
       
        $data->update();
        
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
