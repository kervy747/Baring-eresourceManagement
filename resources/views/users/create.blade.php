<x-layout title="Add User">
  <div class="flex justify-center">
  <form method="POST" action="/users"
        class="grid w-full max-w-md bg-white px-6 py-4 rounded-xl shadow-md gap-1">
        @csrf

        <div class="flex flex-col  justify-center items-center mt-2">
            <p class="font-medium text-lg">Add New User</p>
        </div>

        <x-forms.label>First Name</x-forms.label>
        <x-forms.input :value="old('fname')" name='fname' type='text' />
        <x-forms.error name='fname' />

        <x-forms.label>Last Name</x-forms.label>
        <x-forms.input :value="old('lname')" name='lname' type='text' />
        <x-forms.error name='lname' />

        <x-forms.label>Email</x-forms.label>
        <x-forms.input :value="old('email')" name='email' type='email' />
        <x-forms.error name='email' />

        <x-forms.label>Role</x-forms.label>
        <div class="p-2 border border-gray-300 rounded-md grid mb-4">
          <select name="role" class="border-none outline-none">
            @if (auth()->user()->isSuperAdmin())
              <option disabled selected>Select Role</option>
                <option value="admin">Admin</option>
            @endif
            <option value="user">User</option>
          </select>
        </div>
        <x-forms.error name='role' />


        <x-forms.label>Password</x-forms.label>
        <x-forms.input :value="old('password')" name='password' type='password' />
        <x-forms.error name='password' />

        <x-forms.label>Confirm Password</x-forms.label>
        <x-forms.input name='password_confirmation' type='password' />
        <x-forms.error name='password_confirmation' />

        <div class="flex gap-5 mt-4 mb-3">
            <x-button class="px-3 py-2" type="submit">Add</x-button>
            <x-button href='/users' class="px-3 py-2" type='reset' variant='secondary'>Cancel</x-button>
        </div>

    </form>
  </div>
</x-layout>
