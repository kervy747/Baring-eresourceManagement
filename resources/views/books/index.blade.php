<x-layout title="Books Catalog">
  <div class="mb-5">
    {{-- filter cards --}}
    <div class="flex justify-between">
      {{-- 1st col --}}
      <div class="flex items-center gap-5">
        <form method="GET" class="flex gap-5">
          <div class="relative flex items-center shadow-sm">
            <input 
              class="bg-white pl-9 pr-4 py-2 rounded-md font-grey w-100" 
              type="text" 
              name="search" 
              placeholder="Search books by title or author..."
              value="{{ request('search') }}"
              oninput="clearTimeout(window.timer); window.timer = setTimeout(() => this.form.submit(), 500)">
            <img src="https://i.imgur.com/CVkFdDe.png" 
                class="absolute left-3 w-4 h-4 opacity-50" alt="search" referrerpolicy="no-referrer">
          </div>  
          <div class="bg-purple-200 rounded-md px-3 py-2">
            <select name="catBox" onchange="this.form.submit()"
            class="outline-none">
              <option value="all" {{ request('catBox') === 'all' ? 'selected' : '' }}>All Categories</option>
              @foreach ($categories as $category)
                @if ($category->books->isNotEmpty())
                  <option value="{{ $category->id }}" {{ request('catBox') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option> 
                @endif
              @endforeach
            </select>
          </div>
        </form>
      </div>
      {{-- 2nd col --}}
      <div class="flex items-center gap-3">
        @auth
          <x-button class="px-4 py-2" href='/books/create'>
            &#43; Add Book
          </x-button>
          @if (auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
            <x-button variant='secondary' class="px-4 py-2 outline-2" href='/books/pending'>
              View Requests
            </x-button>
          @endif
        @endauth
      </div>
    </div>

    {{-- books section --}}
    <div class="grid grid-cols-4 gap-4 mt-4">
      @foreach ($books as $book)
          {{-- book card --}}
          <div class="grid grid-cols-3 bg-white shadow-sm rounded-md">
            {{-- image --}}
            <div class="col-span-1">  
              <img 
              src="{{ asset('storage/' . $book->cover_image) }}" 
              alt="coverPhoto"
              class="aspect-[3/4] w-full h-full object-cover rounded-l-md">
            </div>

            {{-- details --}}
            <div class="grid col-span-2 gap-4 px-4 py-4">
              {{-- title --}}
              <div class="grid gap-2">
                <p class="font-bold">{{$book->title}}</p>
                <p>{{$book->author}}</p>
              </div>
              {{-- data --}}
              <div class="flex text-sm items-center gap-2">
                <span class="bg-purple-200 px-2 py-1 rounded-4xl font-bold">{{ $book->category->name }}</span>
                @if ($book->access_type === 'free')
                    <span class="bg-green-200 px-2 py-1 rounded-4xl font-bold">Free</span>
                @else
                    <span class="bg-red-200 px-2 py-1 rounded-4xl font-bold">Paid</span>
                @endif
                <p class="flex gap-1 items-center">
                  <img src="{{ asset('icons/down.svg') }}" class="h-4">
                  {{ $book->downloads_count }}</p>
              </div>
              <hr class="border-t border-gray-300">
              {{-- actions --}}
              <div class="flex gap-4 items-center">
                <x-button class="text-sm px-3 py-2 mr-1 outline-1 flex items-center gap-2" variant="secondary"
                href='/books/{{ $book->id }}'>
                  <img src="{{ asset('icons/view.svg') }}" alt="icon"
                  class="h-4"> View
                </x-button>
                @auth
                  @if (auth()->user()->isAdmins())
                    <x-button href='/books/{{ $book->id }}/edit' variant='default' class="text-sm outline outline-gray-300 p-2 rounded-md">
                      <img src=" {{ asset('icons/edit.svg') }}" alt="icon"
                      class="h-4.5">
                    </x-button>
                  @endif
                @endauth
                <x-button href="/books/{{ $book->id }}/download" variant='default' class="text-sm outline outline-gray-300 p-2 rounded-md ">
                  <img src=" {{ asset('icons/down.svg') }}" alt="icon"
                  class="h-4.5">
                </x-button>
              </div>
            </div>
          </div> 
      @endforeach
          
    </div>
      <div class="my-5">
      {{ $books->links() }}
    </div>
  </div>
</x-layout>