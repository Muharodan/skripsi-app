<?php

namespace App\Http\Controllers;


class FAHPController extends Controller
{

    public $result;

    function __construct($fuzzyNumber, $webController, $mode, $id1, $id2)
    {

        // broken_link idx 0
        // page_load_time idx 1
        // size_web idx 2
        // Data Kriteria
        $DK = array(
            //Sidik
            array(1, 2 / 1, 4 / 1),
            array(1 / 2, 1, 3 / 1),
            array(1 / 4, 1 / 3, 1),

            //Youtube
            // array(1,5,4,7),
            // array(1/5,1,1/2,3),
            // array(1/4,2,1,3),
            // array(1/7,1/3,1/3,1),

        );
        // bacanya kanan ke kiri
        $DK = $this->changeToFuzzyNumber($DK, $fuzzyNumber);
        // print("PAIRWISE SETELAH CHANGE TO FUZZY NUMBER ". "DENGAN UKURAN MATRIX ".count($DK) ."<br>");
        // $this->print($DK);

        // print("<br>GEOMETRIC MEAN<br>");
        //bacanya atas ke bawah
        $GMK = $this->calculateGeomecricMean($DK);
        // $this->print($GMK);

        // print("<br>Fuzzy Weight Value <br>");
        $FWK = $this->calculateFuzzyWeight($GMK);
        // $this->print($FWK);

        // print("<br>Normalize Kriteria<br>");
        $NK = $this->calculateNormalize($FWK);
        // print_r($NK);

        // Broken Link
        // google, facebook, amazon, imdb (dalam bytes)
        // $DBL = [0, 40, 75, 28];
        $DBL = $webController->getBrokenLink($mode, $id1, $id2);
        $DBL = $this->convertToArray2D($DBL, 0);
        // print("<br><br> Data Broken Link<br>");
        // print_r($DBL);
        // print("<br>");

        // convert arr to pairwise comparision
        $DBL = $this->convertBrokenLink($DBL);
        // print("<br> Data Broken Link setelah di convert<br>");
        // print_r($DBL);
        // print("<br>");

        $DBL = $this->pairwiseComparison($DBL);
        // print("<br> Pairwise Broken Link<br>");
        // $this->print($DBL);
        // print("<br>");

        // bacanya kanan ke kiri
        $DBL = $this->changeToFuzzyNumber($DBL, $fuzzyNumber);
        // print("PAIRWISE SETELAH CHANGE TO FUZZY NUMBER ". "DENGAN UKURAN MATRIX ".count($DBL) ."<br>");
        // $this->print($DBL);

        // print("<br>GEOMETRIC MEAN<br>");
        //bacanya atas ke bawah
        $GMBL = $this->calculateGeomecricMean($DBL);
        // $this->print($GMBL);

        // print("<br>Fuzzy Weight Value Broken Link<br>");
        $FWBL = $this->calculateFuzzyWeight($GMBL);
        // $this->print($FWBL);

        // print("<br>Normalize Broken Link<br>");
        $NBL = $this->calculateNormalize($FWBL);
        // print_r($NBL);

        // print("<br>");


        // $data=[0.102, 2.120, 4, 5.1];
        // $data=[0.51, 4, 2.120, 0.102];
        // $data=[0.102, 2.120, 0.047, 2.342];
        // $data = [0.5, 0.3, 0.2, 1];
        // $data = [6.1, 7, 8, 9];
        // $data = [2.6, 0.5, 8, 5];

        // data sidik
        // LOAD TIME
        // $data = [105, 651, 051, 2046];
        $DPLT = $webController->getPageLoadTime($mode, $id1, $id2);
        $DPLT = $this->convertToArray2D($DPLT, 1);
        // print("<br><br> Data Load Time (dalam ms)<br>");
        // print_r($DPLT);
        // print("<br>");

        // convert arr to pairwise comparision
        $DPLT = $this->convertLoadTime($DPLT);
        // print("<br> Data Load Time Setelah di convert<br>");
        // print_r($DPLT);
        // print("<br>");

        $DPLT = $this->pairwiseComparison($DPLT);
        // print("<br> Pairwise Load Time<br>");
        // $this->print($DPLT);
        // print("<br>");

        // bacanya kanan ke kiri
        $DPLT = $this->changeToFuzzyNumber($DPLT, $fuzzyNumber);
        // print("PAIRWISE SETELAH CHANGE TO FUZZY NUMBER ". "DENGAN UKURAN MATRIX ".count($DPLT) ."<br>");
        // $this->print($DPLT);

        // print("<br>GEOMETRIC MEAN<br>");
        //bacanya atas ke bawah
        $GMPLT = $this->calculateGeomecricMean($DPLT);
        // $this->print($GMPLT);

        // print("<br>Fuzzy Weight Value Load Time (dalam ms)<br>");
        $FWPLT = $this->calculateFuzzyWeight($GMPLT);
        // $this->print($FWPLT);

        // print("<br>Normalize Load Time<br>");
        $NPLT = $this->calculateNormalize($FWPLT);
        // print_r($NPLT);

        // SIZE
        // google, facebook, amazon, imdb (dalam bytes)
        // $data = [16020, 84027, 281, 670916];
        $DSW = $webController->getSizeWeb($mode, $id1, $id2);
        $DSW = $this->convertToArray2D($DSW, 2);
        // print("<br><br> Data Size (dalam bytes)<br>");
        // print_r($DSW);
        // print("<br>");

        // convert arr to pairwise comparision
        $DSW = $this->convertSize($DSW);
        // print("<br> Data Size setelah di convert<br>");
        // print_r($DSW);
        // print("<br>");

        $DSW = $this->pairwiseComparison($DSW);
        // print("<br> Pairwise Size<br>");
        // $this->print($DSW);
        // print("<br>");

        // bacanya kanan ke kiri
        $DSW = $this->changeToFuzzyNumber($DSW, $fuzzyNumber);
        // print("PAIRWISE SETELAH CHANGE TO FUZZY NUMBER ". "DENGAN UKURAN MATRIX ".count($DSW) ."<br>");
        // $this->print($DSW);

        // print("<br>GEOMETRIC MEAN<br>");
        //bacanya atas ke bawah
        $GMSW = $this->calculateGeomecricMean($DSW);
        // $this->print($GMSW);

        // print("<br>Fuzzy Weight Value Size<br>");
        $FWSW = $this->calculateFuzzyWeight($GMSW);
        // $this->print($FWSW);

        // print("<br>Normalize Size<br>");
        $NSW = $this->calculateNormalize($FWSW);
        // print_r($NSW);

        // print("<br>Result<br>");
        // print(count($this->normalize));
        $result = $this->calculateResult($NK, $NBL, $NPLT, $NSW);
        // $this->print($result);
        // print_r($result);

        // $max = array_keys($result, max($result));
        // print("<br>");
        // print("Index max: ".$max[0]. " dengan nilai: ".$result[$max[0]]." Pada web : ");
        // print_r($this->webController->find($max[0]));

        // $min = array_keys($result, min($result));
        // print("<br>");
        // print("Index min: ".$min[0]. " dengan nilai: ".$result[$min[0]]." Pada web : ");
        // print_r($this->webController->find($min[0]));

        $id = $webController->getId($mode, $id1, $id2);
        $id = $this->convertToArray2D($id, 3);
        // print_r($id);

        $res = [];
        for ($i = 0; $i < count($result); $i++) {
            $res["id-" . $id[$i]] = $result[$i];
        }

        // print_r($res);


        // print("<br>");
        // sort besar ke kecil
        arsort($res);
        // print_r($res);

        // print("<br>");
        $this->result = [];
        $keys = array_keys($res);
        foreach ($keys as $k) {
            $id = substr($k, 3) * 1;
            $data = $webController->find($id);
            $this->result[$id] = [];
            array_push($this->result[$id], $data->nama_web);
            array_push($this->result[$id], $data->broken_link);
            array_push($this->result[$id], $data->page_load_time);
            array_push($this->result[$id], $data->size_web);
            // print($id);
            // print("<br>");
            // print_r($this->result[$id]);
            // print("<br>");
        }

        // $this->result=$res;

        return $this->result;
    }

