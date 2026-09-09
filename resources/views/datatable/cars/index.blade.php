@extends('layouts.app')
@section('content')
@include('datatable.cars.create')
    <div class="container">
        <div class="row">
            <div class="col-xl-6">
                <div id="response"></div>
            </div>
            <div class="col-xl-6 text-end">
                <a href="javascript:void(0)" id="create-todo-btn" class="btn btn-primary">Create Car</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table striped" id="todo-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Model</th>
                        <th>Owner</th>
                        <th>Color</th>
                        <th>Reg. plate</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($cars as $car)
                    <tr id="{{'car_'.$car->id}}">
                        <td>{{$car->id}}</td>
                        <td>{{$car->model_id}}</td>
                        <td>{{$car->user_id}}</td>
                        <td>{{$car->color}}</td>
                        <td>{{$car->matricule}}</td>
                        <td>
                            <a class="btn btn-info btn-sm btn-view" href="javascript:void(0)" data-id="{{$car->id}}">View</a>
                            <a class="btn btn-success btn-sm btn-edit" on href="javascript:void(0)" data-id="{{$car->id}}">Edit</a>
                            <a class="btn btn-danger btn-sm btn-delete" href="javascript:void(0)" data-id="{{$car->id}}">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if($cars->isEmpty())
                <p class="text-danger">No cars found.</p>
            @endif
        </div>
    </div>
@endsection
