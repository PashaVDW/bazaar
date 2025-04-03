@extends('layouts.base')

<x-shop-navbar />
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