    private function convertToArray2D($data, $mode)
    {
        $result = [];
        foreach ($data as $d) {
            if ($mode == 0) { //broken_link
                array_push($result, $d->broken_link);
            } else if ($mode == 1) { //page_load_time
                array_push($result, $d->page_load_time);
            } else if ($mode == 2) { // size_web
                array_push($result, $d->size_web);
            } else {
                array_push($result, $d->id);
            }
        }
        return $result;
    }

    private function calculateResult($kriteria, $brokenlink, $loadTime, $headerSize)
    {
        $arr = [];
        for ($i = 0; $i < count($kriteria); $i++) {
            $arrt[$i] = [];
            for ($j = 0; $j < count($brokenlink); $j++) {
                $arr[$i][$j] = [];
                if ($i == 0) { //broken link
                    array_push($arr[$i][$j], $kriteria[$i] * $brokenlink[$j]);
                } else if ($i == 1) { //load time
                    array_push($arr[$i][$j], $kriteria[$i] * $loadTime[$j]);
                } else { // header size
                    array_push($arr[$i][$j], $kriteria[$i] * $headerSize[$j]);
                }
            }
        }

        // print_r($arr);
        print("<br>");
        $result = [];
        // sum
        for ($i = 0; $i < count($arr); $i++) {
            for ($j = 0; $j < count($arr[$i]); $j++) {
                if (empty($result[$j])) {
                    $result[$j] = $arr[$i][$j][0];
                } else {
                    $result[$j] += $arr[$i][$j][0];
                }
            }
        }


        return $result;
    }

