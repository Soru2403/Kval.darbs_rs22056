@extends('layouts.app')

@section('content')
<h2>Rediģēt profilu</h2>

{{-- Parāda validācijas kļūdas, ja tādas ir --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('profile.update') }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="name">Vārds</label>
        <input 
            type="text" 
            id="name" 
            name="name" 
            class="form-control" 
            value="{{ old('name', $user->name) }}" 
            maxlength="20" 
            required>
    </div>

    <div class="form-group">
        <label for="password">Parole (ja nepieciešams mainīt)</label>
        <input 
            type="password" 
            id="password" 
            name="password" 
            class="form-control" 
            maxlength="50">
    </div>

    <div class="form-group">
        <label for="password_confirmation">Atkārtota parole (ja nepieciešams mainīt)</label>
        <input 
            type="password" 
            id="password_confirmation" 
            name="password_confirmation" 
            class="form-control" 
            maxlength="50">
    </div>

    <div class="form-group">
        <label for="description">Apraksts</label>
        <textarea 
            id="description" 
            name="description" 
            class="form-control" 
            rows="5" 
            maxlength="5000">{{ old('description', $user->user_description) }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">Saglabāt izmaiņas</button>
</form>
@endsection


