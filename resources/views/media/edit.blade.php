@extends('layouts.app')

@section('content')
<h2>Rediģēt mēdiju: {{ $media->title }}</h2>

<form action="{{ route('media.update', $media->id) }}" method="POST">
    @csrf
    @method('POST')
    <div class="form-group">
        <label for="title">Nosaukums</label>
        <input type="text" name="title" id="title" class="form-control" value="{{ $media->title }}" required>
    </div>
    <div class="form-group">
        <label for="description">Apraksts</label>
        <textarea name="description" id="description" class="form-control" required>{{ $media->description }}</textarea>
    </div>
    <div class="form-group">
        <label for="type">Tips</label>
        <select name="type" id="type" class="form-control" required>
            <option value="game" {{ $media->type === 'game' ? 'selected' : '' }}>Spēle</option>
            <option value="movie" {{ $media->type === 'movie' ? 'selected' : '' }}>Filma</option>
            <option value="series" {{ $media->type === 'series' ? 'selected' : '' }}>Seriāls</option>
            <option value="book" {{ $media->type === 'book' ? 'selected' : '' }}>Grāmata</option>
        </select>
    </div>
    {{-- Pārējie lauki --}}
    <div class="form-group">
        <label for="creator">Autors</label>
        <input type="text" name="creator" id="creator" class="form-control" value="{{ $media->creator }}" required>
    </div>
    <div class="form-group">
        <label for="release_year">Izdošanas gads</label>
        <input type="number" name="release_year" id="release_year" class="form-control" value="{{ $media->release_year }}" required>
    </div>
    <div class="form-group">
        <label for="genre">Žanrs</label>
        <input type="text" name="genre" id="genre" class="form-control" value="{{ $media->genre }}" required>
    </div>
    <div class="form-group">
        <label for="image_url">Attēla saite</label>
        <input type="url" name="image_url" id="image_url" class="form-control" value="{{ $media->image_url }}">
    </div>

    <button type="submit" class="btn btn-success mt-3">Saglabāt izmaiņas</button>
</form>
@endsection
