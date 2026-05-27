@props(['variant' => 'primary', 'type' => 'button', 'href' => null])

@if ($href)
  <a href="{{ $href }}" {{ $attributes->merge(['class' => match($variant) {
    'primary' => 'bg-[#6B49FF] font-medium text-white rounded-md outline outline-[#6B49FF] text-center',
    'secondary' => 'bg-white rounded-md outline outline-[#6B49FF] text-[#6B49FF] font-medium text-center',
    'danger' => 'bg-red-500 font-medium text-white rounded-md outline-2 outline-red-500 text-center',
    'default' => 'text-center'
  }]) }}> {{ $slot }} </a>
@else
  <button type="{{ $type }}" {{ $attributes->merge(['class' => match($variant) {
    'primary' => 'bg-[#6B49FF] font-medium text-white rounded-md outline outline-[#6B49FF] text-center cursor-pointer',
    'secondary' => 'bg-white rounded-md outline outline-[#6B49FF] text-[#6B49FF] font-medium text-center cursor-pointer',
    'danger' => 'bg-red-500 font-medium text-white rounded-md outline-2 outline-red-500 text-center cursor-pointer',
    'default' => 'text-center cursor-pointer'  
  }]) }}> {{ $slot }} </button>
@endif