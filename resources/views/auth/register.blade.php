  <x-layout :showNav="false" bg='bg-[#fefcff]' title="Register">
    <div class="flex justify-center items-center h-screen">
      <form method="POST" action="/register"
      class="grid w-full max-w-md bg-white px-6 py-4 rounded-xl shadow-[0_10px_30px_#6B49FF40] gap-1">
        @csrf

        <div class="flex justify-center items-center">
          <img src="https://i.imgur.com/xdRZ2Sy.png" alt="logo"
          referrerpolicy="no-referrer"
          class="h-11 items-center">
          <h1 class="pl-2 font-bold text-2xl uppercase text-[#6B49FF]"> RESHUB </h1>
        </div>

        <div class="flex flex-col  justify-center items-center mt-2">
          <p class="font-medium text-lg">Register Now!</p>
        </div>

        <x-forms.label>First Name</x-forms.label>
        <x-forms.input :value="old('fname')" name='fname' type='text'/>
        <x-forms.error name='fname' />

        <x-forms.label>Last Name</x-forms.label>
        <x-forms.input :value="old('lname')" name='lname' type='text'/>
        <x-forms.error name='lname' />

        <x-forms.label>Email</x-forms.label>
        <x-forms.input :value="old('email')" name='email' type='email'/>
        <x-forms.error name='email' />

        <x-forms.label>Password</x-forms.label>
        <x-forms.input :value="old('password')" name='password' type='password'/>
        <x-forms.error name='password'/>

        <x-forms.label>Confirm Password</x-forms.label>
        <x-forms.input name='password_confirmation' type='password'/>
        <x-forms.error name='password_confirmation' />

        <div class="flex gap-5 mt-4 mb-3">
          <x-button class="px-3 py-2" type="submit">Register</x-button>
          <x-button onclick="history.back()" class="px-3 py-2" type='reset' variant='secondary'>Cancel</x-button>
        </div>

      </form>
    </div>
  </x-layout>