@extends('layouts.app')

@section('content')

    @if(session('success'))
        <div class="alert alert-success">{{session('success')}}</div>
    @endif

    <div class="d-flex justify-content-between">
        <div>
            <h1>List Model :</h1>
        </div>
        <div>
            <a class="btn btn-success ml-auto" href="{{ route('model.create') }}">Add car</a>
        </div>
    </div>

    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th>Model</th>
            <th>Engine</th>
            <th>Brand</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $key => $val)
            <tr>
                <th scope="row">{{ ++$key }}</th>
                <td>{{ $val->nomModel }}</td>
                <td>{{ $val->engine }}</td>
                <td>{{ $val->brand ? $val->brand->name : 'No brand' }}</td> <!-- Vérification de la marque avant d'accéder à 'name' -->
                <td>
                    <a href="{{ route('model.show', $val->id) }}" class="btn btn-secondary mx-2">Show</a>
                    <a href="{{ route('model.edit', $val->id) }}" class="btn btn-secondary mx-2">Edit</a>
                    <form action="{{ route('user.destroy', $val->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger mx-2" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{$data->links()}}

@endsection

