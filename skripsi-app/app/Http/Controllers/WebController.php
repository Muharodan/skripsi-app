<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebController extends Controller
{
    //

    public function index(){
        $listWeb = DB::table('webs')->paginate(10);

        return view('home', ['listWeb'=>$listWeb]);
    }

    public function getBrokenLink(){
        return DB::select("
            select broken_link
            from webs
        ");
    }

    public function getPageLoadTime(){
        return DB::select("
            select page_load_time
            from webs
        ");
    }

    public function getSizeWeb(){
        return DB::select("
            select size_web
            from webs
        ");
    }

    public function getAll(){
        return DB::select("
            select broken_link, page_load_time, size_web
            from webs
        ");
    }

    public function find($id){
        return DB::table('webs')->find($id+1);
        
    }
}
