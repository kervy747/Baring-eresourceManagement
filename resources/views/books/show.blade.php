<x-layout title="Books Catalog">
  <div class="grid">
  

    <div class="grid justify-center items-center">

      {{-- top --}}
      <div class="flex justify-between mb-4 items-center">
        <div>
          <p><span class="font-medium text-purple-600">Books Catalog</span> / Book Details</p>
        </div>
        <div class="flex gap-3">
          <x-button href='/books/{{ $book->id }}/edit' class="flex gap-2 px-4 py-2">
            <img src=" {{ asset('icons/editWhite.svg') }}" alt="icon" class="h-4.5">
            Edit Book
          </x-button>
          <x-button variant='secondary' class="flex items-center gap-2 px-4 py-2 outline-2" href='/books'>
              <img src=" {{ asset('icons/arrowL.svg') }}" alt="icon" class="h-3">
              Back
            </x-button>
        </div>
      </div>

      {{-- Book Info --}}
      <div class="grid grid-cols-3 gap-4 bg-white rounded-md shadow-sm px-3 py-4 h-110 w-250">
        
        {{-- Book image --}}
        <div class="col-span-1 overflow-hidden rounded-md h-full">
          <img src="{{ asset('storage/' . $book->cover_image) }}" alt="cover"
          class="w-full h-full object-cover">
        </div>

        {{-- details --}}
        <div class="col-span-1 flex flex-col gap-4 py-2">
          <p class="font-bold text-2xl">{{ $book->title }}</p>

          {{-- author --}}
          <div class="flex items-center gap-2 text-gray-600">
            <img src="{{ asset('icons/author.svg') }}" class="h-4">
            <p>{{ $book->author }}</p>
          </div>

          {{-- category & downloads --}}
          <div class="flex items-center gap-2">
            <span class="bg-purple-200 px-2 py-1 rounded-full text-sm font-bold">{{ $book->category->name }}</span>
            @if ($book->access_type === 'free')
                    <span class="bg-green-200 px-2 py-1 rounded-4xl font-bold">Free</span>
                @else
                    <span class="bg-red-200 px-2 py-1 rounded-4xl font-bold">Paid</span>
                @endif
            <div class="flex items-center gap-1 text-sm text-gray-500">
              <p class="flex gap-1 items-center">
                  <img src="{{ asset('icons/down.svg') }}" class="h-4">
                  {{ $book->downloads_count }}</p>
            </div>
          </div>

          <div class="flex gap-3">
            @if (auth()->user()->isAdmins())
              <x-button 
                  href="/books/{{ $book->id }}/download"
                  class="border-1 border-[#6B49FF] w-fit gap-3 flex items-center px-3 py-2">
                  <img src="{{ asset('icons/downWhite.svg') }}" alt="icon" class="h-4.5">
                  Download
              </x-button>
              <x-button 
                variant='secondary'
                class="w-fit gap-3 flex items-center px-3 py-2 outline-2"
                onclick="togglePreview()">
                <img src="{{ asset('icons/view.svg') }}" alt="icon" class="h-5">
                Preview
              </x-button>
            @else
              @if ($book->access_type === 'free'  || $hasPurchased)
                <x-button 
                  href="/books/{{ $book->id }}/download"
                  class="border-1 border-[#6B49FF] w-fit gap-3 flex items-center px-3 py-2">
                  <img src="{{ asset('icons/downWhite.svg') }}" alt="icon" class="h-4.5">
                  Download
                </x-button>
                <x-button 
                  variant='secondary'
                  class="w-fit gap-3 flex items-center px-3 py-2 outline-2"
                  onclick="togglePreview()">
                  <img src="{{ asset('icons/view.svg') }}" alt="icon" class="h-5">
                  Preview
                </x-button>
              @else
                <x-button 
                  href="/books/{{ $book->id }}/payment"
                  class="border-1 border-[#6B49FF] w-fit gap-3 flex items-center px-3 py-2">
                  &#8369 {{ $book->price }}
                </x-button>
              @endif
            @endif
          </div>

          <hr class="border-gray-200">

          {{-- description --}}
          <div>
            <p class="font-semibold mb-1">Description</p>
            <p class="text-gray-600 text-sm leading-relaxed">{{ $book->description }}</p>
          </div>
        </div>

        {{-- file info --}}
        <div class="col-span-1 bg-purple-50 rounded-md px-4 py-4 flex flex-col gap-3">
          <p class="font-semibold text-purple-700">Book Information</p>
          <hr class="border-purple-200">

          <div class="flex justify-between text-sm">
            <span class="text-gray-500">Book ID</span>
            <span class="font-medium">#BK-{{ str_pad($book->id, 6, '0', STR_PAD_LEFT) }}</span>
          </div>

          <div class="flex justify-between text-sm">
            <span class="text-gray-500">Added By</span>
            <span class="font-medium">{{ auth()->user()->fullName() }}</span>
          </div>

          <div class="flex justify-between text-sm">
            <span class="text-gray-500">Date Added</span>
            <span class="font-medium">{{ $book->created_at->format('M d, Y') }}</span>
          </div>

          <div class="flex justify-between text-sm">
            <span class="text-gray-500">Last Updated</span>
            <span class="font-medium">{{ $book->updated_at->format('M d, Y') }}</span>
          </div>

          <div class="flex justify-between text-sm">
            <span class="text-gray-500">File Type</span>
            <span class="font-medium">PDF</span>
          </div>

          <div class="flex justify-between text-sm">
            <span class="text-gray-500">Access</span>
            <span class="font-medium uppercase">{{ $book->access_type }}</span>
          </div>

          <div class="flex justify-between text-sm">
            <span class="text-gray-500">Status</span>
            <span class="px-2 py-0.5 rounded-full text-xs font-medium 
              {{ $book->status === 'approved' ? 'bg-green-100 text-green-700' : 
                ($book->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 
                'bg-red-100 text-red-700') }}">
              {{ ucfirst($book->status) }}
            </span>
          </div>
        </div>

      </div>

      {{-- PDF Preview (TBS) --}}
      <div id="pdf-preview" class="hidden bg-white rounded-md shadow-sm px-3 py-4 mt-4 w-250 mb-5">
          <p class="font-semibold text-purple-700 mb-3">PDF Preview</p>
          <hr class="border-purple-200 mb-4">
          <iframe 
              src="{{ asset('storage/' . $book->file_path) }}"
              class="w-full h-[600px] rounded-md border border-gray-200"
              type="application/pdf">
          </iframe>
      </div>

      <script>
        function togglePreview() {
            const preview = document.getElementById('pdf-preview');
            preview.classList.toggle('hidden');
        }
      </script>
    </div>

  </div>
</x-layout> 