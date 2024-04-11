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
                    <label for="brand_id">Brand :</label>
                    <select name="brand_id" id="brand_id" class="form-control">
                        <option value="">Choose a brand</option>
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
                    <select name="model_id" id="model_id"  disabled class="form-control">
                    </select>
                    @error('model_id')
                    <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="user_id">Owner :</label>
                    <select name="user_id" id="user_id" class="form-control">
                        <option value=""></option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                    <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Color</label>
                    <input type="text" name="color" class="form-control">
                    @error('color')
                    <p class="text text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="matricule">Registration</label>
                    <input type="text" name="matricule" class="form-control" value="{{ $matricule }}" readonly disabled>
                    <input type="hidden" name="matricule_hidden" value="{{ $matricule }}">
                    @error('matricule')
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

    <script>
        document.getElementById('idBrand').addEventListener('change', function() {
            var brandId = this.value;
            console.log(brandId);
            var modelSelect = document.getElementById('model_id');

            modelSelect.innerHTML = '<option value="">Choose a model</option>';

            // Filtrer les modèles en fonction de la marque sélectionnée
            @foreach($models as $model)
            if ({{ $model->idBrand }} == brandId) {
                var option = document.createElement('option');
                option.value = '{{ $model->id }}';
                option.textContent = '{{ $model->nomModel }}';
                modelSelect.appendChild(option);
            }
            @endforeach

            /*let models = @json($models);
            models.forEach(function(model) {
                if (model.idBrand == brandId) {
                    var option = document.createElement('option');
                    option.value = model.id;
                    option.textContent = model.nomModel;
                    modelSelect.appendChild(option);
                }
            });*/

            modelSelect.disabled = false;
        });
    </script>

@endsection
