<!DOCTYPE html>
<html lang="en">
<x-header />

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Document</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

  <link rel="stylesheet" href="\css\app.css">

</head>

<body>
  <h1>Data Website</h1>
  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">Alternatif\Kriteria</th>
        <th scope="col">Page Load Time</th>
        <th scope="col">Size</th>
        <th scope="col">Broken Link</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Google</th>
        <td>0.102 Seconds</td>
        <td>16020 Bytes</td>
        <td>2</td>
      </tr>
      <tr>
        <th scope="row">Facebook</th>
        <td>2.12</td>
        <td>84027</td>
        <td>0</td>
      </tr>
      <tr>
        <th scope="row">Amazon</th>
        <td>0.047 seconds</td>
        <td>281</td>
        <td>317</td>
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
    </tbody>
  </table>

  <div class="buttons">
    <!-- <a class="upload" >
    <form action="{{url('/hasilAHP')}}" method="post" enctype="multipart/form-data">
      @csrf

      Select excel file to upload
      <br>

      <input type="file" name="file">
      <br>
      <br>

      <a class="fuzzyahp">
        <button class="btn btn-primary" name="btn" id="ahp" type="submit" value="1">Fuzzy AHP</button>
      </a>
      
      <a class="fuzzytopsis">
        <button class="btn btn-primary" name="btn" id="topsis" type="submit" value="2">Fuzzy topsis</button>
      </a>
    </form>
  </a>   -->
    <br>
    <a class="fuzzyahp" href="/hasilAHP">
      <button class="btn btn-primary" name="fuzzy ahp">fuzzy ahp</button>
    </a>
    <a class="fuzzytopsis" href="/hasilTOPSIS">
      <button class="btn btn-primary" name="fuzzy topsis"> fuzzy topsis </button>
    </a>

  </div>
</body>

</html>