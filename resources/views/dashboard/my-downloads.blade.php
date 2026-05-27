{{-- dashboard/partials/my-downloads.blade.php --}}
{{-- Variable: $myDownloads → latest 5 activity logs for the current user (downloaded action) --}}

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
  <div class="flex items-center justify-between mb-4">
    <h2 class="text-base font-semibold text-gray-700">📥 My Recent Downloads</h2>
    <a href="/profile/requests" class="text-xs text-purple-500 hover:underline">View all activity</a>
  </div>

  @if ($myDownloads->isEmpty())
    <div class="text-center py-8 text-gray-400">
      <p class="text-3xl mb-2">📭</p>
      <p class="text-sm">You haven't downloaded anything yet.</p>
      <a href="/books" class="text-purple-500 text-sm hover:underline mt-1 inline-block">Browse books</a>
    </div>
  @else
    <div class="space-y-3">
      @foreach ($myDownloads as $log)
        @if ($log->book)
          <a href="/books/{{ $log->book->id }}"
             class="flex items-center gap-3 group hover:bg-gray-50 rounded-xl p-2 -mx-2 transition-colors">

            {{-- Mini Cover --}}
            <div class="w-10 h-13 rounded-md overflow-hidden flex-shrink-0 bg-purple-50">
              @if ($log->book->cover_image)
                <img src="{{ asset('storage/' . $log->book->cover_image) }}"
                     alt="{{ $log->book->title }}"
                     class="w-full h-full object-cover">
              @else
                <div class="w-full h-full flex items-center justify-center text-lg">📖</div>
              @endif
            </div>

            {{-- Info --}}
            <div class="flex-1 min-w-0">
              <p class="text-sm font-medium text-gray-800 truncate group-hover:text-purple-600 transition-colors">
                {{ $log->book->title }}
              </p>
              <p class="text-xs text-gray-400">{{ $log->book->author }}</p>
            </div>

            {{-- Date --}}
            <span class="text-xs text-gray-300 flex-shrink-0">
              {{ $log->created_at->format('M d') }}
            </span>
          </a>
        @endif
      @endforeach
    </div>
  @endif
</div>