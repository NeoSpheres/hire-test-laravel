@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header">
            <h2> Create a car</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('cars.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="idBrand">Brand :</label>
                    <select name="idBrand" id="idBrand" class="form-control">
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                    @error('idBrand')
                    <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="model_id">Model :</label>
                    <select name="model_id" id="model_id" class="form-control">
                        @foreach ($models as $model)
                            <option value="{{ $model->id }}">{{ $model->nomModel }}</option>
                        @endforeach
                    </select>
                    @error('model_id')
                    <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="user_id">Owner :</label>
                    <select name="user_id" id="user_id" class="form-control">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                    <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Country</label>
                    <input type="text" name="pays" class="form-control">
                    @error('pays')
                    <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="d-flex justify-content-between">
                    <a class="btn btn-secondary" href="{{route('cars.index')}}">Back</a>
                    <button type="submit" class="btn btn-primary m1-auto">Create</button>
                </div>
            </form>
        </div>
        <div class="card-footer"></div>
    </div>

@endsection
