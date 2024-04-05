<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>
<body>
<section class="container mt-5">
    @if(session('success'))
        <div class="alert alert-success">{{session('success')}}</div>
    @endif
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
                <th scope="col">Handle</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $key =>$val) @endforeach
            <tr>
                <th scope="row">{{++$key}}</th>
                <td>{{$val->name}}</td>
                <td>{{$val->email}}</td>
                <td>
                    <a href="{{ route('user.edit',$val->id) }}" class="btn btn-secondary">Edit</a>
                    <a href="{{ route('user.destroy',$val->id) }}" class="btn btn-danger">Delete</a>
                </td>
            </tr>
            </tbody>
        </table>
</section>

</body>
</html>
