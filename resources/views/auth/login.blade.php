@extends('layouts.main')

@section('content')
<h2>Pieslēgties</h2>

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

<form action="{{ route('login') }}" method="POST">
    @csrf
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
    <button type="submit" class="btn btn-primary">Pieslēgties</button>
</form>

<p>Nav konta? <a href="{{ route('register') }}">Reģistrējies šeit</a>.</p>
@endsection
