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
                    <select name="brand_id" id="brand_id" class="form-control">
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                    @error('brand_id')
                    <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Model</label>
                    <select name="model_id" id="model_id" class="form-control" disabled>
                        <option value="{{$car->modele->id}}">{{$car->modele->nomModel}}</option>
                    </select>
                    @error('model_id')
                    <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Registration</label>
                    <input type="text" name="matricule" class="form-control" value="{{$car->matricule}}" disabled>
                    @error('matricule')
                    <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Color</label>
                    <input type="text" name="color" class="form-control" value="{{$car->color}}">
                    @error('color')
                    <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="front_tire_id">Front tire:</label>
                    <select name="front_tire_id" id="front_tire_id" class="form-control">
                        <option value="0">Choose</option>
                        @foreach ($tires as $tire)
                            <option value="{{ $tire->id }}" {{old('front_tire_id', $car->front_tire_id) == $tire->id ? 'selected' : ''}}>
                                {{ $tire->brand . " / " . $tire->model ." / " . $tire->type }}</option>
                        @endforeach
                    </select>
                    @error('front_tire_id')
                    <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="rear_tire_id">Rear tire:</label>
                    <select name="rear_tire_id" id="rear_tire_id" class="form-control">
                        <option value="0">Choose</option>
                        @foreach ($tires as $tire)
                            <option value="{{ $tire->id }}" {{old('rear_tire_id', $car->rear_tire_id) == $tire->id ? 'selected' : ''}}>
                                {{ $tire->brand . " / " . $tire->model ." / " . $tire->type }}</option>
                        @endforeach
                    </select>
                    @error('rear_tire_id')
                    <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>

                {{--<div class="form-group">
                    <label>Type</label>
                    <select id="engine" name="engine" class="form-control">
                        @foreach(['Hybrid', 'Electric', 'Petrol'] as $type)
                            <option value="{{ $type }}" {{ $car->modele->engine == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                    @error('engine')
                    <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>--}}
                <div class="d-flex justify-content-between">
                    <a class="btn btn-secondary" href="{{route('cars.index')}}">Back</a>
                    <button type="submit" class="btn btn-primary m1-auto">Update</button>
                </div>
            </form>
        </div>
        <div class="card-footer"></div>
    </div>

    <script>
        document.getElementById('brand_id').addEventListener('change', function() {
            var brandId = this.value;
            console.log(brandId);
            var modelSelect = document.getElementById('model_id');

            modelSelect.innerHTML = '<option value="">Choose a model</option>';

            // Filtrer les modèles en fonction de la marque sélectionnée
            @foreach($models as $model)
            if ({{ $model->brand_id }} == brandId) {
                var option = document.createElement('option');
                option.value = '{{ $model->id }}';
                option.textContent = '{{ $model->nomModel }}';
                modelSelect.appendChild(option);
            }
            @endforeach

            {{--let models = @json($models);
            models.forEach(function(model) {
                if (model.idBrand == brandId) {
                    var option = document.createElement('option');
                    option.value = model.id;
                    option.textContent = model.nomModel;
                    modelSelect.appendChild(option);
                }
            });--}}

            modelSelect.disabled = false;
        });
    </script>

@endsection
