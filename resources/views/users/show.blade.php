@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header">
            <h2> User details :</h2>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-center">
                <div>
                    <div class="mb-3">
                        <strong>Name : </strong>
                        {{$user->name}}
                    </div>
                    <div class="mb-3">
                        <strong>Email : </strong>
                        {{$user->email}}
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <a class="btn btn-secondary" href="{{route('user.index')}}">Back</a>
                <a class="btn btn-primary m1-auto" href="{{route('user.edit', $user->id)}}">Edit</a>
            </div>
        </div>
    </div>

@endsection
