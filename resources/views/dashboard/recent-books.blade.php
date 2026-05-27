<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
  <div class="flex items-center justify-between mb-4">
    <h2 class="text-base font-semibold text-gray-700">Recently Added</h2>
    <a href="/books" class="text-xs text-purple-500 hover:underline">View all</a>
  </div>

  @if ($recentBooks->isEmpty())
    <p class="text-gray-400 text-sm text-center py-6">No books yet.</p>
  @else
    <div class="space-y-3">
      @foreach ($recentBooks as $book)
        <a href="/books/{{ $book->id }}"
           class="flex items-center gap-3 group hover:bg-gray-50 rounded-xl p-2 -mx-2 transition-colors">

          {{-- Mini Cover --}}
          <div class="w-10 h-13 rounded-md overflow-hidden flex-shrink-0 bg-purple-50">
            @if ($book->cover_image)
              <img src="{{ asset('storage/' . $book->cover_image) }}"
                   alt="{{ $book->title }}"
                   class="w-full h-full object-cover">
            @else
              <div class="w-full h-full flex items-center justify-center text-lg">📖</div>
            @endif
          </div>

          {{-- Info --}}
          <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-gray-800 truncate group-hover:text-purple-600 transition-colors">
              {{ $book->title }}
            </p>
            <p class="text-xs text-gray-400 truncate">{{ $book->author }}</p>
          </div>

          {{-- Access type badge --}}
          <span class="text-xs px-2 py-0.5 rounded-full flex-shrink-0
            {{ $book->access_type === 'free' ? 'bg-green-100 text-green-600' : 'bg-purple-100 text-purple-600' }}">
            {{ ucfirst($book->access_type) }}
          </span>
        </a>
      @endforeach
    </div>
  @endif
</div>