<x-layout title="Home">
  <div class="mb-4">
    {{-- head welcome --}}
    <div>
      @guest
        <div class="relative flex justify-between bg-gradient-to-r from-white from-50% to-[#A78BFA] shadow-sm rounded-md px-10 py-15 overflow-hidden ">
          <div class="grid gap-3 z-2">
            <h1 class="font-bold text-4xl">Explore Books</h1>

              <p class="mt-2 text-lg">Welcome! Explore our collection of books. <br> Sign up to save favorites and access more features.</p>


            <x-button href='/books' class="flex justify-center items-center gap-1 w-fit px-4 py-1 mt-2">
              View Books
              <img src="{{ asset('icons/arrow1.svg') }}" alt="icon" class="h-6">
            </x-button>
          </div>
          <img src="images/bookOpened.png" alt="backdrop" class="absolute h-90 object-cover scale-100 right-20 -top-5 opacity-70 z-0">
        </div>
      @endguest

      @auth
        <div class="relative flex justify-between bg-gradient-to-r from-white from-50% to-[#A78BFA] shadow-sm rounded-md px-10 py-15 overflow-hidden">
          <div class="grid gap-3 z-2">
            <p class="text-sm tracking-wider bg-purple-200 rounded-xl text-purple-700 w-fit font-medium px-2 uppercase">
              @if (auth()->user()->isAdmins())
                ADMIN ACCESS
              @else
                MEMBER ACCESS
              @endif
            </p>

            <h1 class="font-bold text-4xl">Welcome Back, {{ auth()->user()->fname}}</h1>

            @if (auth()->user()->isAdmins())
              <p class="mt-2 text-lg">Manage books, categories, and users from one place. <br>
              Keep your library organized and growing.</p>
            @else
              <p class="mt-2 text-lg">Manage books, categories, and download your favorites. <br>
              Keep your library organized and growing.</p>
            @endif

            <x-button href='/books' class="flex justify-center items-center gap-1 w-fit px-4 py-1 mt-2">
              View Books
              <img src="{{ asset('icons/arrow1.svg') }}" alt="icon" class="h-6">
            </x-button>
          </div>

          {{-- quick actions --}}
          @if (auth()->user()->isAdmins())
            <div class="flex items-center gap-3 z-2 mr-20 text-purple-600">
              {{-- Add Book --}}
              <a href="/books/create" class="h-30 flex flex-col justify-center items-center gap-2 bg-white px-4 py-4 rounded-xl shadow-sm hover:shadow-md transition w-24 text-center">
                <img src="{{ asset('icons/book.svg') }}" alt="icon" class="h-8">
                <p class="text-xs font-medium flex items-center gap-1">Add<br>Book</p>
              </a>
              {{-- Add Category --}}
              <a href="/categories/create" class="h-30 flex flex-col justify-center items-center gap-2 bg-white px-4 py-4 rounded-xl shadow-sm hover:shadow-md transition w-24 text-center">
                <img src="{{ asset('icons/category.svg') }}" alt="icon" class="h-8">
                <p class="text-xs font-medium flex items-center gap-1">Add<br>Category</p>
              </a>
              {{-- Add User --}}
              <a href="/users/create" class="h-30 flex flex-col justify-center items-center gap-2 bg-white px-4 py-4 rounded-xl shadow-sm hover:shadow-md transition w-24 text-center">
                <img src="{{ asset('icons/user.svg') }}" alt="icon" class="h-8">
                <p class="text-xs font-medium flex items-center gap-1">Add<br>User</p>
              </a>
            </div>
          @else
            {{-- regular user quick actions --}}
            <div class="flex items-center gap-3 z-2 mr-20 text-purple-500">
              {{-- Browse Books --}}
              <a href="/books" class="h-30 flex flex-col justify-center items-center gap-2 bg-white px-4 py-4 rounded-xl shadow-sm hover:shadow-md transition w-24 text-center">
                <img src="{{ asset('icons/book.svg') }}" alt="icon" class="h-8">
                <p class="text-xs font-medium">Browse Books</p>
              </a>
              {{-- Upload Book --}}
              <a href="/books/create" class="h-30 flex flex-col justify-center items-center gap-2 bg-white px-4 py-4 rounded-xl shadow-sm hover:shadow-md transition w-24 text-center">
                <img src="{{ asset('icons/upload.svg') }}" alt="icon" class="h-8">
                <p class="text-xs font-medium">Upload Book</p>
              </a>
            </div>
          @endif

          <img src="images/bookOpened.png" alt="backdrop" class="absolute h-90 object-cover scale-100 right-20 -top-5 opacity-70 z-0" draggable="false">
        </div>
      @endauth  
    </div>
    
    {{-- body --}}
    <div class="grid">

      {{-- ADMIN body --}}
      @auth
        @if (auth()->user()->isAdmins())
          <div class="mt-4 mb-4">
            @include('dashboard.stats')
          </div>

          <div class="grid gap-4">
            <div class='flex gap-4'>
              <div class="flex-1">
                @include('dashboard.recent')
              </div>
              <div class="flex-1">
                @include('dashboard.chart')
              </div>
              <div class="flex-1">
                @include('dashboard.topCategories')
              </div>
            </div>
          </div>
        @endif
      @endauth

      {{-- USER / GUEST body --}}
      @if (!auth()->check() || !auth()->user()->isAdmins())
        <div class="mt-4 space-y-6">

          {{-- Top 5 Most Downloaded Books --}}
          @include('dashboard.top-books')

          {{-- Top Categories + Recently Added --}}
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            @include('dashboard.top-categories')
            @include('dashboard.recent-books')
          </div>

          {{-- My Downloads (logged-in users only) --}}
          @auth
            @include('dashboard.my-downloads')
          @endauth

        </div>
      @endif

    </div>
  </div>
</x-layout>