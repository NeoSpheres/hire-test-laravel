@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header">
            <h2> Car details :</h2>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-center">
                <div>
                    <div class="mb-3">
                        <strong>Brand : </strong>
                        {{$brand->name}}
                    </div>
                    <div class="mb-3">
                        <strong>Model : </strong>
                        {{$car->modele->nomModel}}
                    </div>
                    <div class="mb-3">
                        <strong>Registration : </strong>
                        {{$car->matricule}}
                    </div>
                    <div class="mb-3">
                        <strong>Color : </strong>
                        {{$car->color}}
                    </div>
                    <div class="mb-3">
                        <strong>Type : </strong>
                        {{$car->modele->engine}}
                    </div>

                    <div class="mb-3">
                        <strong>Front tire : </strong>
                        {{$car->frontTire->full_tire_name}}
                    </div>

                    <div class="mb-3">
                        <strong>Rear tire : </strong>
                        {{$car->rearTire->full_tire_name}}
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <a class="btn btn-secondary" href="{{route('cars.index')}}">Back</a>
                <a class="btn btn-primary m1-auto" href="{{route('cars.edit', $car->id)}}">Edit</a>
            </div>
        </div>
    </div>

@endsection
