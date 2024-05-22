@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header">
            <h2> Create a car</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('engine-type.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control">
                    @error('name')
                    <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="pollution_rate">Pollution Rate</label>
                    <input type="number" name="pollution_rate" id="pollution_rate" class="form-control">
                    @error('pollution_rate')
                    <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="economy_rate">Economy Rate</label>
                    <input type="number" name="economy_rate" id="economy_rate" class="form-control">
                    @error('economy_rate')
                    <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="d-flex justify-content-between">
                    <a class="btn btn-secondary" href="{{route('engine-type.index')}}">Back</a>
                    <button type="submit" class="btn btn-primary m1-auto">Create</button>
                </div>
            </form>
        </div>
        <div class="card-footer"></div>
    </div>

@endsection
