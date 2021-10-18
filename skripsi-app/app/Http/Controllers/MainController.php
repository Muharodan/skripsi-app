<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class MainController extends Controller
{
    //
    public function index(Request $request){
        $dateTime = date('Ymd_His');
        $file = $request->file('file');
        // dd($file);
        // print_r($file);
        $fileName = $dateTime.'-'.$file->getClientOriginalName();
        $savePath = public_path('/upload/');
        $file->move($savePath, $fileName);
    }
}
