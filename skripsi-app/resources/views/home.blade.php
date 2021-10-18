@extends('master')
@section("content")
<!-- <h1>Home Page</h1> -->
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">First</th>
      <th scope="col">Last</th>
      <th scope="col">Handle</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Jacob</td>
      <td>Thornton</td>
      <td>@fat</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td colspan="2">Larry the Bird</td>
      <td>@twitter</td>
    </tr>
  </tbody>
</table>

<div class="buttons">
<a class="upload" >
    <form action="{{url('/process')}}" method="post" enctype="multipart/form-data">
      @csrf

      Select excel file to upload
      <br>

      <input type="file" name="file">
      <br>
      <br>

      <a class="fuzzyahp">
        <button class="btn btn-primary" name="fuzzy_ahp" id="ahp" type="submit">Fuzzy AHP</button>
      </a>
      
      <a class="fuzzytopsis">
        <button class="btn btn-primary" name="fuzzy_topsis" id="topsis" type="submit">Fuzzy topsis</button>
      </a>
    </form>
  </a>  
  <br>
  <!-- <a class="fuzzyahp" href="/hasilAHP">
    <button class="btn btn-primary" name="fuzzy ahp">fuzzy ahp</button>
  </a>
  <br>
  <a class="fuzzytopsis" href="/hasilTOPSIS">
    <button class="btn btn-primary" name="fuzzy topsis"> fuzzy topsis </button>
  </a> -->
  
</div>


@endsection