@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header">
            <h2>Edit brand</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('model.update', $model->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="nomModel" class="form-control" value="{{ $model->nomModel }}">
                    @error('nomModel')
                    <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Brand</label>
                    <input type="text" name="brand_id" class="form-control" value="{{ $model->brand_id }}" disabled>
                    <input type="hidden" name="brand_id" class="form-control" value="{{ $model->brand_id }}">
                    @error('brand_id')
                    <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="engine_type_id">Engine</label>
                    <select id="engine_type_id" name="engine_type_id" class="form-control">
                        @foreach($engineTypes as $engineType)
                            <option value="{{ $engineType?->id }}" {{ $model->engineType?->name === $engineType->name ? 'selected' : '' }}>{{ $engineType?->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex justify-content-between">
                    <a class="btn btn-secondary" href="{{ route('model.index') }}">Back</a>
                    <button type="submit" class="btn btn-primary m1-auto">Update</button>
                </div>
            </form>
        </div>
        <div class="card-footer"></div>
    </div>


@endsection
