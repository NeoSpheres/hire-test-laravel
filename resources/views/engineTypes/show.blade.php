@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header">
            <h2> Engine details :</h2>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-center">
                <div>
                    <div class="mb-3">
                        <strong>Name : </strong>
                        {{$engineType->name}}
                    </div>
                    <div class="mb-3">
                        <strong>Pollution : </strong>
                        {{$engineType->pollution_rate}}
                    </div>
                    <div class="mb-3">
                        <strong>Economy : </strong>
                        {{$engineType->economy_rate}}
                    </div>
                    <div class="mb-3">
                        <strong>Color : </strong>
                        {{$engineType->created_at}}
                    </div>
                    <div class="mb-3">
                        <strong>Type : </strong>
                        {{$engineType->updated_at}}
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <a class="btn btn-secondary" href="{{route('engine-type.index')}}">Back</a>
                <a class="btn btn-primary m1-auto" href="{{route('engine-type.edit', $engineType->id)}}">Edit</a>
            </div>
        </div>
    </div>

@endsection
