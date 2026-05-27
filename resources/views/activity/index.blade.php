<x-layout title="Activity Log">
  <div class="space-y-6">

    {{-- Header row: title + button --}}
    <div class="flex items-center justify-between">
      <h1 class="text-xl font-bold text-gray-800">Activity Log</h1>
      <x-button href="{{ route('activity.exportPdf') }}"
         class="inline-flex items-center gap-2 px-4 py-2 text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M6.75 15.75v3h10.5v-3M6.75 8.25V3.75h10.5V8.25M4.5 8.25h15a1.5 1.5 0 0 1 1.5 1.5v6a1.5 1.5 0 0 1-1.5 1.5H4.5A1.5 1.5 0 0 1 3 15.75v-6a1.5 1.5 0 0 1 1.5-1.5Z" />
        </svg>
        Print Report
      </x-button>
    </div>

    @include('dashboard.stats')
    @include('activity.charts')
    @include('activity.table')

  </div>
</x-layout>