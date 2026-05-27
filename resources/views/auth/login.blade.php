  <x-layout :showNav="false" bg='bg-[#fefcff]' title="Login">
    <div class="grid grid-cols-[65%_35%] h-screen">

     <div class="flex flex-col justify-center items-center">
        <img src="https://i.imgur.com/1Fnlsce.png" alt="photo"
        class="pt-10 h-130"
        referrerpolicy="no-referrer">

        <div class="grid mt-5 gap-2 items-center text-center">
          <h1 class="text-4xl font-bold text-[#6B49FF]">Unlock Knowledge, One Book at a Time</h1>
          <p class="text-sm">Whether you're here to read or publish, ResHub is the place where great books find great readers.</p>
          <p></p>
        </div>
      </div>

      <div class="grid items-center pr-20 w-full">
        <form method="POST" action="/login"
        class="shadow-[0_10px_30px_#6B49FF40] bg-white grid mx-auto w-full px-8 py-8 gap-1 rounded-xl">
        @csrf

          <div class="flex justify-center items-center">
            <img src="https://i.imgur.com/xdRZ2Sy.png" alt="logo"
            referrerpolicy="no-referrer"
            class="h-13 items-center">
             <h1 class="pl-2 font-bold text-2xl uppercase text-[#6B49FF]"> RESHUB </h1>
          </div>

          <div class="flex flex-col  justify-center items-center mt-5">
            <p class="font-medium text-lg">Welcome Back!</p>
            <p class="text-gray-700 text-xs">Login to continue your reading journey</p>
          </div>

          <x-forms.label class="mt-6">Email</x-forms.label>
          <x-forms.input :value="old('email')" name='email' type='email'/>
          <x-forms.error name='email'/>

          <x-forms.label>Password</x-forms.label>
          <x-forms.input :value="old('password')" name='password' type='password'/>
          <x-forms.error name='password'/>

          <x-button class="px-3 py-2 mt-4 mb-2" type='submit'>Log in</x-button>

          <div class="flex items-center">
            <div class="flex-grow border-t border-gray-400"></div>
            <span class="text-xs px-3">OR</span>
            <div class="flex-grow border-t border-gray-400"></div>
          </div>
          
          <x-button variant='default' class="bg-purple-50 px-3 py-2 mt-2 rounded-md outline-2 outline-[#6B49FF] text-[#6B49FF] font-medium text-center" href='/'>Continue as Guest</x-button>

          <div class="flex justify-center mt-4">
            <a href='/register' class="text-sm px-3 py-2">No Account yet? <span class="text-[#6B49FF]">Register Now!</span></a>
          </div>
          
        </form>
      </div>
    </div>
  </x-layout>