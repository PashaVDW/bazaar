@extends('layouts.app')
@section('content')
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
<section class="py-8 bg-blueGray-50" x-data="{ view: 'list', search: '', modal: true, filtersFollowers(input){ return input.toLowerCase().startsWith(this.search.toLowerCase()) } }">
  <div class="container px-4 mx-auto">

    <div x-show="filtersFollowers($refs.title1.textContent)" class="flex flex-col md:flex-row w-full bg-white rounded-3xl overflow-hidden mb-6">
      <div class="flex items-center h-32 p-5 md:pl-14 md:w-2/5">
        <i class="fa-solid fa-file-pdf text-primary text-4xl mr-6"></i>
        <a x-ref="title1" class="inline-block text-lg font-heading font-medium leading-5 hover:underline" href="#">Lorem ipsum dolor sit amet</a>
      </div>
      <div class="flex flex-1 items-center justify-end h-32 p-5 border-t md:border-t-0 md:border-l border-gray-100">
        <div class="flex items-center text-sm text-darkBlueGray-400">
          <i class="fa-regular fa-clock mr-2 text-primary"></i>
          <span>10:30 AM</span>
        </div>
        <div class="w-px h-8 mx-4 bg-gray-100"></div>
        <div class="flex items-center text-sm text-darkBlueGray-400">
          <i class="fa-solid fa-file mr-2 text-primary"></i>
          <span>24 MB</span>
        </div>
      </div>
      <div class="flex items-center justify-center h-32 p-5 border-t md:border-t-0 md:border-l border-gray-100">
        <a class="text-primary hover:text-primary" href="#">
          <i class="fa-solid fa-download text-xl"></i>
        </a>
      </div>
    </div>
  </div>
</section>
<h1>Welkom bij De Bazaar</h1>
<p>Je bent nu op de startpagina van je Laravel-app.</p>

@endsection