@extends('layouts.app')

@section('content')

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div class="card">
    <h2>Model Create</h2>
    <div class="card-body">
<form method="POST" action="{{ route('model.store') }}">
    @csrf
    <div>
        <label for="nom">Model:</label>
        <input type="text" id="nom" name="nom" class="form-control">
    </div>
    <div>
        <label for="nom">Color:</label>
        <input type="text" id="color" name="color" class="form-control">
    </div>
    <div>
        <label for="nom">Matricule:</label>
        <input type="text" id="nom" name="nom" class="form-control" disabled>
    </div>
    <div>
        <label for="nom">Engine:</label>
        <input type="text" id="nom" name="nom" class="form-control">
    </div>
    <div class="form-group">
        <label>Type</label>
        <select name="Engine" class="form-control">
            <option selected>Pick Type</option>
            <option value="Hy">Hybrid</option>
            <option value="El">Electric</option>
            <option value="P">Petrol</option>
        </select>
    </div>
    <div class="form-group">
        <label for="idBrand">Marque:</label>
        <select id="idBrand" name="idBrand" class="form-control">
            @foreach($brand as $brand)
                <option value="{{ $brand->id }}">{{ $brand->nom }}</option>
            @endforeach
        </select>
    </div>
    </div>
    <button type="submit" class="btn btn-primary m1-auto">Ajouter</button>
    </div>
</form>

</body>
</html>
@endsection
