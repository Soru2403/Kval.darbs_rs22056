@extends('layouts.main')

@section('content')
<h2>Tavs profils</h2>

{{-- Parāda veiksmīgu ziņojumu, ja tāds ir --}}
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="profile-container">
    <div class="profile-info">
        <p><strong>Vārds:</strong> {{ $user->name }}</p>
        <p><strong>E-pasts:</strong> {{ $user->email }}</p>
        <p><strong>Reģistrācijas datums:</strong> {{ $user->created_at->format('Y-m-d') }}</p>
    </div>
    <div class="profile-actions">
        <a href="#" class="btn btn-secondary">Rediģēt profilu</a>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-danger">Izrakstīties</button>
        </form>
    </div>
</div>
@endsection
