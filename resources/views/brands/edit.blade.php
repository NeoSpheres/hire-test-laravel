@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header">
            <h2>Edit brand</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('brands.update',$brand->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{$brand->name}}">
                    @error('name')
                    <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Country</label>
                    <input type="text" name="country" class="form-control" value="{{$brand->country}}">
                    @error('country')
                    <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="d-flex justify-content-between">
                    <a class="btn btn-secondary" href="{{route('brands.index')}}">Back</a>
                    <button type="submit" class="btn btn-primary m1-auto">Update</button>
                </div>
            </form>
        </div>
        <div class="card-footer"></div>
    </div>

@endsection

