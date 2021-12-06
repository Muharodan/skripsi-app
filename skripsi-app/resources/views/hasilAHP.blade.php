<!DOCTYPE html>
<html lang="en">
<x-header />

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hasil Fuzzy AHP</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

  <link rel="stylesheet" href="\css\app.css">
</head>

<body>
  <h1>HASIL FUZZY AHP</h1>
  <h2>ini contoh hasil tanpa perhitungan berdasarkan load time</h2>

  <table class="table table-striped">
    <!-- <thead> -->
      <tr>
        <th scope="col">Alternatif\Kriteria</th>
        <th scope="col">Broken Link</th>
        <th scope="col">Page Load Time</th>
        <th scope="col">Size</th>
      </tr>
    <!-- </thead> -->
    <!-- <tbody> -->
      <?php

        $result = Session::get('result')->result;
        // $keys = array_keys($result);
        // print_r($result);
        foreach($result as $row){
          echo "<tr>";
          foreach($row as $val){
            echo "<td>".$val."</td>";
          }
          echo "</tr>";
        }

      ?>
    <!-- </tbody> -->

    <!-- <tbody>
      <tr>
        <th scope="row">Amazon</th>
        <td>0.047 seconds</td>
        <td>281</td>
        <td>317</td>
      </tr>
      <tr>
        <th scope="row">Google</th>
        <td>0.102 Seconds</td>
        <td>16020 Bytes</td>
        <td>2</td>
      </tr>
      <tr>
        <th scope="row">Merriam-webster</th>
        <td>0.108 seconds</td>
        <td>143155</td>
        <td>22</td>
      </tr>
      <tr>
        <th scope="row">Apple</th>
        <td>0.82 seconds</td>
        <td>70443</td>
        <td>2</td>
      </tr>
      <tr>
        <th scope="row">Facebook</th>
        <td>2.12</td>
        <td>84027</td>
        <td>0</td>
      </tr>
    </tbody> -->
    
  </table>

  <br>
  <a class="fuzzyahp" href="/">
    <button class="btn btn-primary" name="home">home</button>
  </a>
</body>

</html>