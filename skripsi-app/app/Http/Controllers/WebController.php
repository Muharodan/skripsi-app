<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebController extends Controller
{
    //

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

    public function getName($id){
        return DB::table('webs')->where('id', $id+1)->value('nama_web');
        
    }
}
