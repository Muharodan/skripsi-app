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

  <table class="table table-striped">
    <tr>
      <th scope="col">Alternatif\Kriteria</th>
      <th scope="col">Broken Link</th>
      <th scope="col">Page Load Time</th>
      <th scope="col">Size</th>
    </tr>
    @foreach($result as $row)

    <tr>
      @foreach($row as $val)
      <td>{{$val}}</td>
      @endforeach
    </tr>

    @endforeach
  </table>
  {{ $result->links() }}


  <br>
  <a class="fuzzyahp" href="/">
    <button class="btn btn-primary" name="home">home</button>
  </a>
</body>

</html>