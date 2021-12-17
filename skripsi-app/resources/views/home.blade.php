<!DOCTYPE html>
<html lang="en">
<x-header />

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Penilaian Website Secara Automatis</title>
  <style type="text/css">
    .buttons {}
  </style>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

  <link rel="stylesheet" href="\css\app.css">

</head>

<body>
  <div class="buttons d-flex justify-content-center">
    <!-- <a class="upload"> -->
    <form action="{{url('/proses')}}" method="post" enctype="multipart/form-data">
      @csrf

      <!-- Select excel file to upload
      <br>

      <input type="file" name="file">
      <br>
      <br> -->
      <h5>Silakan pilih kategori</h5>
      <select class="form-select" name="kategori" aria-label="Default select example" required>
        <option value="0">All</option>
        @foreach($kategori as $k)
        <option value={{$k['id']}}>{{$k['nama_kategori']}}</option>
        @endforeach
      </select>

      <br>
      <!-- <a class="fuzzyahp"> -->
      <button class="btn btn-primary" name="btn" id="ahp" type="submit" value="1">Fuzzy AHP</button>
      <!-- </a> -->

      <!-- <a class="fuzzytopsis"> -->
      <button class="btn btn-primary" name="btn" id="topsis" type="submit" value="2">Fuzzy topsis</button>
      <!-- </a> -->
    </form>
    <!-- </a> -->
  </div>

  <a href="/compare">
    <button class="btn btn-primary">Compare</button>
  </a>
  
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
      @foreach ($listWeb as $list)
      <tr>
        <td>{{ $list->nama_web}}</td>
        <td>{{ $list->broken_link}}</td>
        <td>{{ $list->page_load_time}}</td>
        <td>{{ $list->size_web}}</td>
      </tr>
      @endforeach

      <!-- <tr>
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
      </tr> -->
    </tbody>
  </table>
  {{$listWeb->links()}}
</body>

</html>