<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FTOPSISController extends Controller
{
    //
    function __construct($brokenLink, $pageLoadTime, $sizeWeb, $fuzzyNumber, $webController)
    {
        $fuzzyNumber = [
            [1,1,3], // very low, 0
            [1,3,5], // low, 1
            [3,5,7], // average, 2
            [5,7,9], // high, 3
            [7,9,9], // very high, 4
        ];

        $weightage = [
            [3, 4, 2],
        ];

        $data=[
            [2, 4, 3], //can1
            [3, 4, 2], //can2
            [4, 2, 1], //can3
            [1, 2, 1], //can4 
        ];

        $data = $this->changeToFuzzyNumber($data, $fuzzyNumber);
        $this->print($data);

        print("<br>");
        print("Weightage");
        $weightage = $this->changeToFuzzyNumber($weightage, $fuzzyNumber);
        $this->print($weightage);

        print("<br>");
        $benefitCriteria = $this->benefitCriteria($data, 0);
        print("Benefit Criteria idx 0: ");
        print_r($benefitCriteria);
        print("<br>");

        $benefitCriteria = $this->benefitCriteria($data, 1);
        print("Benefit Criteria idx 1: ");
        print_r($benefitCriteria);
        print("<br>");

        $costCriteria = $this->costCriteria($data, 2);
        print("Cost Criteria idx 2: ");
        print_r($costCriteria);
        print("<br>");

        // nanti simpen di array, biar bisa di loops (data, mode, idx, value)
        print("Normalize Decision Matrix <br>");
        $data = $this->normalizeDecisionMatrix($data, 0, 0, 9);//kolom 1
        $data = $this->normalizeDecisionMatrix($data, 0, 1, 9);//kolom 2
        $data = $this->normalizeDecisionMatrix($data, 1, 2, 1);//kolom 2
        $this->print($data);
        print("<br>");
        $data = $this->weightedNormalize($data, $weightage);
        $this->print($data);
        print("<br>");
    }

    private function changeToFuzzyNumber($data, $fuzzyNumber){
        for($i = 0; $i<count($data); $i++){
            for($j =0; $j<count($data[$i]); $j++){
                $v = $data[$i][$j];
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
                for($k =0; $k<3; $k++){
                    if($mode==0){//benefit criteria
                        $data[$i][$idx][$k] = $data[$i][$idx][$k]/$v;//4 angka dibelakang koma
                    }else{// cost criteria
                        $data[$i][$idx][$k] = $v/$data[$i][$idx][$k];
                    }
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
}