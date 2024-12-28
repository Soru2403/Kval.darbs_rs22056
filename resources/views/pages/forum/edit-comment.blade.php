@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1>Rediģēt komentāru</h1>

            {{-- Pareizais maršruta vārds forum.comment.update --}}
            <form method="POST" action="{{ route('forum.comment.update', ['postId' => $comment->forum_post_id, 'commentId' => $comment->id]) }}">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="content" class="form-label">Komentārs</label>
                    <textarea class="form-control" id="content" name="content" rows="5" required>{{ old('content', $comment->content) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Saglabāt izmaiņas</button>
            </form>
        </div>
    </div>
</div>
@endsection


