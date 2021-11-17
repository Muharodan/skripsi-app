<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Importer;
use Illuminate\Support\Facades\Session;

class MainController extends Controller
{
    private $data;

    public function index(Request $request){
        // $location = $this->upload($request);

        // $this->load($location);
        

        // test data dengan cara diprint
        // $this->print($this->data);

        if($request->btn==1){
            print("FUZZY AHP");
            print("<br>");
            $ahp = new FAHPController();
            // print_r($ahp);


            return redirect()->route('hasilAHP')->with(['result'=>$ahp]);
        }else{
            print("FUZZY TOPSIS");
        }
        
    }

    public function check(){
        if(Session::get('result')!=null){
            return view('/hasilAHP');
            // print_r(Session::get('result'));
        }else{
            return redirect()->route('index');
        }
    }

    /**
     * Function for upload csv into folder upload in public
     */
    private function upload($request){
        $dateTime = date('Ymd_His');
        $file = $request->file('file');
        $fileName = $dateTime.'-'.$file->getClientOriginalName();
        $savePath = public_path('/upload/');
        $file->move($savePath, $fileName);
        return $savePath.$fileName;
    }

    /**
     * Function for load/read file csv in public/upload
     */
    private function load($location){
        $excel = Importer::make("CSV");
        $excel->load($location);
        $this->data = $excel->getCollection();
    }

    /**
     * Function for print each element in data/file csv
     */
    private function print($data){
        for($i=1; $i<sizeof($data); $i++){
            try{
                print_r($data[$i]);
                print("<br>");
            }catch(Exception $e){

            }
        }
    }
}
