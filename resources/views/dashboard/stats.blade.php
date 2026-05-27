<div class="grid grid-cols-4 gap-4">
  {{-- Books --}}
  <div class="flex items-center gap-3 bg-white px-4 py-3 rounded-md shadow-sm">
    {{-- first col --}}
    <div class="bg-purple-100 p-2 rounded-md">
      <img src="{{ asset('icons/book.svg') }}" class="h-6">
    </div>

    <div class="flex items-center justify-between w-full">
      <div>
        <p class="font-bold text-2xl">{{ $totalBooks }}</p>
        <p class="text-gray-500 text-sm">Books</p> 
      </div>

      {{-- sec col --}}
      <div class="flex items-center gap-1">
        @if ($booksThisMonth > 0)
          <img src=" {{ asset('icons/up.svg') }}" alt="icon"
          class="h-4">
          <p class="text-xs">&#43 {{ $booksThisMonth }} this month</p>
        @else
          <img src=" {{ asset('icons/nuetral.svg') }}" alt="icon"
          class="h-4">
          <p class="text-xs">No changes</p>
        @endif
      </div> 
    </div>  
  </div>

  {{-- Categories --}}
  <div class="flex items-center gap-3 bg-white px-4 py-3 rounded-md shadow-sm">
    <div class="bg-purple-100 p-2 rounded-md">
      <img src="{{ asset('icons/category.svg') }}" class="h-6">
    </div>

    <div class="flex items-center justify-between w-full">
      <div>
        <p class="font-bold text-2xl">{{ $totalCategories }}</p>
        <p class="text-gray-500 text-sm">Categories</p> 
      </div>

      {{-- sec col --}}
      <div class="flex items-center gap-1">
        @if ($categoriesThisMonth > 0)
          <img src=" {{ asset('icons/up.svg') }}" alt="icon"
          class="h-4">
          <p class="text-xs">&#43 {{ $categoriesThisMonth }} this month</p>
        @else
          <img src=" {{ asset('icons/nuetral.svg') }}" alt="icon"
          class="h-4">
          <p class="text-xs">No changes</p>
        @endif
      </div> 
    </div>
  </div>

  {{-- Users --}}
  <div class="flex items-center gap-3 bg-white px-4 py-3 rounded-md shadow-sm">
    <div class="bg-purple-100 p-2 rounded-md">
      <img src="{{ asset('icons/user.svg') }}" class="h-6">
    </div>

    <div class="flex items-center justify-between w-full">
      <div>
        <p class="font-bold text-2xl">{{ $totalUsers }}</p>
        <p class="text-gray-500 text-sm">Users</p> 
      </div>

      {{-- sec col --}}
      <div class="flex items-center gap-1">
        @if ($usersThisMonth > 0)
          <img src=" {{ asset('icons/up.svg') }}" alt="icon"
          class="h-4">
          <p class="text-xs">&#43 {{ $usersThisMonth }} this month</p>
        @else
          <img src=" {{ asset('icons/nuetral.svg') }}" alt="icon"
          class="h-4">
          <p class="text-xs">No changes</p>
        @endif
      </div> 
    </div>
  </div>

  {{-- Downloads --}}
  <div class="flex items-center gap-3 bg-white px-4 py-3 rounded-md shadow-sm">
    <div class="bg-purple-100 p-2 rounded-md">
      <img src="{{ asset('icons/downPurp.svg') }}" class="h-6">
    </div>
    
    <div class="flex items-center justify-between w-full">
      <div>
        <p class="font-bold text-2xl">{{ $totalDownloads }}</p>
        <p class="text-gray-500 text-sm">Users</p> 
      </div>

      {{-- sec col --}}
      <div class="flex items-center gap-1">
        @if ($downloadsThisMonth > 0)
          <img src=" {{ asset('icons/up.svg') }}" alt="icon"
          class="h-4">
          <p class="text-xs">&#43 {{ $downloadsThisMonth }} this month</p>
        @else
          <img src=" {{ asset('icons/nuetral.svg') }}" alt="icon"
          class="h-4">
          <p class="text-xs">No changes</p>
        @endif
      </div> 
    </div>
  </div>
 
</div>