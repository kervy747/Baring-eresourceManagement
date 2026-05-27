<x-layout title="Book Edit">
    <div class="flex justify-center items-center">
      <form method='POST' action="/books/{{ $book->id }}"
      class="grid bg-white w-140 px-5 py-3 rounded-md" enctype='multipart/form-data'>
      @csrf
      @method('PATCH')

      <p class="mx-auto font-bold text-lg xl uppercase mb-4">Edit Book</p>
      <div class="grid grid-cols-2 gap-4 w-full">
        {{-- 1st col --}}
        <div class="grid content-start">
          <x-forms.label>Book </x-forms.label>
          <x-forms.input value="{{ $book->title }}" name='title' type='text' />
          <x-forms.error name='title'/>

          <x-forms.label>Author</x-forms.label>
          <x-forms.input value="{{ $book->author }}" name='author' type='text' />
          <x-forms.error name='author'/>

          <x-forms.label>Category</x-forms.label>
          <div class="outline outline-gray-300 px-3 py-2 rounded-md mb-3">
            <select name="category_id" class="h-6 w-full outline-none">
              @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name}}</option>
              @endforeach
            </select>
          </div>

          <x-forms.label>Access Type</x-forms.label>
          <div class="outline outline-gray-300 px-3 py-2 rounded-md mb-3">
            <select name="access_type" id='access_type' class="h-6 w-full outline-none" onchange="togglePrice()">
              <option value="free" selected>Free</option>
              <option value="paid">Paid</option>
            </select>
          </div>  

          <x-forms.label>Price</x-forms.label>
          <x-forms.input value="{{ $book->price }}" name='price' id='price' type='text' />
          <x-forms.error name='price'/>

          <script>
            function togglePrice () {
              const accessType = document.getElementById('access_type').value;
              const price = document.getElementById('price');

              if (accessType == 'free') {
                price.readOnly = true;
                price.value = '0';
                price.classList.add('!bg-gray-200', 'cursow-not-allowed');
              } else {
                price.readOnly = false;
                price.classList.remove('!bg-gray-200', 'cursow-not-allowed')
              }
            }

            togglePrice();
          </script>
        </div>

        {{-- 2nd col --}}
        <div class="grid content-start w-full">
          <x-forms.label>Description</x-forms.label>
          <textarea class="outline outline-gray-300 rounded-md px-3 py-2 h-52" name='description' type='text'>{{ $book->description }}</textarea>
          <x-forms.error name='description'/>
        </div>
      </div>

      <hr class="border-gray-300 mt-4">

      <div class="flex gap-4 mt-5 justify-end">
        <x-button class="px-2 py-1" type='submit'>Save Edit</x-button>
        <x-button class="px-2 py-1" variant='secondary' onclick="history.back()">Cancel</x-button>
      </div>
      </form>
    </div>
</x-layout>