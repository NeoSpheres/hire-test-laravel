@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header">
            <h2>Create a brand</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('brands.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control">
                    @error('name')
                    <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Counrty</label>
                    <input type="text" name="country" class="form-control">
                    @error('country')
                    <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="d-flex justify-content-between">
                    <a class="btn btn-secondary" href="{{route('brands.index')}}">Back</a>
                    <button type="submit" class="btn btn-primary m1-auto">Create</button>
                </div>
            </form>
        </div>
        <div class="card-footer"></div>
    </div>

@endsection
