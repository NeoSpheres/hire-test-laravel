@extends('layouts.app')

@section('content')

    @if(session('success'))
        <div class="alert alert-success">{{session('success')}}</div>
    @endif

    <div class="d-flex justify-content-between">
        <div>
            <h1>List of cars :</h1>
        </div>
        <div>
            <a class="btn btn-success ml-auto" href="{{ route('cars.create') }}">Add car</a>
        </div>
    </div>

    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th>Brand</th>
            <th>Model</th>
            <th>Owner</th>
            <th>Front tire</th>
            <th>Rear tire</th>
            <th>Color</th>
            <th>Registration</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($cars as $key =>$val)
            <tr>
                <th scope="row">{{++$key}}</th>
                <td>{{ $val->modele->brand->name }}</td>
                <td>{{ $val->modele->nomModel }}</td>
                <td>{{ $val->user ? $val->user->name : '' }}</td>
                <td>{{ $val->frontTire->full_tire_name }}</td>
                <td>{{ $val->rearTire->full_tire_name }}</td>
                <td>{{ $val->color }}</td>
                <td>{{ $val->matricule }}</td>
                <td>
                    <a href="{{route('cars.show', $val->id)}}" class="btn btn-secondary mx-2">Show</a>
                    <a href="{{ route('cars.edit',$val->id) }}" class="btn btn-secondary mx-2">Edit</a>
                    <form action="{{ route('cars.destroy', $val->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger mx-2" onclick="return confirm('Are you sure you want to delete this car?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{$cars->links()}}

@endsection

