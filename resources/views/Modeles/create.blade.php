@extends('layouts.app')

@section('content')

    <div class="card">
        <h2>Model Create</h2>
        <div class="card-body">
            <form method="POST" action="{{ route('model.store') }}">
                @csrf
                <div>
                    <label for="nom">Model:</label>
                    <input type="text" id="nomModel" name="nomModel" class="form-control">
                </div>

                <div class="form-group">
                    <label for="engine_type_id">Engine Type</label>
                    <select id="engine_type_id" name="engine_type_id" class="form-control">
                        @foreach($engineTypes as $engineType)
                            <option value="{{ $engineType->id }}">{{ $engineType->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="brand_id">idBrand:</label>
                    <select id="brand_id" name="brand_id" class="form-control">
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-primary m1-auto">Ajouter</button>
                </div>

            </form>
        </div>
    </div>
@endsection

