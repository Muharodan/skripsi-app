<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Importer;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class MainController extends Controller
{
    private $data;
    private WebController $webController;
    private $fuzzyNumber;

    public function __construct(){
        $this->webController = new WebController();
        $this->fuzzyNumber = array(
            array(1,1,1),//1
            array(1,2,3),//2
            array(2,3,4),//3
            array(3,4,5),//4
            array(4,5,6),//5
            array(5,6,7),//6
            array(6,7,8),//7
            array(7,8,9),//8
            array(9,9,9),//9
        );
    }
    

    public function index(Request $request){
        // $location = $this->upload($request);

        // $this->load($location);
        

        // test data dengan cara diprint
        // $this->print($this->data);

        $this->webController->setIdKategori($request->kategori);

        if($request->btn==1){
            $ahp = new FAHPController($this->fuzzyNumber, $this->webController);
            $result=$ahp->result;

            $result = $this->paginate($result);
            return view('hasilAHP', ['result'=>$result]);

            // return redirect()->route('hasilAHP')->with(['result'=>$ahp, "mode">=0]);
        }else{
            // print("FUZZY TOPSIS");

            $topsis = new FTOPSISController($this->fuzzyNumber, $this->webController);
            $result=$topsis->result;
            // print_r($topsis->result);
            $result = $this->paginate($result);

            return view('hasilTOPSIS',['result'=>$result]);
            // return redirect()->route('hasilTOPSIS')->with(['result'=>$topsis, 'mode'=>1]);
        }
        
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        //current page
        $page = (int) app('request')->get('page', $default = '0');
        // buat menjadi collection
        $items = $items instanceof Collection ? $items : Collection::make($items);

        //Create our paginator and pass it to the view
        $paginatedResults = new LengthAwarePaginator($items->forPage($page, $perPage), count($items), $perPage);

        $paginatedResults->setPath('hasil');

        return $paginatedResults;
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
