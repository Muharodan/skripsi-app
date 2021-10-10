<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class FAHPController extends Controller{
    protected $pairwise; 
    protected $fuzzified;
    protected $hasilGeo;

    function __construct(array $pairwise = null)
    {
        $this->pairwise = $pairwise;
    }

    //membuat matrix triangular fuzzy number
    function FuzzyPairwise(array $pairwise){
        $counter = 0;
        $temp = [];
        for($i=0 ; $i<$this->fuzzified ; $i++){
            if($counter>2){
                $counter=0;
            }
            for($j=0 ; $j< $this->fuzzified[$i] ; $j++){
                if($pairwise[$i][$counter] == 1){
                    $temp[0] = 1.0;
                    $temp[1] = 1.0;
                    $temp[2] = 1.0;

                    $fuzzified[$i][$j] = $temp[0];
                    $fuzzified[$i][$j+1] = $temp[1];
                    $fuzzified[$i][$j+2] = $temp[2];
                    $counter++;
                }else if($i<$j && $pairwise[$i][$counter] > 0){
                    $temp[0] = round(abs($pairwise[$i][$counter]-1));
                    $temp[1] = round(abs($pairwise[$i][$counter]));
                    $temp[2] = round(abs($pairwise[$i][$counter]+1));

                    $fuzzified[$i][$j] = $temp[0];
                    $fuzzified[$i][$j+1] = $temp[1];
                    $fuzzified[$i][$j+2] = $temp[2];
                    $counter++;
                }else if($i>$j && $pairwise[$i][$counter] < 0){
                    $temp[0] = abs(1 / ($pairwise[$i][$counter]-1));
                    $temp[1] = abs(1 / ($pairwise[$i][$counter]));
                    $temp[2] = abs(1 / ($pairwise[$i][$counter]+1));

                    $fuzzified[$i][$j] = $temp[0];
                    $fuzzified[$i][$j+1] = $temp[1];
                    $fuzzified[$i][$j+2] = $temp[2];
                    $counter++;
                }else if($i<$j && $pairwise[$i][$counter] < 0){
                    $temp[0] = round(abs($pairwise[$i][$counter]-1));
                    $temp[1] = round(abs($pairwise[$i][$counter]));
                    $temp[2] = round(abs($pairwise[$i][$counter]+1));

                    $fuzzified[$i][$j] = $temp[0];
                    $fuzzified[$i][$j+1] = $temp[1];
                    $fuzzified[$i][$j+2] = $temp[2];
                    $counter++;
                }
            }
        }
    }
}

?>