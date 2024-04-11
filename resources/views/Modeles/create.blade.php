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
                    <label>Engine</label>
                    <select id="engine" name="engine" class="form-control">
                        <option selected>Hybrid</option>
                        <option value="Hybrid">Hybrid</option>
                        <option value="Electric">Electric</option>
                        <option value="Petrol">Petrol</option>
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
