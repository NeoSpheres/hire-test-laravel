@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header">
            <h2> Create a tire</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('tires.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Brand</label>
                    <input type="text" name="brand" class="form-control">
                    @error('brand')
                    <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Model</label>
                    <input type="text" name="model" class="form-control">
                    @error('model')
                    <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="type">Type</label>
                    <select name="type" id="type" class="form-control">
                        <option value="">Choose type</option>
                        @foreach ($tireTypes as $type)
                            <option value="{{ $type }}" {{old('type') == $type ? 'selected' : ''}}>{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                    @error('type')
                    <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a class="btn btn-secondary" href="{{route('tires.index')}}">Back</a>
                    <button type="submit" class="btn btn-primary m1-auto">Create</button>
                </div>
            </form>
        </div>
        <div class="card-footer"></div>
    </div>


@endsection
