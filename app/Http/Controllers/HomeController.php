<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\demo;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $demodata = DB::table('demos')->orderby('updated_at','DESC')->paginate(15);
        return view('home')->with('demodata',$demodata);
    }
}
