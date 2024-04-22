@extends('layouts.app')

@section('content')

    <div id="successForm"></div>

    <div class="d-flex justify-content-between">
        <div>
            <h1>List of models :</h1>
        </div>
        <div>
            <a class="btn btn-success ml-auto" onclick="add()" href="javascript:void(0)">Add a model</a>
        </div>
    </div>

    <table class="table" id="myModelsTable">
        <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Model</th>
            <th>Brand</th>
            <th>Engine</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        <!---->
        </tbody>
    </table>

    <!-- Modal for adding a model -->
    <div class="modal fade" id="model-modal" tabindex="-1" aria-labelledby="model-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modelModalLabel">Add a model</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul id="errsForm"></ul>
                    <form action="javascript:void(0)" id="modelForm" name="modelForm">
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
                            <label for="brand_id">Brand:</label>
                            <select id="brand_id" name="brand_id" class="form-control">
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="btn-save" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for editing a model -->
    <div class="modal fade" id="edit-model-modal" tabindex="-1" aria-labelledby="edit-model-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="edit-modelModalLabel">Edit model</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul id="errs-editForm"></ul>
                    <form action="javascript:void(0)" id="edit-modelForm" name="edit-modelForm">
                        @csrf
                        <input type="hidden" name="edit-id" id="edit-id">
                        <input type="hidden" name="editBrand-id" id="editBrand-id">
                        <div class="form-group">
                            <label>Brand</label>
                            <input type="text" name="edit-brand_id" id="edit-brand_id" disabled class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Model</label>
                            <select name="edit-nomModel" id="edit-nomModel" class="form-control"></select>
                        </div>
                        <div class="form-group">
                            <label>Engine</label>
                            <select id="edit-engine" name="edit-engine" class="form-control">
                                <option selected>Electric</option>
                                <option value="Hybrid">Hybrid</option>
                                <option value="Electric">Electric</option>
                                <option value="Petrol">Petrol</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="btn-edit-save" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for model details -->
    <div class="modal fade" id="details-model-modal" tabindex="-1" aria-labelledby="details-model-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="details-modelModalLabel">Model details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="model-details-body">
                    <!---->
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        var myModelsTable;
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var brands = {!! $brands !!}; //liste des marques
            //console.log(brands);

            myModelsTable = $('#myModelsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('ajax-models/fetch') }}",
                columns: [
                    { data: 'id' },
                    { data: 'nomModel', name: 'nomModel' },
                    {
                        data: 'brand_id',
                        name: 'brand-id',
                        render: function (data) {
                            var brand = brands.find(function(brand) {
                                return brand.id === data;
                            });
                            return brand ? brand.name : data;
                        }
                    },
                    { data: 'engine', name: 'engine' },

                    {
                        data: null,
                        searchable: false,
                        orderable: false,
                        render: function (data, type, row) {
                            return `
                                <button class="btn btn-secondary mx-2" onclick="edit(${row.id})">Edit</button>
                                <button class="btn btn-secondary mx-2" onclick="show(${row.id})">Show</button>
                                <button class="btn btn-danger mx-2" onclick="remove(${row.id})">Delete</button>
                            `;
                        }
                    },
                ],
                order: [[0, 'desc']],
            });

            $('#modelForm').submit(function (e) {
                e.preventDefault();

                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('ajax-models.store') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                        $('#errsForm').html("").removeClass('alert alert-danger');
                        $('#successForm').html("").removeClass('alert alert-success');

                        //console.log(response);
                        response.status === 400 ?
                            handleError(response) :
                            handleSuccess(response);

                        myModelsTable.ajax.reload();
                    },
                });
            });

            $('#edit-modelForm').submit(function (e) {
                e.preventDefault();

                var id = $('#edit-id').val();
                //console.log(id);
                var idB = $('#editBrand-id').val();
                //console.log(idB);
                var data = {
                    'nomModel': $('#edit-nomModel').val(),
                    'brand_id': idB,
                    'engine': $('#edit-engine').val(),
                }
                $.ajax({
                    type: 'PATCH',
                    url: "{{ route('ajax-models.update', ['id' => '']) }}" + id,
                    data: data,
                    dataType: 'json',
                    success: (response) => {
                        //console.log(response);
                        if (response.status === 400) {
                            $('#errs-editForm').empty().addClass('alert alert-danger');
                            $.each(response.errors, function (key, val) {
                                $('#errs-editForm').append('<li>'+val+'</li>');
                            });
                        }else {
                            $('#successForm').addClass('alert alert-success').text(response.message);

                            $('#edit-model-modal').modal('hide');
                            $('#btn-edit-save').html('submit').attr('disabled', false);

                            myModelsTable.ajax.reload();
                        }
                    },
                });
            });

        });

        function show(id) {
            $('#details-model-modal').modal('show');
            $.ajax({
                type: 'GET',
                url: "{{ route('ajax-models.show') }}",
                data: {id: id},
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    var html = '<div class="card">' +
                        '<div class="card-body">' +
                        '<div class="mb-3">' +
                        '<strong>Modèle : </strong>' + response.data.nomModel +
                        '</div>' +
                        '<div class="mb-3">' +
                        '<strong>Marque : </strong>' + response.brand.name +
                        '</div>' +
                        '<div class="mb-3">' +
                        '<strong>Type : </strong>' + response.data.engine +
                        '</div>' +
                        '</div>' +
                        '</div>';

                    $('#model-details-body').html(html);
                    $('#details-model-modal').modal('show');
                },
            });
        }

        function remove(id) {
            if (confirm('Are you sure you want to delete this model?')) {
                $.ajax({
                    type: 'DELETE',
                    url: "{{ route('ajax-models.destroy', ['id' => '']) }}" +id,
                    data: {id: id},
                    dataType: 'json',
                    success: (response) => {
                        //console.log(response);
                        $('#successForm').addClass('alert alert-success').text(response.message);

                        myModelsTable.ajax.reload();
                    },
                });
            }
        }

        function edit(id) {
            $('#edit-model-modal').modal('show');
            $.ajax({
                type: "GET",
                url: "{{ route('ajax-models.edit') }}",
                data: {id: id},
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    $('#edit-id').val(response.data.id);
                    $('#editBrand-id').val(response.data.brand_id);
                    $('#edit-nomModel').val(response.data.nomModel);
                    $('#edit-brand_id').val(response.brand.name);
                    $('#edit-engine').val(response.data.engine);

                    fetch('/get-models/' + response.brand.id)
                        .then(response => response.json())
                        .then(data => {
                            var modelSelect = $('#edit-nomModel');
                            modelSelect.empty();
                            var modelNames = new Set();

                            var currentOption = $('<option>').val(response.data.nomModel).text(response.data.nomModel);
                            modelSelect.append(currentOption);
                            modelNames.add(response.data.nomModel);

                            data.forEach(function(model) {
                                if (!modelNames.has(model.nomModel)) {
                                    var option = $('<option>').val(model.nomModel).text(model.nomModel);
                                    modelSelect.append(option);
                                    modelNames.add(model.nomModel);
                                }
                            });
                        });

                }
            });
        }

        function add() {
            $('#modelForm').trigger('reset');
            $('#modelModal').html("Add model");
            $('#model-modal').modal('show');
        }

        function handleError(response) {
            $('#errsForm').addClass('alert alert-danger');
            $.each(response.errors, function (key, val) {
                $('#errsForm').append('<li>'+val+'</li>');
            });
        }

        function handleSuccess(response) {
            $('#successForm').addClass('alert alert-success').text(response.message);

            $('#model-modal').modal('hide');
            $('#btn-save').html('submit').attr('disabled', false);
        }

    </script>

@endsection

