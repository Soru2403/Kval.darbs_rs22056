@extends('layouts.main')

@section('content')
<div class="container">
    <header class="d-flex justify-content-between align-items-center py-3">
        <!-- majaslapas nosaukums -->
        <h1 class="text-primary">Colectio</h1>

        <!-- ieejas un registracijas pogas -->
        <div>
            <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Log in</a>
            <a href="{{ route('register') }}" class="btn btn-primary">Sign up</a>
        </div>
    </header>

    <!-- horizontala navigacija -->
    <nav class="my-3">
        <ul class="nav nav-pills">
            <li class="nav-item"><a href="{{ route('collections.index') }}" class="nav-link">Collections</a></li>
            <li class="nav-item"><a href="{{ route('forum.index') }}" class="nav-link">Forum</a></li>
            <li class="nav-item"><a href="{{ route('media.index') }}" class="nav-link">Media</a></li>
        </ul>
    </nav>

</div>
@endsection