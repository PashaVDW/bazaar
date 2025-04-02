<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
<h1>Register</h1>

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

<form method="POST" action="{{ route('register') }}">
    @csrf

    <div>
        <label>Name</label>
        <input type="text" name="name" value="{{ old('name') }}" required autofocus>
    </div>

    <div>
        <label>Email Address</label>
        <input type="email" name="email" value="{{ old('email') }}" required>
    </div>

    <div>
        <label>Password</label>
        <input type="password" name="password" required>
    </div>

    <div>
        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" required>
    </div>

    <div>
        <label>Account Type</label>
        <select name="account_type" required>
            <option value="">-- Choose an option --</option>
            <option value="customer">Guest</option>
            <option value="private_advertiser">Private</option>
            <option value="business_advertiser">Business</option>
        </select>
    </div>

    <div>
        <button type="submit">Register</button>
    </div>
</form>

<p>
    Already have an account? <a href="{{ route('login') }}">Log in here</a>
</p>
</body>
</html>
