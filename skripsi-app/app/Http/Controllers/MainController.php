<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Importer;

class MainController extends Controller
{
    private WebController $webController;
    private $fuzzyNumber;
    private TempController $tempController;

    public function __construct()
    {
        $this->webController = new WebController();
        $this->tempController = new TempController();
        $this->fuzzyNumber = array(
            array(1, 1, 1), //1
            array(1, 2, 3), //2
            array(2, 3, 4), //3
            array(3, 4, 5), //4
            array(4, 5, 6), //5
            array(5, 6, 7), //6
            array(6, 7, 8), //7
            array(7, 8, 9), //8
            array(9, 9, 9), //9
        );
    }


    public function index(Request $request)
    {
        // $location = $this->upload($request);

        // $this->load($location);


        // test data dengan cara diprint
        // $this->print($this->data);

        $this->webController->setIdKategori($request->kategori);

        $result = [];
        if ($request->btn == 1) {
            $ahp = new FAHPController($this->fuzzyNumber, $this->webController, 0, 0, 0);
            $result = $ahp->result;

            $this->tempController->store($result);

            return redirect()->route('hasilAHP')->with(['result' => $result]);
        } else {
            $topsis = new FTOPSISController($this->fuzzyNumber, $this->webController, 0, 0, 0);
            $result = $topsis->result;
            // $result = $this->paginate($result);

            $this->tempController->store($result);

            return redirect()->route('hasilTOPSIS')->with(['result' => $result]);
        }
    }

    public function compare(Request $request)
    {
        print_r($request->all());

        $keys = array_keys($request->all());
        $id1 = $request[$keys[1]];
        $id2 = $request[$keys[2]];
        $btn = $request[$keys[3]];

        if ($btn == 1) {
            $ahp = new FAHPController($this->fuzzyNumber, $this->webController, 1, $id1, $id2);
            $result = $ahp->result;

            $this->tempController->store($result);

            return redirect()->route('hasilAHP')->with(['result' => $result]);
        } else {
            $topsis = new FTOPSISController($this->fuzzyNumber, $this->webController, 1, $id1, $id2);
            $result = $topsis->result;
            // $result = $this->paginate($result);

            $this->tempController->store($result);

            return redirect()->route('hasilTOPSIS')->with(['result' => $result]);
        }
    }

    public function hasilAHP()
    {
        $result = $this->tempController->index();
        return view('hasilAHP', compact('result'));
    }

    public function hasilTOPSIS()
    {
        $result = $this->tempController->index();
        return view('hasilTOPSIS', compact('result'));
    }

    // public function check(){
    //     if(Session::get('result')!=null){
    //         if(Session::get('mode')==0){
    //             return view('/hasilAHP');
    //         }else{
    //             // print_r(Session::get('result'));
    //             return view('/hasilTOPSIS');
    //         }

    //         // print_r(Session::get('result'));
    //     }else{
    //         return redirect()->route('index');
    //     }
    // }

    /**
     * Function for upload csv into folder upload in public
     */
    // private function upload($request)
    // {
    //     $dateTime = date('Ymd_His');
    //     $file = $request->file('file');
    //     $fileName = $dateTime . '-' . $file->getClientOriginalName();
    //     $savePath = public_path('/upload/');
    //     $file->move($savePath, $fileName);
    //     return $savePath . $fileName;
    // }

    /**
     * Function for load/read file csv in public/upload
     */
    // private function load($location)
    // {
    //     $excel = Importer::make("CSV");
    //     $excel->load($location);
    //     $this->data = $excel->getCollection();
    // }

    /**
     * Function for print each element in data/file csv
     */
    // private function print($data)
    // {
    //     for ($i = 1; $i < sizeof($data); $i++) {
    //         try {
    //             print_r($data[$i]);
    //             print("<br>");
    //         } catch (Exception $e) {
    //         }
    //     }
    // }
}
