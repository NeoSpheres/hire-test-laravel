@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header">
            <h2> Brand details :</h2>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-center">
                <div>
                    <div class="mb-3">
                        <strong>Name : </strong>
                        {{$brand->name}}
                    </div>
                    <div class="mb-3">
                        <strong>Country : </strong>
                        {{$brand->country}}
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <a class="btn btn-secondary" href="{{route('brands.index')}}">Back</a>
                <a class="btn btn-primary m1-auto" href="{{route('brands.edit', $brand->id)}}">Edit</a>
            </div>
        </div>
    </div>

@endsection
