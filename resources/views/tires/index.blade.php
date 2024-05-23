@extends('layouts.app')

@section('content')

    @if(session('success'))
        <div class="alert alert-success">{{session('success')}}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{session('error')}}</div>
    @endif

    <div class="d-flex justify-content-between">
        <div>
            <h1>List of tires :</h1>
        </div>
        <div>
            <a class="btn btn-success ml-auto" href="{{ route('tires.create') }}">Add tire</a>
        </div>
    </div>

    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th>Brand</th>
            <th>Model</th>
            <th>Type</th>
            <th>Cars front count</th>
            <th>Cars rear count</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tires as $key => $tire)
            <tr>
                <th scope="row">{{++$loop->index}}</th>
                <td>{{ $tire->brand }}</td>
                <td>{{ $tire->model }}</td>
                <td>{{ ucfirst($tire->type) }}</td>
                <td>{{$tire->carFrontTire->count()}}</td>
                <td>{{$tire->carRearTire->count()}}</td>
                <td>
                    <a href="{{route('tires.show', $tire->id)}}" class="btn btn-secondary mx-2">Show</a>
                    <a href="{{ route('tires.edit',$tire->id) }}" class="btn btn-secondary mx-2">Edit</a>
                    <form action="{{ route('tires.destroy', $tire->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger mx-2" onclick="return confirm('Are you sure you want to delete this car?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{$tires->links()}}

@endsection

