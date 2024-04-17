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
                    <th>Id</th>
                    <th>Model</th>
                    <th>Owner</th>
                    <th>Color</th>
                    <th>Matricule</th>
                    <th>Action </th>
                </thead>
                <tbody>
                @forelse($cars as $car)
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
                @empty
                    <tr>
                        <td colspan="5">
                            <p class="text-danger"> no Cars found</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
