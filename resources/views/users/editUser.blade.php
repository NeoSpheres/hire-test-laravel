@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header">
            <h2> User Edit</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('user.update',$data->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label>UserName</label>
                    <input type="text" name="name" class="form-control" value="{{$data->name}}">
                    @error('name')
                        <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{$data->email}}">
                    @error('email')
                        <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label>password</label>
                    <input type="password" name="password" class="form-control" value="{{$data->password}}">
                    @error('password')
                        <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="d-flex justify-content-between">
                    <a class="btn btn-secondary" href="{{route('user.index')}}">Back</a>
                    <button type="submit" class="btn btn-primary m1-auto">Update</button>
                </div>
            </form>
        </div>
        <div class="card-footer"></div>
    </div>

@endsection

