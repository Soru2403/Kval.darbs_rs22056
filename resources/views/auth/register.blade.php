@extends('layouts.main')

@section('content')
<h2>Reģistrēties</h2>

{{-- Rāda kļūdu ziņojumus, ja tādi ir --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li> {{-- Kļūdas ziņojums --}}
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('register') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="name">Vārds</label>
        <input 
            type="text" 
            id="name" 
            name="name" 
            value="{{ old('name') }}" 
            class="form-control" 
            required>
    </div>
    <div class="form-group">
        <label for="email">E-pasts</label>
        <input 
            type="email" 
            id="email" 
            name="email" 
            value="{{ old('email') }}" 
            class="form-control" 
            required>
    </div>
    <div class="form-group">
        <label for="password">Parole</label>
        <input 
            type="password" 
            id="password" 
            name="password" 
            class="form-control" 
            required>
    </div>
    <div class="form-group">
        <label for="password_confirmation">Paroles apstiprināšana</label>
        <input 
            type="password" 
            id="password_confirmation" 
            name="password_confirmation" 
            class="form-control" 
            required>
    </div>
    <button type="submit" class="btn btn-primary">Reģistrēties</button>
</form>

<p>Jau ir konts? <a href="{{ route('login') }}">Pieslēdzies šeit</a>.</p>
@endsection
