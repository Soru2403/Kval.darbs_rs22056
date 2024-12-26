@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Izveidot jaunu ierakstu</h1>

    <!-- Forma jauna ieraksta izveidei -->
    <form method="POST" action="{{ route('forum.store') }}">
        @csrf <!-- CSRF aizsardzības token -->

        <!-- Nosaukuma ievades lauks -->
        <div class="mb-3">
            <label for="title" class="form-label">Ieraksta nosaukums</label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div> <!-- Kļūdas ziņojums -->
            @enderror
        </div>

        <!-- Atslēgvārdu ievades lauks -->
        <div class="mb-3">
            <label for="keywords" class="form-label">Atslēgvārdi (pēc izvēles)</label>
            <input type="text" name="keywords" id="keywords" class="form-control @error('keywords') is-invalid @enderror" value="{{ old('keywords') }}">
            @error('keywords')
                <div class="invalid-feedback">{{ $message }}</div> <!-- Kļūdas ziņojums -->
            @enderror
        </div>

        <!-- Satura ievades lauks -->
        <div class="mb-3">
            <label for="content" class="form-label">Saturs</label>
            <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" rows="5" required>{{ old('content') }}</textarea>
            @error('content')
                <div class="invalid-feedback">{{ $message }}</div> <!-- Kļūdas ziņojums -->
            @enderror
        </div>

        <!-- Poga "Izveidot" un "Atcelt" -->
        <button type="submit" class="btn btn-success">Izveidot ierakstu</button>
        <a href="{{ route('forum.index') }}" class="btn btn-secondary">Atcelt</a>
    </form>
</div>
@endsection
