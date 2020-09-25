<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\demo;
use DB;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $demodata = DB::table('demos')->paginate(20);
        return response()->json($demodata);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id = $request->id;
        $fname = $request->fname;
        $lname = $request->lname;
        $email = $request->email;
        $mobile = $request->mobile;

        
        DB::table('demos')->updateOrInsert(
            ['id' => $id],
            [
                'fname' => $fname,
                'lname' => $lname,
                'mobile' => $mobile,
                'email' => $email,
                'updated_at' => now()
            ]
        );

        return response()->json('Data updated!');
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
