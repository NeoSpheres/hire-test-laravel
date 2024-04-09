@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header">
            <h2>Edit car</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('cars.update',$car->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label>Brand</label>
                    <select name="idBrand" id="id_Brand" class="form-control">
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                    @error('idBrand')
                    <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Model</label>
                    <input type="text" name="model" class="form-control" value="{{$car->modele->nomModel}}">
                    @error('model')
                    <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Registration</label>
                    <input type="text" name="matricule" class="form-control" value="{{$car->modele->matricule}}">
                    @error('matricule')
                    <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Color</label>
                    <input type="text" name="color" class="form-control" value="{{$car->modele->color}}">
                    @error('color')
                    <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Type</label>
                    <input type="text" name="engine" class="form-control" value="{{$car->modele->engine}}">
                    @error('engine')
                    <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="d-flex justify-content-between">
                    <a class="btn btn-secondary" href="{{route('cars.index')}}">Back</a>
                    <button type="submit" class="btn btn-primary m1-auto">Update</button>
                </div>
            </form>
        </div>
        <div class="card-footer"></div>
    </div>

@endsection

