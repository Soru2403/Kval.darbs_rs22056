@extends('layouts.app')

@section('content')
<h2>Pievienot jaunu mēdiju</h2>

{{-- Ja ir kļūdas, tās tiek parādītas --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('media.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="title">Nosaukums:</label>
        <input type="text" name="title" id="title" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="description">Apraksts:</label>
        <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
    </div>

    <div class="form-group">
        <label for="type">Veids:</label>
        <select name="type" id="type" class="form-control" required>
            <option value="spēle">Spēle</option>
            <option value="filma">Filma</option>
            <option value="seriāls">Seriāls</option>
            <option value="grāmata">Grāmata</option>
        </select>
    </div>

    <div class="form-group">
        <label for="creator">Autors/Izveidotājs:</label>
        <input type="text" name="creator" id="creator" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="release_year">Izdošanas gads:</label>
        <input type="number" name="release_year" id="release_year" class="form-control" min="1900" max="{{ date('Y') }}" required>
    </div>

    <div class="form-group">
        <label for="genre">Žanrs:</label>
        <input type="text" name="genre" id="genre" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="image_url">Attēla URL:</label>
        <input type="url" name="image_url" id="image_url" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success">Pievienot mēdiju</button>
    <a href="{{ route('media.index') }}" class="btn btn-secondary">Atpakaļ</a>
</form>
@endsection