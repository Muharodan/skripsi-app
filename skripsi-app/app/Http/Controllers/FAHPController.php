<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class FAHPController extends Controller{
    private $pairwise;

    private $fuzzyNumber;

    private $geometricMean;

    function __construct()
    {
        // broken link icx 0
        // load time idx 1
        // header size idx 2
        // criteria weights idx 4
        $this->pairwise = array(
            //Sidik
            // array(1,2/1,4/1),
            // array(1/2,1,3/1),
            // array(1/4,1/3,1),

            //Youtube
            array(1,5,4,7),
            array(1/5,1,1/2,3),
            array(1/4,2,1,3),
            array(1/7,1/3,1/3,1),

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

        // bacanya kanan ke kiri
        $this->pairwise = $this->changeToFuzzyNumber($this->pairwise, $this->fuzzyNumber);
        print("PAIRWISE SETELAH CHANGE TO FUZZY NUMBER ". "DENGAN UKURAN MATRIX ".count($this->pairwise) ."<br>");
        $this->print($this->pairwise);

        print("<br>GEOMETRIC MEAN<br>");
        //bacanya atas ke bawah
        $this->geometricMean = $this->calculateGeomecricMean($this->pairwise);
        $this->print($this->geometricMean);

        // print("<br>INVERS TOTAL GEOMECTRIC MEAN <br>");
        // print_r($this->calculateFuzzyWeight($this->geometricMean));

        // print("<br>GEOMETRIC MEAN TRANSPOSE <br>");
        // // //bacanya kanan ke kiri
        // $this->geometricMean=$this->transpose($this->geometricMean);
        // $this->print($this->geometricMean);
        // foreach($this->geometricMean as $p){
        //     print_r($p);
        //     print("<br>");
        // }
        
    }

    private function print($matrix){
        $size = count($matrix);
        print("<table style='border: 1px solid black;'>");
        for($i=0;$i<$size;$i++){
            print("<tr style='border: 1px solid black;'>");
            for($j=0;$j<count($matrix[$i]);$j++){
                print("<td style='border: 1px solid black;'>");
                    print_r($matrix[$i][$j]);
                print("</td>");
            }
            print("<tr>");
        }
        print("</table>");
    }

    private function changeToFuzzyNumber($matrix, $fuzzyNumber){
        $size = count($matrix);
        for($i=0;$i<$size;$i++){
            for($j=0;$j<$size;$j++){
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
                                break;
                            }
                        }
                    }
                }
            }
        }

        return $matrix;
    }

    private function calculateGeomecricMean($matrix){
        $size=count($matrix);
        $temp=[];
        $res=[];
        for($i=0;$i<$size;$i++){
            $res[$i]=[];
            $temp[$i]=[];
        }

        // masukin nilai ke temp
        // dalam satu baris berisikan 
        foreach($matrix as $row){
            foreach($row as $col){
                $i = 0;
                foreach($col as $value){
                    array_push($temp[$i], $value);
                    $i++;
                }
            }
        }
        foreach($temp as $row){
            $i=0;
            $idx = 0;
            $count=1;
            foreach($row as $val){
                $idx++;
                $count*=$val;
                if($idx == $size){
                    array_push($res[$i],pow($count, 1/$size));
                    $idx=0;
                    $i++;
                    $count=1;
                    
                }
            }
        }
        return $res;
    }

    /**
     * Calculate Fuzzy Weight 
     * from Geometric Mean
     */
    private function calculateFuzzyWeight($matrix){
        $size=count($matrix);
        $res=[];

        //calculate sum
        for($i=0;$i<$size;$i++){
            $temp=0;
            for($j=0;$j<$size;$j++){
                $temp+=$matrix[$i][$j];
            }
            array_push($res,$temp);
        }

        // calculate inverse
        for($i=0,$j=$size-1;$i<$size,$j>=0;$i++,$j--){
            $temp = $res[$i];
            $res[$i]=$res[$j];
            $res[$j]=$temp;
        }


        return $res;
    }

    private function transpose($matrix){
        $size=count($matrix);
        $res=[];
        for($i=0;$i<$size;$i++){
            for($j=0;$j<$size*$size;$j++){
                $res[$i][$j]=0;
                $res[$i][$j]=$matrix[$j][$i];
            }
        }
        return $res;
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