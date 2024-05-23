@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header">
            <h2> Tire details :</h2>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-center">
                <div>
                    <div class="mb-3">
                        <strong>Brand : </strong>
                        {{$tire->brand}}
                    </div>
                    <div class="mb-3">
                        <strong>Model : </strong>
                        {{$tire->model}}
                    </div>
                    <div class="mb-3">
                        <strong>Type : </strong>
                        {{ucfirst($tire->type)}}
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <a class="btn btn-secondary" href="{{route('tires.index')}}">Back</a>
                <a class="btn btn-primary m1-auto" href="{{route('tires.edit', $tire->id)}}">Edit</a>
            </div>
        </div>
    </div>

@endsection
