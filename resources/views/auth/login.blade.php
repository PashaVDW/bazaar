<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<h1>Login</h1>

@if ($errors->any())
    <div>
        <strong>Error(s):</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div>
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    </div>

    <div>
        <label for="password">Password</label>
        <input id="password" type="password" name="password" required>
    </div>

    <div>
        <label>
            <input type="checkbox" name="remember"> Remember me
        </label>
    </div>

    <div>
        <button type="submit">Login</button>
    </div>
</form>

<p>
    Don't have an account? <a href="{{ route('register') }}">Register here</a>
</p>
</body>
</html>
