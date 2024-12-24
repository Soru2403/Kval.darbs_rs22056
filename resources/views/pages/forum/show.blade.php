@extends('layouts.main')

@section('title', 'Foruma ieraksts')

@section('content')
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>
    <small>Izveidots: {{ $post->created_at->format('d.m.Y H:i') }} | Autors: {{ $post->user->name }}</small>
    
    <hr>

    {{-- Komentāru sekcija --}}
    <h3>Komentāri:</h3>
    <div>
        @foreach($post->comments as $comment)
            <div class="comment">
                <p>{{ $comment->content }}</p>
                <small>Izveidots: {{ $comment->created_at->format('d.m.Y H:i') }} | Autors: {{ $comment->user->name }}</small>
                
                {{-- Dzēst komentāru, ja lietotājs ir autors vai administrators --}}
                @can('delete', $comment)
                    <form action="{{ route('forum.comment.destroy', $comment->id) }}" method="POST" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Dzēst komentāru</button>
                    </form>
                @endcan
            </div>
            <hr>
        @endforeach
    </div>

    {{-- Pievieno komentāru, ja lietotājs ir autentificēts --}}
    @auth
        <form action="{{ route('forum.comment', $post->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="content">Tavs komentārs:</label>
                <textarea name="content" id="content" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-secondary mt-2">Pievienot komentāru</button>
        </form>
    @endauth

    {{-- Dzēst ierakstu, ja lietotājs ir autors vai administrators --}}
    @can('delete', $post)
        <form action="{{ route('forum.destroy', $post->id) }}" method="POST" class="mt-3">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Dzēst ierakstu</button>
        </form>
    @endcan
@endsection
