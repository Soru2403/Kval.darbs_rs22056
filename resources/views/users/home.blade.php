@extends('layouts.main')

@section('content')
    <h1>Welcome, {{ $user->name }}!</h1>
    <p>This is your homepage. Here you can see personalized content.</p>
@endsection
