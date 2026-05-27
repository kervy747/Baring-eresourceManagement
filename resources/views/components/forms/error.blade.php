@props(['name'])

@error($name)
  <p class="text-red-400 text-xs font-medium -mt-4"> {{ $message }} </p>
@enderror