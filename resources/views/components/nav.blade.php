@props(['active' => false, 'href' => '/'])

<a href="{{ $href }}" 
   class="mr-12 pb-1 {{ $active ? 'active text-[#6C3EEF] border-[#6C3EEF] underline underline-offset-33 decoration-[3px]' : 'text-black'}}">
   {{ $slot }}
</a>