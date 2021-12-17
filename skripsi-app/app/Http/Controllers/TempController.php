<?php

namespace App\Http\Controllers;

use App\Models\Temp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TempController extends Controller
{
    //

    public function index(){
        return Temp::paginate(20);
    }

    public function store($data)
    {
        foreach ($data as $d) {
            Temp::create([
                'nama_web' => $d[0],
                'broken_link' => $d[1],
                'page_load_time' => $d[2],
                'size_web' => $d[3],
            ]);
        }
    }

    public function delete()
    {
        DB::table('temps')->delete();
    }
}
