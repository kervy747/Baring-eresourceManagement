<x-layout title="Pending Books">
  <div class="grid">

    <div class="grid justify-center items-center">

      {{-- top --}}
      <div class="flex justify-between mb-4 items-center">
        <div>
          <p>
            <span class="font-medium text-purple-600">
              Books Catalog
            </span> 
            / Book Review
          </p>
        </div>

        <div class="flex gap-3">
          <x-button 
            href='/books/{{ $book->id }}/edit' 
            class="flex gap-2 px-4 py-2">

            <img 
              src="{{ asset('icons/editWhite.svg') }}" 
              alt="icon" 
              class="h-4.5">

            Edit Book
          </x-button>

          <x-button 
            variant='secondary' 
            class="flex items-center gap-2 px-4 py-2 outline-2" 
            href='/books/pending'>

            <img 
              src="{{ asset('icons/arrowL.svg') }}" 
              alt="icon" 
              class="h-3">

            Back
          </x-button>
        </div>
      </div>

      {{-- Book Info --}}
      <div class="grid grid-cols-3 gap-4 bg-white rounded-md shadow-sm px-3 py-4 w-250">

        {{-- image --}}
        <div class="col-span-1 overflow-hidden rounded-md">
          <img 
            src="{{ asset('storage/' . $book->cover_image) }}" 
            alt="cover"
            class="w-full h-full object-cover">
        </div>

        {{-- details --}}
        <div class="col-span-1 flex flex-col gap-4 py-2">

          <p class="font-bold text-2xl">
            {{ $book->title }}
          </p>

          {{-- author --}}
          <div class="flex items-center gap-2 text-gray-600">
            <img 
              src="{{ asset('icons/author.svg') }}" 
              class="h-4">

            <p>{{ $book->author }}</p>
          </div>

          {{-- category --}}
          <div class="flex items-center gap-2">
            <span class="bg-purple-200 px-2 py-1 rounded-full text-sm font-bold">
              {{ $book->category->name }}
            </span>

            @if ($book->access_type === 'free')
              <span class="bg-green-200 px-2 py-1 rounded-4xl font-bold">
                Free
              </span>
            @else
              <span class="bg-red-200 px-2 py-1 rounded-4xl font-bold">
                Paid
              </span>
            @endif
          </div>

          {{-- preview --}}
          <div class="flex gap-3">
            <x-button 
              variant='secondary'
              class="w-fit gap-3 flex items-center px-3 py-2 outline-2"
              onclick="togglePreview()">

              <img 
                src="{{ asset('icons/view.svg') }}" 
                alt="icon" 
                class="h-5">

              Preview
            </x-button>
          </div>

          <hr class="border-gray-200">

          {{-- description --}}
          <div>
            <p class="font-semibold mb-1">
              Description
            </p>

            <p class="text-gray-600 text-sm leading-relaxed">
              {{ $book->description }}
            </p>
          </div>

        </div>

        {{-- review panel --}}
        <div class="col-span-1 bg-purple-50 rounded-md px-4 py-4 flex flex-col gap-4">

          <p class="font-semibold text-purple-700">
            Review Decision
          </p>

          <hr class="border-purple-200">

          {{-- info --}}
          <div class="flex justify-between text-sm">
            <span class="text-gray-500">Book ID</span>
            <span class="font-medium">
              #BK-{{ str_pad($book->id, 6, '0', STR_PAD_LEFT) }}
            </span>
          </div>

          <div class="flex justify-between text-sm">
            <span class="text-gray-500">Submitted By</span>
            <span class="font-medium">
              {{ $book->user->fullName() }}
            </span>
          </div>

          <div class="flex justify-between text-sm">
            <span class="text-gray-500">Date Submitted</span>
            <span class="font-medium">
              {{ $book->created_at->format('M d, Y') }}
            </span>
          </div>

          {{-- form --}}
          <form 
            method="POST" 
            action="/books/{{ $book->id }}/approve"
            class="grid gap-4 mt-3">

            @csrf
            @method('PATCH')

            {{-- comment --}}
            <div class="grid gap-2">
              <label class="font-medium text-sm">
                Review Comment
              </label>

              <textarea 
                name="rejection_reason"
                rows="5"
                placeholder="Add approval notes or rejection reason..."
                class="border border-gray-300 rounded-md px-3 py-2 outline-none resize-none bg-white">{{ old('rejection_reason') }}</textarea>

              @error('rejection_reason')
                <p class="text-red-500 text-sm">
                  {{ $message }}
                </p>
              @enderror
            </div>

            {{-- buttons --}}
            <div class="flex gap-3 mt-2">

              {{-- approve --}}
              <button
                type="submit"
                name="status"
                value="approved"
                class="bg-green-500 hover:bg-green-600 transition text-white px-4 py-2 rounded-md flex items-center gap-2">

                <img 
                  src="{{ asset('icons/check.svg') }}" 
                  class="h-4">

                Approve
              </button>

              {{-- reject --}}
              <button
                type="submit"
                name="status"
                value="rejected"
                class="bg-red-500 hover:bg-red-600 transition text-white px-4 py-2 rounded-md flex items-center gap-2">

                <img 
                  src="{{ asset('icons/close.svg') }}" 
                  class="h-4">

                Reject
              </button>

            </div>

          </form>

        </div>

      </div>

      {{-- PDF Preview --}}
      <div 
        id="pdf-preview" 
        class="hidden bg-white rounded-md shadow-sm px-3 py-4 mt-4 w-250 mb-5">

        <p class="font-semibold text-purple-700 mb-3">
          PDF Preview
        </p>

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