<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
  <h2 class="text-base font-semibold text-gray-700 mb-4">Top Categories</h2>

  @if ($topCategories->isEmpty())
    <p class="text-gray-400 text-sm text-center py-6">No data yet.</p>
  @else
    @php $maxCount = $topCategories->first()->downloads_count ?: 1; @endphp

    <div class="space-y-3">
      @foreach ($topCategories as $category)
        <div class="my-12">
          <div class="flex items-center justify-between mb-1">
            <a href="/categories" class="text-sm text-gray-700 font-medium hover:text-purple-600 transition-colors">
              {{ $category->name }}
            </a>
            <span class="text-xs text-gray-400">{{ number_format($category->downloads_count) }} downloads</span>
          </div>
          {{-- Progress bar --}}
          <div class="w-full bg-gray-100 rounded-full h-1.5">
            <div
              class="bg-purple-500 h-1.5 rounded-full transition-all duration-500"
              style="width: {{ ($category->downloads_count / $maxCount) * 100 }}%">
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</div>