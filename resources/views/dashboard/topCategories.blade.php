<div class="bg-white rounded-md shadow-sm px-4 py-4 h-full">
  <div class="flex justify-between items-center mb-4">
    <p class="font-semibold">Top Categories</p>
    <a href="/categories" class="font-medium text-sm text-purple-600">View All</a>
  </div>

  @foreach($topCategories as $index => $category)
    <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0 my-7">
      <div class="flex items-center gap-3">

        <div class="w-2 h-2 rounded-full bg-purple-500">
        </div>

        <p class="text-sm">{{ $category->name }}</p>
      </div>

      <p class="text-sm font-medium text-gray-600">{{ $category->downloads_count }}</p>
    </div>
  @endforeach
</div>