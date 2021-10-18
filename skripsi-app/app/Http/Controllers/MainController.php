<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Importer;

class MainController extends Controller
{
    //
    public function index(Request $request){
        $dateTime = date('Ymd_His');
        $file = $request->file('file');
        $fileName = $dateTime.'-'.$file->getClientOriginalName();
        $savePath = public_path('/upload/');
        $file->move($savePath, $fileName);

        $excel = Importer::make("CSV");
        $excel->load($savePath.$fileName);
        $collection = $excel->getCollection();

        // if(sizeof($collection[1])==5){
            for($i=1; $i<sizeof($collection); $i++){
                try{
                    print_r($collection[$i]);
                    print("<br>");
                }catch(Exception $e){

                }
            }
        // }else{
        //     print("Masuk Else");
        // }

    }
}