    private function convertLoadTime($data)
    {
        $result = [];

        for ($i = 0; $i < count($data); $i++) {
            $x = $data[$i] / 1000;
            // grafik baru
            if ($x >= 0 && $x <= 2.5) { // sangat baik
                array_push($result, 1);
            } else if ($x > 2.5 && $x <= 3.5) { // baik
                array_push($result, 2);
            } else if ($x > 3.5 && $x <= 4.5) { // cukup
                array_push($result, 3);
            } else if ($x > 4.5 && $x <= 5.5) { // kurang
                array_push($result, 4);
            } else if ($x > 5.5) { //  sangat kurang
                array_push($result, 5);
            }

            // grafik lama
            // $temp = $data[$i]/1000;
            // if($temp>=0 && $temp<=2)array_push($result, 1); // baik
            // else if($temp>2 && $temp<=3)array_push($result, 2); // antara baik dan cukup
            // else if($temp>3 && $temp<=5)array_push($result, 3); // cukup
            // else if($temp>5 && $temp<=6)array_push($result, 4); // antara cukup dan kurang
            // else array_push($result, 5); // kurang 
        }

        return $result;
    }

    private function convertSize($data)
    {
        $result = [];

        for ($i = 0; $i < count($data); $i++) {
            //grafik baru
            $x = $data[$i];
            if ($x >= 0 && $x <= 22000) { // sangat baik
                array_push($result, 1);
            } else if ($x > 22000 && $x <= 40000) { // baik
                array_push($result, 2);
            } else if ($x > 40000 && $x <= 56000) { // cukup
                array_push($result, 3);
            } else if ($x > 56000 && $x <= 72000) { // kurang
                array_push($result, 4);
            } else if ($x > 72000) { //  sangat kurang
                array_push($result, 5);
            }
            // grafik lama
            // $temp = $data[$i];
            // if($temp>=0 && $temp<=32000)array_push($result, 1); // baik
            // else if($temp>32000 && $temp<=33000)array_push($result, 2); // antara baik dan cukup
            // else if($temp>33000 && $temp<=64000)array_push($result, 3); // cukup
            // else if($temp>64000 && $temp<=65000)array_push($result, 4); // antara cukup dan kurang
            // else array_push($result, 5); // kurang 
        }

        return $result;
    }

    private function convertBrokenLink($data)
    {
        $result = [];

        for ($i = 0; $i < count($data); $i++) {
            //grafik baru
            $x = $data[$i];
            if ($x >= 0 && $x <= 37.5) { // sangat baik
                array_push($result, 1);
            } else if ($x > 37.5 && $x <= 52.5) { // baik
                array_push($result, 2);
            } else if ($x > 52.5 && $x <= 77.5) { // cukup
                array_push($result, 3);
            } else if ($x > 77.5 && $x <= 125) { // kurang
                array_push($result, 4);
            } else if ($x > 125) { //  sangat kurang
                array_push($result, 5);
            }
        }
        return $result;
    }

    private function pairwiseComparison($data)
    {
        $result = [];
        for ($i = 0; $i < count($data); $i++) {
            $result[$i] = [];
        }
        for ($i = 0; $i < count($data); $i++) {

            for ($j = $i; $j < count($data); $j++) {
                if (empty($result[$i][$j])) {
                    $result[$i][$j] = [];
                }
                if (empty($result[$j][$i])) {
                    $result[$j][$i] = [];
                }
                if ($data[$i] == $data[$j]) { // jika di kategori yang sama atau index yang sama
                    $result[$i][$j] = 1;
                    $result[$j][$i] = 1;
                } else {
                    $temp = $data[$i] - $data[$j];
                    if ($temp < 0) { // jika nilai convert kolom lebih besar dari baris
                        $temp = abs($temp) + 1;
                        $result[$i][$j] = $temp;
                        $result[$j][$i] = 1 / $temp;
                    } else {
                        $temp = abs($temp) + 1;
                        $result[$i][$j] = 1 / $temp;
                        $result[$j][$i] = $temp;
                    }
                }
            }
        }
        return $result;
    }



