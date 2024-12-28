@extends('layouts.app')

@section('title', 'Foruma ieraksts')

@section('content')

    {{-- Atgriezties uz foruma galveno lapu --}}
    <a href="{{ route('forum.index') }}" class="btn btn-secondary mt-3">Atgriezties uz forumu</a>
    
    <h1>{{ $post->title }}</h1>
    @if($post->keywords)
        <p class="text-muted">Atslēgvārdi: {{ $post->keywords }}</p>
    @endif
    <p>{{ $post->content }}</p>
    <small>Izveidots: {{ $post->created_at->format('d.m.Y H:i') }} | Autors: {{ $post->user->name }}</small>
    
    <hr>

    {{-- Ieraksta rediģēšanas poga tikai autoram --}}
    @if(auth()->check() && (auth()->user()->id === $post->user_id))
        <a href="{{ route('forum.edit', $post->id) }}" class="btn btn-primary mt-2">Rediģēt ierakstu</a>
    @endif

    @if(auth()->check() && (auth()->user()->id === $post->user_id || auth()->user()->role === 'admin'))
        {{-- Dzēst ierakstu, ja lietotājs ir autors vai admins --}}
        <form action="{{ route('forum.destroy', $post->id) }}" method="POST" class="mt-3">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Dzēst ierakstu</button>
        </form>
    @endif

    {{-- Komentāri --}}
    <h3>Komentāri:</h3>
    <div>
        @foreach($post->comments as $comment)
            <div class="comment">
                {{-- Ja rediģēšanas režīms ir aktivizēts, parādīt rediģēšanas formu --}}
                @if(session('edit_comment_id') === $comment->id)
                    <form action="{{ route('forum.comment.update', ['postId' => $post->id, 'commentId' => $comment->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <textarea name="content" class="form-control" rows="3" required>{{ old('content', $comment->content) }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm mt-2">Saglabāt izmaiņas</button>
                    </form>
                @else
                    {{-- Parastais komentāra attēlojums --}}
                    <p>{{ $comment->content }}</p>
                    <small>Izveidots: {{ $comment->created_at->format('d.m.Y H:i') }} | Autors: {{ $comment->user->name }}</small>

                    {{-- Komentāra rediģēšanas poga tikai komentāra autoram --}}
                    @if(auth()->check() && (auth()->user()->id === $comment->user_id))
                        <a href="{{ route('forum.comment.edit', ['postId' => $post->id, 'commentId' => $comment->id]) }}" class="btn btn-primary btn-sm mt-2">Rediģēt komentāru</a>
                    @endif
                @endif

                {{-- Komentāra dzēšanas poga tikai komentāra autoram vai adminam --}}
                @if(auth()->check() && (auth()->user()->id === $comment->user_id || auth()->user()->role === 'admin'))
                    <form action="{{ route('forum.comment.destroy', ['postId' => $post->id, 'commentId' => $comment->id]) }}" method="POST" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Dzēst komentāru</button>
                    </form>
                @endif
            </div>
            <hr>
        @endforeach
    </div>

    {{-- Pievienot komentāru, ja lietotājs ir autentificēts --}}
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

@endsection