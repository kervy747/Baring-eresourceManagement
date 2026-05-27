<div class="bg-white rounded-md shadow-sm px-4 py-4 h-full">
  <div class="flex justify-between items-center mb-4">
    <p class="font-medium text-lg">Recent Activity</p>
    <a href="/activity" class="font-medium text-sm text-purple-600">View All</a>
  </div>
  {{-- activity list --}}
  @foreach($recentActivity as $activity)
    <div class="flex items-center gap-3 py-2 border-b border-gray-100 m-1">
      <div class="flex-1">
        <p class="font-medium text-sm">{{ $activity->book?->title ?? 'N/A' }}</p>
        <p class="text-xs text-gray-400">{{ $activity->description }}</p>
      </div>
       <p class="text-xs text-gray-400">{{ $activity->created_at->diffForHumans() }}</p>
    </div>
  @endforeach  
</div>