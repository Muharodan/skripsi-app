<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FTOPSISController extends Controller
{
    public $result;

    function __construct($fuzzyNumber, $webController, $mode, $id1, $id2)
    {
        // $fuzzyNumber = [
        //     [1,1,3], // very low, 0
        //     [1,3,5], // low, 1
        //     [3,5,7], // average, 2
        //     [5,7,9], // high, 3
        //     [7,9,9], // very high, 4
        // ];

        // $weightage = [
        //     [3, 4, 2],
        // ];

        // $data=[
        //     [2, 4, 3], //can1
        //     [3, 4, 2], //can2
        //     [4, 2, 1], //can3
        //     [1, 2, 0], //can4 
        // ];

        // $data1=[
        //     [3, 4, 3], //can1
        //     [3, 3, 2], //can2
        //     [4, 2, 0], //can3
        //     [1, 2, 0], //can4 
        // ];

        // $data2=[
        //     [2, 3, 3], //can1
        //     [3, 2, 2], //can2
        //     [3, 2, 1], //can3
        //     [0, 1, 0], //can4 
        // ];

        // print("DATA 0");
        // $data = $this->changeToFuzzyNumber($data, $fuzzyNumber);
        // $this->print($data);
        // print("<br>");

        // print("DATA 1");
        // $data1 = $this->changeToFuzzyNumber($data1, $fuzzyNumber);
        // $this->print($data1);
        // print("<br>");

        // print("DATA 2");
        // $data2 = $this->changeToFuzzyNumber($data2, $fuzzyNumber);
        // $this->print($data2);
        // print("<br>");

        // print("COMBINE DATA");
        // $data = $this->combine($data, $data1, $data2);
        // $this->print($data);
        // print("<br>");

        $data = $webController->getAll($mode, $id1, $id2);
        //bl, pl, s
        $data = $this->convertToArray2D($data);
        // print("<br>DATA Convert ke Array 2D");
        // $this->print($data);    

        $data = $this->changeToFuzzyNumber($data, $fuzzyNumber);
        // print("<br>DATA Convert ke Fuzzy Number");
        // $this->print($data);

        $weightage = [
            [5, 5, 3],
        ];

        // print("Weightage");
        $weightage = $this->changeToFuzzyNumber($weightage, $fuzzyNumber);
        // $this->print($weightage);

        // print("<br>");
        // $benefitCriteria = $this->benefitCriteria($data, 0);
        // print("Benefit Criteria idx 0: ");
        // print_r($benefitCriteria);
        // print("<br>");

        // $benefitCriteria = $this->benefitCriteria($data, 1);
        // print("Benefit Criteria idx 1: ");
        // print_r($benefitCriteria);
        // print("<br>");

        // $costCriteria = $this->costCriteria($data, 2);
        // print("Cost Criteria idx 2: ");
        // print_r($costCriteria);
        // print("<br>");

        $costCriteria = $this->costCriteria($data, 0);
        // print("Cost Criteria idx 0: ");
        // print_r($costCriteria);
        // print("<br>");

        $costCriteria = $this->costCriteria($data, 1);
        // print("Cost Criteria idx 1: ");
        // print_r($costCriteria);
        // print("<br>");

        $costCriteria = $this->costCriteria($data, 2);
        // print("Cost Criteria idx 2: ");
        // print_r($costCriteria);
        // print("<br>");

        // nanti simpen di array, biar bisa di loops (data, mode, idx, value)
        // print("Normalize Decision Matrix <br>");
        $data = $this->normalizeDecisionMatrix($data, 1, 0, $this->costCriteria($data,0));//kolom 1
        $data = $this->normalizeDecisionMatrix($data, 1, 1, $this->costCriteria($data,1));//kolom 2
        $data = $this->normalizeDecisionMatrix($data, 1, 2, $this->costCriteria($data,2));//kolom 2
        // $this->print($data);
        // print("<br>");
        // print("Weight Normalize Decision Matrix <br>");
        $data = $this->weightedNormalize($data, $weightage);
        // $this->print($data);
        // print("<br>");

        $fpis=$this->FPIS($data);
        // print("FPIS");
        // $this->print($fpis);
        // print("<br>");

        $fnis=$this->FNIS($data);
        // print("FNIS");
        // $this->print($fnis);
        // print("<br>");

        $cc = $this->closenessCoefficient($fpis, $fnis);

        $data = $webController->getId();
        $id = [];
        foreach ($data as $d) {
            array_push($id, $d->id);
        }
        $res = [];
        // print_r($res);

        $res=[];
        for($i=0;$i<count($cc);$i++){
            $res["id-" . $id[$i]]=$cc[$i];
        }

        arsort($res);
        // print_r($res);

        $this->result=[];
        $keys=array_keys($res);
        foreach($keys as $k){
            $id = substr($k, 3)*1;
            $data = $webController->find($id);
            $this->result[$id]=[];
            array_push($this->result[$id], $data->nama_web);
            array_push($this->result[$id], $data->broken_link);
            array_push($this->result[$id], $data->page_load_time);
            array_push($this->result[$id], $data->size_web);
            // print($id);
            // print("<br>");
            // print_r($this->result[$id]);
            // print("<br>");
        }
        // print("HASIL PERHITUNGAN");
        // $this->print($this->result);
        return $this->result;
    }

    private function convertLoadTime($value){
            $x = $value/1000;
            // grafik baru
            if($x>=0 && $x<=2.5){ // sangat baik
                return 1;
            }else if($x>2.5 && $x<=3.5){ // baik
                return 2;
            }else if($x>3.5 && $x<=4.5){ // cukup
                return 3;
            }else if($x>4.5 && $x<=5.5){ // kurang
                return 4;
            }else if($x>5.5){ //  sangat kurang
                return 5;
            }
            
            // grafik lama
            // $temp = $data[$i]/1000;
            // if($temp>=0 && $temp<=2)array_push($result, 1); // baik
            // else if($temp>2 && $temp<=3)array_push($result, 2); // antara baik dan cukup
            // else if($temp>3 && $temp<=5)array_push($result, 3); // cukup
            // else if($temp>5 && $temp<=6)array_push($result, 4); // antara cukup dan kurang
            // else array_push($result, 5); // kurang 
    }

    private function convertSize($value){
            //grafik baru
            $x = $value;
            if($x>=0 && $x<=22000){ // sangat baik
                return 1;
            }else if($x>22000 && $x<=40000){ // baik
                return 2;
            }else if($x>40000 && $x<=56000){ // cukup
                return 3;
            }else if($x>56000 && $x<=72000){ // kurang
                return 4;
            }else if($x>72000){ //  sangat kurang
                return 5;
            }
            // grafik lama
            // $temp = $data[$i];
            // if($temp>=0 && $temp<=32000)array_push($result, 1); // baik
            // else if($temp>32000 && $temp<=33000)array_push($result, 2); // antara baik dan cukup
            // else if($temp>33000 && $temp<=64000)array_push($result, 3); // cukup
            // else if($temp>64000 && $temp<=65000)array_push($result, 4); // antara cukup dan kurang
            // else array_push($result, 5); // kurang 
    }

    private function convertBrokenLink($value){
   
            $x = $value;
            if($x>=0 && $x<=37.5){ // sangat baik
                return 1;
            }else if($x>37.5 && $x<=52.5){ // baik
                return 2;
            }else if($x>52.5 && $x<=77.5){ // cukup
                return 3;
            }else if($x>77.5 && $x<=125){ // kurang
                return 4;
            }else if($x>125){ //  sangat kurang
                return 5;
            }
        
    }

    private function combine($data, $data1, $data2){
        for($i = 0; $i<count($data); $i++){
            for($j = 0; $j<count($data[$i]); $j++){
                // for($k = 0; $k<3; $k++){
                    $temp =[
                        min($data[$i][$j][0], $data1[$i][$j][0], $data2[$i][$j][0]),
                        ($data[$i][$j][1] + $data1[$i][$j][1] + $data2[$i][$j][1])/3,
                        max($data[$i][$j][2], $data1[$i][$j][2], $data2[$i][$j][2]),
                    ];
                // }
                $data[$i][$j]= $temp;
            }
        }
        return $data;
    }

    private function convertToArray2D($data){
        $result=[];
        $i = 0;
        foreach($data as $d){
            $result[$i]=[];
            array_push($result[$i], $this->convertBrokenLink($d->broken_link));
            array_push($result[$i], $this->convertLoadTime($d->page_load_time));
            array_push($result[$i], $this->convertSize($d->size_web));
            $i++;
        }
        return $result;
    }

    private function changeToFuzzyNumber($data, $fuzzyNumber){
        for($i = 0; $i<count($data); $i++){
            for($j =0; $j<count($data[$i]); $j++){
                $v = $data[$i][$j]-1;
                $data[$i][$j]=$fuzzyNumber[$v];
            }
        }
        return $data;
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

    // mendapatkan nilai terbesar berdasarkan index/kolom
    // berdsarkan nilai c
    private function benefitCriteria($data, $idx){
        $temp = [];
        for($i = 0; $i<count($data); $i++){
            $v = $data[$i][$idx][2];
            array_push($temp, $v);
        }

        rsort($temp);
        return $temp[0];
    }

    // mendapatkan nilai terkecil berdasarkan index/kolom
    // berdsarkan nilai a
    private function costCriteria($data, $idx){
        $temp = [];
        for($i = 0; $i<count($data); $i++){
            $v = $data[$i][$idx][0];
            array_push($temp, $v);
        }

        sort($temp);
        return $temp[0];
    }

    private function normalizeDecisionMatrix($data, $mode, $idx, $v){
        for($i = 0; $i<count($data); $i++){
            // for($j = 0; $j<count($data[$i]); $j++){
                $temp = [];
                for($k =0; $k<3; $k++){
                    if($mode==0){//benefit criteria
                        $data[$i][$idx][$k] = $data[$i][$idx][$k]/$v;
                    }else{// cost criteria
                        array_push($temp, $v/$data[$i][$idx][2-$k]);
                    }
                }
                if($mode!=0){
                    $data[$i][$idx]=$temp;
                }
            // }
        }
        return $data;
    }

    private function weightedNormalize($data, $weightage){
        for($i = 0; $i<count($data); $i++){
            for($j = 0; $j<count($data[$i]); $j++){
                for($k =0; $k<3; $k++){
                    // print("Data: ".$data[$i][$j][$k]." Weight: ".$weightage[0][$j][$k]);
                    $data[$i][$j][$k]*=$weightage[0][$j][$k];
                    // print(" Hasil: ".$data[$i][$j][$k]);
                    // print("<br>");
                }
            }
        }
        return $data;
    }

    private function FPIS($data){
        $max = [
            PHP_INT_MIN,
            PHP_INT_MIN,
            PHP_INT_MIN,
        ];
        $res = [
            [],
            [],
            []
        ];
        for($i = 0; $i<count($data); $i++){
            for($j = 0; $j<count($data[$i]); $j++){
                // for($k =0; $k<3; $k++){
                    if($data[$i][$j][2] >= $max[$j]){
                        if($i==0){
                            $max[$j] = $data[$i][$j][2];
                            $res[$j] = $data[$i][$j];
                        }else{
                            if($data[$i][$j][1] >= $res[$j][1]){
                                $res[$j] = $data[$i][$j];
                                
                                if($data[$i][$j][0] >= $res[$j][0]){
                                    $res[$j] = $data[$i][$j];
                                }
                            }
                        }
                        
                    }
                // }
            }
        }
        return $this->calculateDistance($data, $res);
    }

    private function FNIS($data){
        $max = [
            PHP_INT_MAX,
            PHP_INT_MAX,
            PHP_INT_MAX,
        ];
        $res = [
            [],
            [],
            []
        ];
        for($i = 0; $i<count($data); $i++){
            for($j = 0; $j<count($data[$i]); $j++){
                // for($k =0; $k<3; $k++){
                    if($data[$i][$j][2] <= $max[$j]){
                        if($i==0){
                            $max[$j] = $data[$i][$j][2];
                            $res[$j] = $data[$i][$j];
                        }else{
                            if($data[$i][$j][1] <= $res[$j][1]){
                                $res[$j] = $data[$i][$j];
                                if($data[$i][$j][0] <= $res[$j][0]){
                                    $res[$j] = $data[$i][$j];
                                }
                            }
                        }
                        
                        
                    }
                // }
            }
        }
        
        return $this->calculateDistance($data, $res);
    }

    private function calculateDistance($data, $res){
        for($i = 0; $i<count($data); $i++){
            $sum = 0;
            for($j = 0; $j<count($data[$i]); $j++){
                $temp = 0;
                for($k =0; $k<3; $k++){
                    // print("I: ".$i." J: ".$j." Data: ".$data[$i][$j][$k]. " Res: ".$res[$j][$k]);
                    // print("<br>");
                    $temp+=pow($data[$i][$j][$k]-$res[$j][$k],2);
                }
                // print("Temp: ".$temp);
                // print("<br>");
                $temp = sqrt($temp/3);
                $sum+=$temp;
                $data[$i][$j]=$temp;
            }
            $data[$i][3]=$sum;
        }
        return $data;
    }

    private function closenessCoefficient($fpis, $fnis){
        $res = [];
        for($i = 0; $i<count($fpis); $i++){
            $res[$i]=$fnis[$i][3]/($fnis[$i][3]+$fpis[$i][3]);
        }
        return $res;
    }
}
