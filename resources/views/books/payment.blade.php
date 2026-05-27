<x-layout title="Payment">
    <div class="grid justify-center items-center">
        <div class="bg-white rounded-md shadow-sm px-6 py-6 w-150">
            
            <p class="font-bold text-xl mb-4">Order Summary</p>
            <hr class="border-gray-200 mb-4">

            {{-- Book Info --}}
            <div class="flex gap-4 mb-6">
                <img src="{{ asset('storage/' . $book->cover_image) }}" 
                     class="w-16 h-20 object-cover rounded-md">
                <div>
                    <p class="font-semibold">{{ $book->title }}</p>
                    <p class="text-sm text-gray-500">{{ $book->author }}</p>
                    <span class="bg-purple-200 px-2 py-0.5 rounded-full text-xs font-bold">
                        {{ $book->category->name }}
                    </span>
                </div>
            </div>

            <hr class="border-gray-200 mb-4">

            {{-- Price Breakdown --}}
            <div class="flex flex-col gap-2 text-sm mb-6">
                <div class="flex justify-between">
                    <span class="text-gray-500">Base Price</span>
                    <span>₱{{ number_format($book->price, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">VAT (12%)</span>
                    <span>₱{{ number_format($book->price * 0.12, 2) }}</span>
                </div>
                <hr class="border-gray-200">
                <div class="flex justify-between font-bold">
                    <span>Total</span>
                    <span>₱{{ number_format($book->price * 1.12, 2) }}</span>
                </div>
            </div>

            {{-- Flash Messages --}}
            @if(session('error'))
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded-md text-sm mb-4">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Actions --}}
            <div class="flex gap-3">
                <form method="POST" action="/books/{{ $book->id }}/payment">
                    @csrf
                    <x-button type='submit' class="px-6 py-2">
                        Confirm Purchase
                    </x-button>
                </form>
                <x-button variant='secondary' href='/books/{{ $book->id }}' 
                    class="px-6 py-2 outline-2">
                    Cancel
                </x-button>
            </div>

        </div>
    </div>
</x-layout>