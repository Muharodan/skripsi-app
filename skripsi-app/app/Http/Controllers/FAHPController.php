<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;


class FAHPController extends Controller{
    private $pairwise;

    private $fuzzyNumber;

    function __construct()
    {
        // broken link icx 0
        // load time idx 1
        // header size idx 2
        // criteria weights idx 4
        $this->pairwise = array(
            array(1,2/1,4/1),
            array(1/2,1,3/1),
            array(1/4,1/3,1),
        );

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

        $this->pairwise = $this->changeToFuzzyNumber($this->pairwise, $this->fuzzyNumber);
        foreach($this->pairwise as $p){
            print_r($p);
            print("<br>");
        }
        
    }

    private function changeToFuzzyNumber($matrix, $fuzzyNumber){
        for($i=0;$i<3;$i++){
            for($j=0;$j<3;$j++){
                if($matrix[$i][$j]>=1){
                    for($k=1;$k<=9;$k++){
                        if($matrix[$i][$j]==$k){
                            $matrix[$i][$j]=$fuzzyNumber[$k-1];
                            break;
                        }
                    }
                }else{
                    for($k=1;$k<=9;$k++){
                        if(!is_array($matrix[$i][$j])){
                            $temp = $matrix[$i][$j]*$k;
                            if($temp==1){
                                $arr = array(
                                    1/$fuzzyNumber[$k-1][2],
                                    1/$fuzzyNumber[$k-1][1],
                                    1/$fuzzyNumber[$k-1][0],
                                );
                                $matrix[$i][$j]=$arr;
                            }
                        }
                    }
                }
            }
        }

        return $matrix;
    }

    /**
     * Normalize pairwise matrix
     */
    private function normalize($matrix){
        $a=0;
        $b=0;
        $c=0;
        for($i=0;$i<3;$i++){
            for($j=0;$j<3;$j++){
                if($j==0) $a+=$matrix[$i][$j];
                else if($j==1) $b+=$matrix[$i][$j];
                else $c+=$matrix[$i][$j];
            }
        }

        for($i=0;$i<3;$i++){
            for($j=0;$j<3;$j++){
                if($j==0) $matrix[$i][$j]=$matrix[$i][$j]/$a;
                else if($j==1) $matrix[$i][$j]=$matrix[$i][$j]/$b;
                else $matrix[$i][$j]=$matrix[$i][$j]/$c;
            }
        }

        return $matrix;
    }

    /**
     * Calculate Creiteria Weights
     * from normalize matrix
     */
    private function calculateCriteriaWeight($matrix){
        $temp=0;
        for($i=0;$i<3;$i++){
            for($j=0;$j<3;$j++){
                $temp+=$matrix[$i][$j];
            }
            $matrix[$i][3]=$temp/3;
            $temp=0;
        }
        return $matrix;
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