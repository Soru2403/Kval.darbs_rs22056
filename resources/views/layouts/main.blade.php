<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colectio</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header style="display: flex; justify-content: space-between; align-items: center; padding: 10px 20px; background-color: #f8f9fa;">
        <!-- Kreisais bloks ar vietnes nosaukumu -->
        <div>
            <h1 style="margin: 0; font-size: 24px;">
                <a href="{{ route('home') }}" style="text-decoration: none; color: #333;">Colectio</a>
            </h1>
        </div>

        <!-- Centrālais bloks ar saitēm -->
        <nav>
            <a href="{{ route('collections.index') }}" style="margin-right: 15px; text-decoration: none; color: #007bff;">Collections</a>
            <a href="{{ route('forum.index') }}" style="margin-right: 15px; text-decoration: none; color: #007bff;">Forum</a>
        </nav>

        <!-- Labais bloks ar pogām -->
        <div>
            @guest
                <!-- Ja lietotājs nav autentificēts -->
                <a href="{{ route('login') }}" style="margin-right: 10px; text-decoration: none; color: #007bff;">Log in</a>
                <a href="{{ route('register') }}" style="text-decoration: none; color: #007bff;">Sign up</a>
            @else
                <!-- Ja lietotājs ir autentificēts -->
                <a href="{{ route('profile') }}" style="margin-right: 10px; text-decoration: none; color: #007bff;">My Profile</a>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="text-decoration: none; color: #dc3545;">Exit</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @endguest
        </div>
    </header>

    <main style="padding: 20px;">
        @yield('content')
    </main>
</body>
</html>
