@extends('layouts.app')

@section('content')

    @if(session('success'))
        <div class="alert alert-success">{{session('success')}}</div>
    @endif

    <div class="d-flex justify-content-between">
        <div>
            <h1>List of engines :</h1>
        </div>
        <div>
            <a class="btn btn-success ml-auto" href="{{ route('engine-type.create') }}">Add Engine</a>
        </div>
    </div>

    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th>Name</th>
            <th>Pollution rate</th>
            <th>Economy rate</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $key =>$val)
            <tr>
                <th scope="row">{{++$key}}</th>
                <td>{{ $val->name }}</td>
                <td>{{ $val->pollution_rate }}</td>
                <td>{{ $val->economy_rate }}</td>
                <td>
                    <a href="{{route('engine-type.show', $val->id)}}" class="btn btn-secondary mx-2">Show</a>
                    <a href="{{ route('engine-type.edit',$val->id) }}" class="btn btn-secondary mx-2">Edit</a>
                    <form action="{{ route('engine-type.destroy', $val->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger mx-2" onclick="return confirm('Are you sure you want to delete this engine?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{$data->links()}}

@endsection

