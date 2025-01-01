<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.app')

@section('content')
    <h2>Administratora panelis</h2>

    {{-- Parāda veiksmīgu ziņojumu, ja tāds ir --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Lietotāju saraksts --}}
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Vārds</th>
                <th>E-pasts</th>
                <th>Izveidots</th>
                <th>Darbības</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>
                        {{-- Lietotāja vārds kā saite uz viņa profilu --}}
                        <a href="{{ route('profile.show', ['id' => $user->id]) }}">
                            {{ $user->name }}
                        </a>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                    <td>
                        {{-- Dzēšanas poga --}}
                        <form action="{{ route('profile.destroy', ['id' => $user->id]) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Vai tiešām vēlaties dzēst šo lietotāju?')">Dzēst</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Paginācija --}}
    <div class="pagination">
        {{ $users->links() }}
    </div>
@endsection

