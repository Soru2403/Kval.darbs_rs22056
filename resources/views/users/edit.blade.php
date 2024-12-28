@extends('layouts.app')

@section('content')
<h2>Rediģēt profilu</h2>

{{-- Parāda kļūdu ziņojumus, ja tādi ir --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="name">Vārds</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
    </div>

    <div class="form-group">
        <label for="email">E-pasts</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
    </div>

    <div class="form-group">
        <label for="password">Parole</label>
        <input type="password" name="password" id="password" class="form-control">
    </div>

    <div class="form-group">
        <label for="password_confirmation">Atkārtota parole</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Saglabāt izmaiņas</button>
    <a href="{{ route('profile') }}" class="btn btn-secondary">Atcelt</a>
</form>
@endsection
