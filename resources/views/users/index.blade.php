<x-layout title="Users">

  <div class="grid gap-4">

    <div class="grid grid-cols-3 gap-5">
      @include('users.cards')
    </div>

    <div class="bg-white rounded-md shadow-sm pt-6 pb-3  px-7 mb-5">
      @include('users.table')
    </div>

  </div>

</x-layout> 