<x-layout title="Add Category">
  
  <form method="POST" action="/categories" class="grid mx-auto w-full max-w-md bg-white px-6 py-4 rounded-md shadow-[0_0_1px_0_black] gap-1">
  @csrf
  
    <h1 class="mx-auto font-bold text-lg xl uppercase mb-4">Add Category</h1>

    <x-forms.label>Category Name</x-forms.label>
    <x-forms.input name="name" type="text" placeholder="e.g. Science Fiction"/>
    <x-forms.error name='name'/>

    <div class="flex gap-5 mt-3 mb-3">
      <x-button name='save' type='submit' variant='primary' class="px-3 py-2">Save</x-button>
      <x-button variant='secondary' href='/categories' class="px-3 py-2" >Cancel</x-button>
    </div>
  </form>

</x-layout>