    private function print($matrix)
    {
        $size = count($matrix);
        print("<table style='border: 1px solid black;'>");
        for ($i = 0; $i < $size; $i++) {
            print("<tr style='border: 1px solid black;'>");
            for ($j = 0; $j < count($matrix[$i]); $j++) {
                print("<td style='border: 1px solid black;'>");
                print_r($matrix[$i][$j]);
                print("</td>");
            }
            print("<tr>");
        }
        print("</table>");
    }

    private function changeToFuzzyNumber($matrix, $fuzzyNumber)
    {
        $size = count($matrix);
        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                if ($matrix[$i][$j] >= 1) {
                    for ($k = 1; $k <= 9; $k++) {
                        if ($matrix[$i][$j] == $k) {
                            $matrix[$i][$j] = $fuzzyNumber[$k - 1];
                            break;
                        }
                    }
                } else {
                    for ($k = 1; $k <= 9; $k++) {
                        if (!is_array($matrix[$i][$j])) {
                            $temp = $matrix[$i][$j] * $k;
                            if ($temp == 1) {
                                $arr = array(
                                    1 / $fuzzyNumber[$k - 1][2],
                                    1 / $fuzzyNumber[$k - 1][1],
                                    1 / $fuzzyNumber[$k - 1][0],
                                );
                                $matrix[$i][$j] = $arr;
                                break;
                            }
                        }
                    }
                }
            }
        }

        return $matrix;
    }

    private function calculateGeomecricMean($matrix)
    {
        $size = count($matrix);
        // print("SIZE MATRIX: ".$size. "<br>");
        $temp = [];
        $res = [];
        for ($i = 0; $i < $size; $i++) {
            $res[$i] = [];
            // $temp[$i] = [];
        }

        // if($size<3){
        for ($i = 0; $i < 3; $i++) {
            $temp[$i] = [];
        }
        // }

        // masukin nilai ke temp
        // dalam satu baris berisikan 
        foreach ($matrix as $row) {
            foreach ($row as $col) {
                $i = 0;
                foreach ($col as $value) {
                    array_push($temp[$i], $value);
                    $i++;
                }
            }
        }
        // hitung geometric mean
        foreach ($temp as $row) {
            $i = 0;
            $idx = 0;
            $count = 1;
            foreach ($row as $val) {
                $idx++;
                $count *= $val;
                if ($idx == $size) {
                    array_push($res[$i], pow($count, 1 / $size));
                    $idx = 0;
                    $i++;
                    $count = 1;
                }
            }
        }
        return $res;
    }

    /**
     * Calculate Fuzzy Weight 
     * from Geometric Mean
     */
    private function calculateFuzzyWeight($matrix)
    {
        $inverse = [];
        $total = [];

        //calculate sum
        $i = 0;
        foreach ($matrix as $row) {
            $j = 0;
            foreach ($row as $val) {
                if ($i == 0) {
                    array_push($total, $val);
                } else {
                    $total[$j] += $val;
                }

                $j++;
            }
            $i++;
        }
        // inverse
        for ($i = 0; $i < 3; $i++) {
            array_push($inverse, 1 / $total[3 - $i - 1]);
        }

        // fuzzy weight
        for ($i = 0; $i < count($matrix); $i++) {
            for ($j = 0; $j < count($matrix[$i]); $j++) {
                $matrix[$i][$j] *= $inverse[$j];
            }
        }

        return $matrix;
    }


    /**
     * Normalize pairwise matrix
     */
    private function calculateNormalize($matrix)
    {
        $res = [];
        $sum = 0;
        foreach ($matrix as $row) {
            $total = 0;
            foreach ($row as $val) {
                $total += $val;
                // print($val." Total: ".$total."<br>");
            }
            array_push($res, $total / 3);
            $sum += $total / 3;
        }


        for ($i = 0; $i < count($res); $i++) {
            $res[$i] /= $sum;
        }

        return $res;
    }
}
