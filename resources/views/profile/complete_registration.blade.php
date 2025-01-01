@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Pabeigt reģistrāciju</h2>
    <p>Aizpildiet zemāk esošo formu, lai pabeigtu reģistrāciju.</p>

    {{-- Veiksmīga ziņa --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Forma, lai mainītu vārdu un aprakstu --}}
    <form action="{{ route('profile.complete_registration') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Vārds</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="user_description" class="form-label">Apraksts (nav obligāts)</label>
            <textarea name="user_description" id="user_description" class="form-control">{{ old('user_description', auth()->user()->user_description) }}</textarea>
            @error('user_description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Pabeigt reģistrāciju</button>
    </form>
</div>
@endsection
