<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    //

    public function index(){
        return Kategori::select('id','nama_kategori')->get();
    }
}
