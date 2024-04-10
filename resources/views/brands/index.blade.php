@extends('layouts.app')

@section('content')

    @if(session('success'))
        <div class="alert alert-success">{{session('success')}}</div>
    @endif

    <div class="d-flex justify-content-between">
        <div>
            <h1>List of brands :</h1>
        </div>
        <div>
            <a class="btn btn-success ml-auto" href="{{ route('brands.create') }}">Add a brand</a>
        </div>
    </div>

    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Country</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($brands as $key =>$val)
            <tr>
                <th scope="row">{{++$key}}</th>
                <td>{{$val->name}}</td>
                <td>{{$val->country}}</td>
                <td>
                    <a href="{{route('brands.show', $val->id)}}" class="btn btn-secondary mx-2">Show</a>
                    <a href="{{ route('brands.edit',$val->id) }}" class="btn btn-secondary mx-2">Edit</a>
                    <form action="{{ route('brands.destroy', $val->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger mx-2" onclick="return confirm('Are you sure you want to delete this brand?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{$brands->links()}}

@endsection

