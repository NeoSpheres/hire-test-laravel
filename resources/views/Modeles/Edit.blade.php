@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header">
            <h2>Edit car</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('model.update',$model->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label>Brand</label>
                    <select name="brand_id" id="brand_id" class="form-control" >
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Model</label>
                    <select name="id" id="id" class="form-control">
                        <option value="">Select a model</option>
                        {{-- This will be populated dynamically based on the selected brand --}}
                    </select>
                </div>
                <div class="form-group">
                    <label for="engine_type_id">Engine Type</label>
                    <select id="engine_type_id" name="engine_type_id" class="form-control">
                        @foreach($engineTypes as $engineType)
                            <option value="{{ $engineType->id }}">{{ $engineType->name }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="d-flex justify-content-between">
                    <a class="btn btn-secondary" href="{{route('model.index')}}">Back</a>
                    <button type="submit" class="btn btn-primary m1-auto">Update</button>
                </div>
            </form>
        </div>
        <div class="card-footer"></div>
    </div>

    <script>
        // Attach an event listener to the brand select element
        // Attach an event listener to the brand select element
        document.getElementById('brand_id').addEventListener('change', function() {
            var brandId = this.value;

            // Send an AJAX request to get the models associated with the selected brand
            fetch('/get-models/' + brandId)
                .then(response => response.json())
                .then(data => {
                    var modelSelect = document.getElementById('id');
                    modelSelect.innerHTML = '<option value="">Select a model</option>';
                    data.forEach(function(model) {
                        var option = document.createElement('option');
                        option.value = model.id;
                        option.text = model.nomModel;
                        modelSelect.appendChild(option);
                    });
                });
        });

    </script>
@endsection

