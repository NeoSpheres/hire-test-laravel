@extends('layouts.app')

@section('content')

   <div id="successForm"></div>

    <div class="d-flex justify-content-between">
        <div>
            <h1>List of brands :</h1>
        </div>
        <div>
            <a class="btn btn-success ml-auto" onclick="add()" href="javascript:void(0)">Add a brand</a>
        </div>
    </div>

    <table class="table" id="myBrandsTable">
        <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th scope="col">Name</th>
            <th scope="col">Country</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
            <!---->
        </tbody>
    </table>

    <!-- Modal for adding a brand -->
    <div class="modal fade" id="brand-modal" tabindex="-1" aria-labelledby="brand-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="brandModalLabel">Add a brand</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul id="errsForm"></ul>
                    <form action="javascript:void(0)" id="brandForm" name="brandForm">
                        @csrf
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" id="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Counrty</label>
                            <input type="text" name="country" id="country" class="form-control">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="btn-save" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

   <!-- Modal for editing a brand -->
   <div class="modal fade" id="edit-brand-modal" tabindex="-1" aria-labelledby="edit-brand-modalLabel" aria-hidden="true">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <h1 class="modal-title fs-5" id="edit-brandModalLabel">Edit brand</h1>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                   <ul id="errs-editForm"></ul>
                   <form action="javascript:void(0)" id="edit-brandForm" name="edit-brandForm">
                       @csrf
                       <input type="hidden" name="edit-id" id="edit-id">
                       <div class="form-group">
                           <label>Name</label>
                           <input type="text" name="edit-name" id="edit-name" class="form-control">
                       </div>
                       <div class="form-group">
                           <label>Country</label>
                           <input type="text" name="edit-country" id="edit-country" class="form-control">
                       </div>
                       <div class="modal-footer">
                           <button type="submit" id="btn-edit-save" class="btn btn-primary">Update</button>
                       </div>
                   </form>
               </div>
           </div>
       </div>
   </div>

   <!-- Modal for brand details -->
   <div class="modal fade" id="details-brand-modal" tabindex="-1" aria-labelledby="details-brand-modalLabel" aria-hidden="true">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <h1 class="modal-title fs-5" id="details-brandModalLabel">Brand details</h1>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body" id="brand-details-body">
                   <!---->
               </div>
           </div>
       </div>
   </div>


    <script type="text/javascript">
        var myBrandsTable;
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            myBrandsTable = $('#myBrandsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('ajax-brands/fetch') }}",
                {{--ajax: {
                    url: '/ajax-brands/fetch',
                    type: 'GET',
                    dataSrc: 'data'
                },--}}
                columns: [  // Doit être specifier sinon pas de chargement des données
                    { data: 'id' },
                    {data: 'name', name: 'name'},
                    {data: 'country', name: 'country'},
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

            $('#brandForm').submit(function (e) {
                e.preventDefault();

                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('ajax-brands.store') }}",
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

                        myBrandsTable.ajax.reload();
                    },
                });
            });

            $('#edit-brandForm').submit(function (e) {
                e.preventDefault();

                var id = $('#edit-id').val();
                var data = {
                    'name': $('#edit-name').val(),
                    'country': $('#edit-country').val(),
                }
                $.ajax({
                    type: 'PATCH',
                    url: "{{ route('ajax-brands.update', ['id' => '']) }}" + id,
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

                            $('#edit-brand-modal').modal('hide');
                            $('#btn-edit-save').html('submit').attr('disabled', false);

                            myBrandsTable.ajax.reload();
                        }
                    },
                });
            });

        });

        function show(id) {
            $('#details-brand-modal').modal('show');
            $.ajax({
                type: 'GET',
                url: "{{ route('ajax-brands.show') }}",
                data: {id: id},
                dataType: 'json',
                success: function(response) {
                    //console.log(response);
                    var html = '<div class="card">' +
                        '<div class="card-body">' +
                        '<div class="mb-3">' +
                        '<strong>Name : </strong>' + response.data.name +
                        '</div>' +
                        '<div class="mb-3">' +
                        '<strong>Country : </strong>' + response.data.country +
                        '</div>' +
                        '</div>' +
                        '</div>';

                    $('#brand-details-body').html(html);
                    $('#details-brand-modal').modal('show');
                },
            });
        }

        function remove(id) {
            if (confirm('Are you sure you want to delete this brand?')) {
                $.ajax({
                    type: 'DELETE',
                    url: "{{ route('ajax-brands.destroy', ['id' => '']) }}" +id,
                    data: {id: id},
                    dataType: 'json',
                    success: (response) => {
                        //console.log(response);
                        $('#successForm').addClass('alert alert-success').text(response.message);

                        myBrandsTable.ajax.reload();
                    },
                });
            }
        }

        function edit(id) {
            $('#edit-brand-modal').modal('show');
            $.ajax({
                type: "GET",
                url: "{{ route('ajax-brands.edit') }}",
                data: {id: id},
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    $('#edit-id').val(response.data.id);
                    $('#edit-name').val(response.data.name);
                    $('#edit-country').val(response.data.country);
                }
            });
        }

        function add() {
            $('#brandForm').trigger('reset');
            $('#brandModal').html("Add brand");
            $('#brand-modal').modal('show');
        }

        function handleError(response) {
            $('#errsForm').addClass('alert alert-danger');
            $.each(response.errors, function (key, val) {
                $('#errsForm').append('<li>'+val+'</li>');
            });
        }

        function handleSuccess(response) {
            $('#successForm').addClass('alert alert-success').text(response.message);

            $('#brand-modal').modal('hide');
            $('#btn-save').html('submit').attr('disabled', false);
        }
    </script>

@endsection

