<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welkom bij Featherleads</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 50px;
        }
        nav {
            margin-bottom: 20px;
        }
        a {
            margin: 0 10px;
        }
    </style>
</head>
<body>
<nav>
    @auth
        Welkom, {{ Auth::user()->name }} |
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
            @csrf
            <button type="submit">Logout</button>
        </form>
    @else
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('register') }}">Register</a>
    @endauth
</nav>

<h1>Welkom bij De Bazaar</h1>
<p>Je bent nu op de startpagina van je Laravel-app.</p>
</body>
</html>
