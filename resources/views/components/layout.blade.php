@props(['showNav'=>true, 'bg'=>'bg-[#f8f8fc]', 'title' => ''])

<!DOCTYPE html>
<html lang="en">
<head>
  @vite(['resources/css/app.css', 'resources/js/app.js'])  
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ $title }} | ResHub</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="icon" type="image/png" href="{{ asset('icons/logo.svg') }}">
</head>
<body class="{{ $bg }} px-10 select-none">

  @if ($showNav)
    <nav class="fixed top-0 w-full p-8 h-20 bg-[#FFFFFF] flex items-center justify-between text-[#6C3EEF] text-base font-medium shadow-[0_0_10px_#6B49FF40] -mx-10 z-50">
      <div class="flex items-center">
        
        @auth
          <a class="mr-7" href="/" :active="request()->is('/')">
            <img src="https://i.imgur.com/xdRZ2Sy.png" alt="Logo" class="h-11 w-auto" referrerpolicy="no-referrer">
          </a>
          <x-nav href="/" :active="request()->is('/')">Dashboard</x-nav>
          <x-nav href="/books" :active="request()->is('books')">Books Catalog</x-nav>
          @if (auth()->user()->isAdmin() || auth()->user()->isSuperadmin())
            <x-nav href="/users" :active="request()->is('users')">Users</x-nav> 
          @endif
          <x-nav href="/categories" :active="request()->is('categories')">Categories</x-nav>
          @if (auth()->user()->isAdmin() || auth()->user()->isSuperadmin())
            <x-nav href="/activity" :active="request()->is('activity')">Activity Log</x-nav>
          @endif
        @endauth

        @guest
          <a class="mr-7" href="/" :active="request()->is('/')">
            <img src="https://i.imgur.com/xdRZ2Sy.png" alt="Logo" class="h-11 w-auto" referrerpolicy="no-referrer">
          </a>
          <x-nav href="/" :active="request()->is('/')">Dashboard</x-nav>
          <x-nav href="/books" :active="request()->is('books')">Books Catalog</x-nav>
          <x-nav href="/categories" :active="request()->is('categories')">Categories</x-nav>
        @endguest

      </div>

      <div class="flex gap-4 items-center">
        @guest
          <x-button href='/login' class="px-3 py-2">Login</x-button>
          <x-button href='/register' variant='secondary' class="px-3 py-2">Register</x-button>
        @endguest

        @auth
          <form method="POST" action="/logout" onsubmit="return confirm('Are you sure you want to Logout?')">
            @csrf
            <x-button type='submit' variant='default' class="items-center px-3 py-1 bg-red-50 flex gap-2 text-red-500 outline-2 rounded-md">
              <img src=" {{ asset('icons/logout.svg') }} " alt="icon"
              class="h-4">
              Logout
            </x-button>
          </form>

          <a href="/profile" class="bg-purple-600 flex justify-center items-center w-10 h-10 text-white rounded-4xl ">
            {{ strtoupper(substr(auth()->user()->fname,0,1)) .strtoupper(substr(auth()->user()->lname,0,1)) }}
          </a>
        @endauth
      </div>
    </nav>
  @endif

  <div class="{{ $showNav ? 'pt-25' : '' }}">
    {{ $slot }}
  </div>
</body>
</html> 