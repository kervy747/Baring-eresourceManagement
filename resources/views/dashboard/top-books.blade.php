<div class="bg-white px-5 py-4 rounded-md shadow-sm">
  <h2 class="text-base font-semibold text-gray-700 mb-3">Most Downloaded Books</h2>

  @if ($topBooks->isEmpty())
    <div class="bg-white rounded-2xl border border-gray-100 p-8 text-center text-gray-400 text-sm">
      No downloads yet.
    </div>
  @else
    <div class="px-10 mt-5">
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-15">
        @foreach ($topBooks as $index => $book)
          <a href="/books/{{ $book->id }}"
            class="bg-white group">

            {{-- Cover Image --}}
            <div class="relative aspect-[3/4] bg-purple-50">
              @if ($book->cover_image)
                <img
                  src="{{ asset('storage/' . $book->cover_image) }}"
                  alt="{{ $book->title }}"
                  class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 shadow-md rounded-md"
                >
              @else
                {{-- Placeholder when no cover --}}
                <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-purple-100 to-purple-200 p-3">
                  <span class="text-purple-400 text-xs text-center leading-tight">{{ Str::limit($book->title, 20) }}</span>
                </div>
              @endif

              {{-- Rank Badge --}}
              <div class="absolute top-2 left-2 w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold
                {{ $index === 0 ? 'bg-yellow-400 text-yellow-900' : ($index === 1 ? 'bg-gray-300 text-gray-700' : ($index === 2 ? 'bg-orange-300 text-orange-800' : 'bg-white text-gray-500 shadow')) }}">
                {{ $index + 1 }}
              </div>
            </div>

            {{-- Info --}}
            <div class="p-3">
              <p class="text-gray-800 text-xs font-semibold leading-tight line-clamp-2" title="{{ $book->title }}">
                {{ $book->title }}
              </p>
              <p class="text-gray-400 text-xs mt-1 truncate">{{ $book->author }}</p>
              <p class="text-black-500 text-sm font-medium mt-1.5 flex items-center gap-2">
                <img src="{{ asset('icons/down.svg') }}" alt="books" class="h-5"> {{ number_format($book->downloads_count) }} {{ $book->downloads_count == 1 ? 'download' : 'downloads' }}
              </p>
            </div>
          </a>
        @endforeach
      </div>
    </div>
  @endif
</div>