<div class="bg-white rounded-md shadow-sm border border-gray-100 p-5">

  <div class="flex items-center justify-between mb-4">
    <h2 class="text-base font-semibold text-gray-700">Recent Activity</h2>
    <span class="text-xs text-gray-400">Latest 20 entries</span>
  </div>

  {{-- Table --}}
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="border-b border-gray-100">
          <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide py-2 pr-4">User</th>
          <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide py-2 pr-4">Book</th>
          <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide py-2 pr-4">Action</th>
          <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide py-2 pr-4">Description</th>
          <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide py-2">Date</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-50">

        @forelse ($recentLogs as $log)
          <tr class="hover:bg-gray-50 transition-colors">

            {{-- User --}}
            <td class="py-3 pr-4">
              @if ($log->user)
                <div class="flex items-center gap-2">
                  <div class="bg-purple-600 flex justify-center items-center w-7 h-7 text-white rounded-full text-xs font-semibold flex-shrink-0">
                    {{ strtoupper(substr($log->user->fname, 0, 1)) . strtoupper(substr($log->user->lname, 0, 1)) }}
                  </div>
                  <span class="text-gray-700 font-medium">{{ $log->user->fname }} {{ $log->user->lname }}</span>
                </div>
              @else
                <span class="text-gray-400 italic">Deleted user</span>
              @endif
            </td>

            {{-- Book --}}
            <td class="py-3 pr-4">
              @if ($log->book)
                <span class="text-gray-700 truncate max-w-[160px] block" title="{{ $log->book->title }}">
                  {{ Str::limit($log->book->title, 30) }}
                </span>
              @else
                <span class="text-gray-400 italic">Deleted book</span>
              @endif
            </td>

            {{-- Action Badge --}}
            <td class="py-3 pr-4">
              @php
                $badgeClass = match($log->action) {
                  'downloaded' => 'bg-purple-100 text-purple-700',
                  'purchased'  => 'bg-green-100 text-green-700',
                  'uploaded'   => 'bg-blue-100 text-blue-700',
                  default      => 'bg-gray-100 text-gray-600',
                };
              @endphp
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeClass }}">
                {{ ucfirst($log->action) }}
              </span>
            </td>

            {{-- Description --}}
            <td class="py-3 pr-4 text-gray-500 max-w-[200px]">
              <span class="truncate block" title="{{ $log->description }}">
                {{ $log->description ?? '—' }}
              </span>
            </td>

            {{-- Date --}}
            <td class="py-3 text-gray-400 whitespace-nowrap">
              {{ $log->created_at->format('M d, Y') }}
              <span class="block text-xs text-gray-300">{{ $log->created_at->format('h:i A') }}</span>
            </td>

          </tr>
        @empty
          <tr>
            <td colspan="5" class="py-12 text-center text-gray-400">
              <div class="flex flex-col items-center gap-2">
                <span class="text-3xl">📭</span>
                <span class="text-sm">No activity recorded yet.</span>
              </div>
            </td>
          </tr>
        @endforelse

      </tbody>
    </table>
  </div>

  {{-- Pagination --}}
  @if ($recentLogs->hasPages())
    <div class="mt-4 border-t border-gray-100 pt-4">
      {{ $recentLogs->links() }}
    </div>
  @endif

</div>