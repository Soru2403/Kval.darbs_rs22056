<!-- resources/views/media/index.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Mediji</h1>
    @foreach ($media as $item)
        <div>
            <h2><a href="{{ route('media.show', $item->id) }}">{{ $item->title }}</a></h2>
        </div>
    @endforeach
@endsection
