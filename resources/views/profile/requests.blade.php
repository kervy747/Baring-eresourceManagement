<x-layout title="My Requests">
  <div class="max-w-4xl mx-auto py-10 flex gap-6">

    {{-- Sidebar --}}
    <aside class="w-52 shrink-0">
      <div class="overflow-hidden">
        <a href="/profile"
          class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-purple-600 border-l-4 border-transparent transition-colors">
          My Profile
        </a>
        <a href="/profile/requests"
          class="flex items-center gap-3 px-4 py-3 text-sm font-medium bg-purple-50 text-purple-700 border-l-4 border-purple-600">
          My Requests
        </a>
      </div>
    </aside>  

    {{-- Main Content --}}
    <div class="flex-1">

      <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-800">My Requests</h1>
        <p class="text-gray-400 text-sm mt-1">Track your submitted books and categories.</p>
      </div>

      {{-- Type Tabs: Books / Categories --}}
      <div class="flex gap-2 mb-4">
        <a href="{{ url('/profile/requests') }}?type=books&status={{ $status }}"
          class="px-4 py-1.5 rounded-md text-sm font-medium transition-colors
          {{ $type === 'books'
              ? 'bg-purple-600 text-white'
              : 'bg-white border border-gray-200 text-gray-500 hover:text-purple-600 hover:border-purple-300' }}">
          Books
        </a>
        <a href="{{ url('/profile/requests') }}?type=categories&status={{ $status }}"
          class="px-4 py-1.5 rounded-md text-sm font-medium transition-colors
          {{ $type === 'categories'
              ? 'bg-purple-600 text-white'
              : 'bg-white border border-gray-200 text-gray-500 hover:text-purple-600 hover:border-purple-300' }}">
          Categories
        </a>
      </div>

      {{-- Status Filter --}}
      <div class="flex gap-2 mb-6">
        @foreach(['all' => 'All', 'pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'] as $key => $label)
          <a href="{{ url('/profile/requests') }}?type={{ $type }}&status={{ $key }}"
            class="px-4 py-1.5 rounded-lg text-sm font-medium transition-colors
            {{ $status === $key
                ? 'bg-gray-800 text-white'
                : 'bg-white border border-gray-200 text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            {{ $label }}
          </a>
        @endforeach
      </div>

      {{-- List --}}
      @if($items->isEmpty())
        <div class="bg-white rounded-md border border-gray-100 shadow-sm p-12 text-center">
          <p class="text-gray-500 font-medium">No {{ $type }} requests found.</p>
          <p class="text-gray-400 text-sm mt-1">
            {{ $status === 'all' ? "You haven't submitted any {$type} yet." : "No {$status} {$type} requests." }}
          </p>
        </div>
      @else
        <div class="space-y-4">
          @foreach($items as $item)
            <div class="bg-white rounded-md border border-gray-100 shadow-sm p-5">

              <div class="flex items-start justify-between gap-4">
                <div>
                  <h3 class="font-semibold text-gray-800">{{ $item->title ?? $item->name }}</h3>

                  {{-- Book: show category. Category: show description --}}
                  @if($type === 'books')
                    <p class="text-gray-400 text-sm mt-0.5">{{ $item->category->name ?? 'Uncategorized' }}</p>
                  @else
                    <p class="text-gray-400 text-sm mt-0.5">{{ Str::limit($item->description, 60) ?? 'No description' }}</p>
                  @endif

                  <p class="text-xs text-gray-300 mt-1">Submitted {{ $item->created_at->diffForHumans() }}</p>
                </div>

                @php
                  $badge = match($item->status) {
                    'approved' => 'bg-green-100 text-green-700',
                    'rejected' => 'bg-red-100 text-red-600',
                    default    => 'bg-yellow-100 text-yellow-700',
                  };
                @endphp
                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $badge }} shrink-0">
                  {{ ucfirst($item->status ?? 'Pending') }}
                </span>
              </div>

              {{-- Rejection reason (books only — categories have no rejection_reason column) --}}
              @if($item->status === 'rejected')
                @if($type === 'books' && $item->rejection_reason)
                  <div class="mt-3 bg-red-50 border border-red-100 rounded-md px-4 py-3">
                    <p class="text-xs font-semibold text-red-600 mb-0.5">Rejection Reason</p>
                    <p class="text-xs text-red-500">{{ $item->rejection_reason }}</p>
                  </div>
                @else
                  <div class="mt-3 bg-red-50 border border-red-100 rounded-xl px-4 py-3">
                    <p class="text-xs text-red-500">Your request was rejected. Contact an admin for more details.</p>
                  </div>
                @endif
              @endif

            </div>
          @endforeach
        </div>

        <div class="mt-6">
          {{ $items->appends(['type' => $type, 'status' => $status])->links() }}
        </div> 
         
      @endif

    </div>
  </div>
</x-layout>