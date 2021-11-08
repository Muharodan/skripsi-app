<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class FAHPController extends Controller{
    private $pairwise;

    private $fuzzyNumber;

    private $geometricMean;

    private $fuzzyWeight;
    
    private $normalize;

    function __construct()
    {


        // broken link icx 0
        // load time idx 1
        // header size idx 2
        // criteria weights idx 4
        $this->pairwise = array(
            //Sidik
            array(1,2/1,4/1),
            array(1/2,1,3/1),
            array(1/4,1/3,1),

            //Youtube
            // array(1,5,4,7),
            // array(1/5,1,1/2,3),
            // array(1/4,2,1,3),
            // array(1/7,1/3,1/3,1),

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

        print("<br>Fuzzy Weight Value <br>");
        $this->fuzzyWeight = $this->calculateFuzzyWeight($this->geometricMean);
        $this->print($this->fuzzyWeight);

        print("<br>Normalize Kriteria<br>");
        $this->normalize = $this->calculateNormalize($this->fuzzyWeight);
        print_r($this->normalize);


        // $data=[0.102, 2.120, 4, 5.1];
        // $data=[0.51, 4, 2.120, 0.102];
        // $data=[0.102, 2.120, 0.047, 2.342];
        // $data = [0.5, 0.3, 0.2, 1];
        // $data = [6.1, 7, 8, 9];
        // $data = [2.6, 0.5, 8, 5];

        // // data sidik
        $data = [0.105, 0.651, 0.051, 2.046, 0.088];
        print("<br><br> Data Load Time<br>");
        print_r($data);
        print("<br>");
        
        // convert arr to pairwise comparision
        $result = $this->convertLoadTime($data);
        print("<br> Data Load Time Setelah di convert<br>");
        print_r($result);
        print("<br>");

        $pairwiseLoadTime = $this->pairwiseComparison($result);
        print("<br> Pairwise Load Time<br>");
        $this->print($pairwiseLoadTime);
        print("<br>");

        // bacanya kanan ke kiri
        $pairwiseLoadTime = $this->changeToFuzzyNumber($pairwiseLoadTime, $this->fuzzyNumber);
        print("PAIRWISE SETELAH CHANGE TO FUZZY NUMBER ". "DENGAN UKURAN MATRIX ".count($pairwiseLoadTime) ."<br>");
        $this->print($pairwiseLoadTime);

        print("<br>GEOMETRIC MEAN<br>");
        //bacanya atas ke bawah
        $geometricMeanLT = $this->calculateGeomecricMean($pairwiseLoadTime);
        $this->print($geometricMeanLT);

        print("<br>Fuzzy Weight Value <br>");
        $fuzzyWeightLT = $this->calculateFuzzyWeight($geometricMeanLT);
        $this->print($fuzzyWeightLT);

        print("<br>Normalize Kriteria<br>");
        $normalizeLT = $this->calculateNormalize($fuzzyWeightLT);
        print_r($normalizeLT);

        

        // $this->print($this->pairwise);
        
    }

    private function convertLoadTime($data){
        $result=[];
        
        for($i = 0; $i<count($data); $i++){
            $temp = $data[$i];
            if($temp>=0 && $temp<=2)array_push($result, 1); // baik
            else if($temp>2 && $temp<=3)array_push($result, 2); // antara baik dan cukup
            else if($temp>3 && $temp<=5)array_push($result, 3); // cukup
            else if($temp>5 && $temp<=6)array_push($result, 4); // antara cukup dan kurang
            else array_push($result, 5); // kurang 
        }

        return $result;
    }
    
    private function pairwiseComparison($data){
        $pairwiseLoadTime=[];
        for($i = 0; $i<count($data); $i++){
            $pairwiseLoadTime[$i]=[];
        }
        for($i = 0; $i<count($data); $i++){
            
            for($j = $i; $j<count($data); $j++){
                if(empty($pairwiseLoadTime[$i][$j])){
                    $pairwiseLoadTime[$i][$j]=[];
                }
                if(empty($pairwiseLoadTime[$j][$i])){
                    $pairwiseLoadTime[$j][$i]=[];
                }
                if($data[$i]==$data[$j]){ // jika di kategori yang sama atau index yang sama
                    $pairwiseLoadTime[$i][$j]=1;
                    $pairwiseLoadTime[$j][$i]=1;
                }else{
                    $temp = $data[$i]-$data[$j];
                    if($temp<0){
                        $temp = abs($temp)+1;
                        $pairwiseLoadTime[$i][$j]=$temp;
                        $pairwiseLoadTime[$j][$i]=1/$temp;
                    }else{
                        $temp = abs($temp)+1;
                        $pairwiseLoadTime[$i][$j]=1/$temp;
                        $pairwiseLoadTime[$j][$i]=$temp;
                    }
                    
                }
            }
        }
        return $pairwiseLoadTime;
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
        // hitung geometric mean
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
        $inverse=[];
        $total = [];

        //calculate sum
        $i=0;
        foreach($matrix as $row){
            $j=0;
            foreach($row as $val){
                if($i==0){
                    array_push($total, $val);
                }else{
                    $total[$j]+=$val;
                }
                
                $j++;
            }
            $i++;
        }
        // inverse
        for($i=0;$i<3;$i++){
            array_push($inverse,1/$total[3-$i-1]); 
        }

        // fuzzy weight
        for($i=0;$i<count($matrix);$i++){
            for($j=0;$j<count($matrix[$i]);$j++){
                $matrix[$i][$j]*=$inverse[$j];
            }
        }

        return $matrix;
    }


    /**
     * Normalize pairwise matrix
     */
    private function calculateNormalize($matrix){
        $res=[];
        $sum=0;
        foreach($matrix as $row){
            $total=0;
            foreach($row as $val){
                $total+=$val;
                // print($val." Total: ".$total."<br>");
            }
            array_push($res,$total/3);
            $sum+=$total/3;
        }
        
        
        for($i=0;$i<count($res);$i++){
            $res[$i]/=$sum;
        }

        print_r($res);
    }
}

?>