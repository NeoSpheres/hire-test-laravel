@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header">
            <h2> Update a tire</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('tires.update', $tire->id) }}" method="POST">
                @csrf
                @method("PUT")
                <div class="form-group">
                    <label for="brand">Brand</label>
                    <input type="text" name="brand" id="brand" class="form-control" value="{{old("brand", $tire->brand)}}">
                    @error('brand')
                        <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="model">Model</label>
                    <input type="text" name="model" id="model" class="form-control" value="{{old("model", $tire->model)}}">
                    @error('model')
                        <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="type">Type</label>
                    <select name="type" id="type" class="form-control">
                        <option value="">Choose type</option>
                        @foreach ($tireTypes as $type)
                            <option value="{{ $type }}" {{old('type', $tire->type) == $type ? 'selected' : ''}}>{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                    @error('type')
                    <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a class="btn btn-secondary" href="{{route('tires.index')}}">Back</a>
                    <button type="submit" class="btn btn-primary m1-auto">Update</button>
                </div>
            </form>
        </div>
        <div class="card-footer"></div>
    </div>


@endsection
