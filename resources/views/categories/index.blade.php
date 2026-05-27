<x-layout title="Category">
  <div>
    <div class="flex justify-between">
      <form method="GET" action="/categories">
        <div class="relative flex items-center shadow-sm">
          <input 
          class="bg-white pl-9 pr-4 py-2 rounded-md font-grey w-100" 
          type="text" 
          name="search" 
          placeholder="Search categories..."
          value="{{ request('search') }}" 
          onkeydown="if(event.key === 'Enter') this.form.submit()">
          <img src="https://i.imgur.com/CVkFdDe.png" 
               class="absolute left-3 w-4 h-4 opacity-50" alt="search" referrerpolicy="no-referrer">
        </div>  
      </form>
      @auth
        @if (auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
          <div class="flex gap-4 items-center">
            <x-button class="px-4 py-2" href="/categories/create">
              &#43; Add Category
            </x-button>
            <x-button variant='secondary' class="outline-2 px-4 py-2" href="/categories/pending">
              View Request
            </x-button>
          </div>
        @elseif (auth()->user()->isUser())
          <a href="/categories/create">
            <x-button class="px-4 py-2">
              &#43; Request Category
            </x-button>
          </a>
        @endif
      @endauth
    </div>

    <div class="grid grid-cols-4 gap-4 mt-5">

      @foreach ($categories as $cat)

        <div class=" bg-white h-auto shadow-sm px-4 py-4 rounded-md text-lg grid">

          <div class="flex justify-between">

            <div class="text-xl">{{$cat->name}}</div>
            
            @auth
                @if (auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
                  <x-button variant='secondary' href='/categories/{{ $cat->id }}/edit' class=" px-2 pt-1 text-sm">Edit</x-button>    
                @endif
            @endauth
            

          </div>

          <div class="mt-2 text-xs font-medium px-2 py-1 rounded-xl bg-[#DFD8FF] w-fit">
            0 Books  
          </div>

        </div>
      @endforeach

    </div>
  </div>

  <div class="my-5">
    {{ $categories->appends(request()->query())->links() }}
  </div>
</x-layout>