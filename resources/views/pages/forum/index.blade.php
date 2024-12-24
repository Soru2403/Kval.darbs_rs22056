@extends('layouts.main')

@section('title', 'Forum')

@section('content')
    <h1>Forums</h1>
    <p>Apskatiet un piedalieties foruma diskusijās.</p>

    {{-- Pievieno jaunu ierakstu, ja lietotājs ir autentificēts --}}
    @auth
        <form action="{{ route('forum.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Ieraksta nosaukums:</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="content">Ieraksta saturs:</label>
                <textarea name="content" id="content" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Izveidot ierakstu</button>
        </form>
    @endauth

    <hr>

    {{-- Foruma ierakstu saraksts --}}
    <div>
        @foreach($posts as $post)
            <div class="forum-post">
                <h2>{{ $post->title }}</h2>
                <p>{{ $post->content }}</p>
                <small>Izveidots: {{ $post->created_at->format('d.m.Y H:i') }} | Autors: {{ $post->user->name }}</small>
                
                {{-- Komentāru sekcija --}}
                <h3>Komentāri:</h3>
                <div>
                    @foreach($post->comments as $comment)
                        <div class="comment">
                            <p>{{ $comment->content }}</p>
                            <small>Izveidots: {{ $comment->created_at->format('d.m.Y H:i') }} | Autors: {{ $comment->user->name }}</small>
                        </div>
                    @endforeach
                </div>

                {{-- Pievieno komentāru, ja lietotājs ir autentificēts --}}
                @auth
                    <form action="{{ route('forum.comment', $post->id) }}" method="POST" class="mt-3">
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
            </div>
            <hr>
        @endforeach
    </div>
@endsection

