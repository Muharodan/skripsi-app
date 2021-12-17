<!DOCTYPE html>
<html lang="en">
<x-header />

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Penilaian Website Secara Automatis</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <link rel="stylesheet" href="\css\app.css">

</head>

<body>
    <div class="d-flex justify-content-center">
        <!-- <a class="upload"> -->
        <form action="{{url('/compare')}}" method="post">
            @csrf

            <table>
                <tr>
                    <td>
                        <input type="text" id="myLeft" onkeyup="searchLeft()" placeholder="Search for names.." title="Type in a name" style="float: right;">
                    </td>
                    <td>
                        <input type="text" id="myRight" onkeyup="searchRight()" placeholder="Search for names.." title="Type in a name" style="float: right;">
                    </td>
                </tr>
                <tr style="margin-top: 20px;">
                    <td>
                        <div style="overflow: auto; height: 300px; width: 400px;">
                            <ul id="left">
                                @foreach($listWeb as $web)
                                <li class="li-left">
                                    <label for="data-left-{{$web->id}}" class="label-left"> {{$web->nama_web}}</label>
                                    <input type="checkbox" name="data-left-{{$web->id}}" value="{{$web->id}}" style="float: right; margin-right: 15px;">

                                </li>
                                @endforeach
                            </ul>
                        </div>

                    </td>
                    <td>
                        <div style="overflow: auto; height: 300px; width: 400px;">
                            <ul id="right">
                                @foreach($listWeb as $web)
                                <li class="li-right">
                                    <label for="data-right-{{$web->id}}" class="label-right"> {{$web->nama_web}}</label>
                                    <input type="checkbox" name="data-right-{{$web->id}}" value="{{$web->id}}" style="float: right; margin-right: 15px;">

                                </li>
                                @endforeach
                            </ul>
                        </div>

                    </td>
                </tr>
            </table>

            <br>
            <button class="btn btn-primary" name="btn" type="submit" value="compare" style="float: right;">Compare</button>
        </form>
    </div>

</body>

</html>

<script>
    function searchLeft() {
        var input, filter, ul, li, label, i, txtValue;
        input = document.getElementById("myLeft");
        filter = input.value.toUpperCase();
        ul = document.getElementById("left");
        li = ul.getElementsByClassName("li-left");
        for (i = 0; i < li.length; i++) {
            label = li[i].getElementsByClassName("label-left")[0];
            txtValue = label.textContent || label.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    }

    function searchRight() {
        var input, filter, ul, li, label, i, txtValue;
        input = document.getElementById("myRight");
        filter = input.value.toUpperCase();
        ul = document.getElementById("right");
        li = ul.getElementsByClassName("li-right");
        for (i = 0; i < li.length; i++) {
            label = li[i].getElementsByClassName("label-right")[0];
            txtValue = label.textContent || label.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    }
</script>