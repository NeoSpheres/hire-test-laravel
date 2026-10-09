<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-4.6.2/css/bootstrap.min.css') }}">

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
            <th scope="col">UserName</th>
            <th scope="col">Email</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $key =>$val)
        <tr>
            <th scope="row">{{++$key}}</th>
            <td>{{$val->name}}</td>
            <td>{{$val->email}}</td>
            <td>
                <a href="{{ route('user.edit',$val->id) }}" class="btn btn-secondary">Edit</a>
                <a href="{{ route('user.show',$val->id) }}" class="btn btn-danger">Delete</a>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</section>

</body>
</html>
