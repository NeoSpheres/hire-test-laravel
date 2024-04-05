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
    <div class="card">
        <div class="card-header">
            <h2> User Create</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('user.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>UserName</label>
                    <input type="text" name="name" class="form-control">
                    @error('username')<p class="text text-danger">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control">
                    @error('email')<p class="text text-danger">{{ $message }}</p>@enderror
                </div><div class="form-group">
                    <label>password</label>
                    <input type="password" name="password" class="form-control">
                    @error('password')<p class="text text-danger">{{ $message }}</p>@enderror
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
        <div class="card-footer"></div>
    </div>

</section>

</body>
</html>
