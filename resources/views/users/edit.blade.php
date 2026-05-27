<x-layout title="Edit Users">
  <div class="flex justify-center">
  <form method="POST" action="/users/{{ $user->id }}"
        class="grid w-full max-w-md bg-white px-6 py-4 rounded-xl shadow-md gap-1">
        @csrf
        @method('PATCH')

        <div class="flex flex-col  justify-center items-center mt-2">
            <p class="font-medium text-lg">Edit Information</p>
        </div>

        <x-forms.label>First Name</x-forms.label>
        <x-forms.input value="{{ $user->fname }}" name='fname' type='text' />
        <x-forms.error name='fname' />

        <x-forms.label>Last Name</x-forms.label>
        <x-forms.input value="{{ $user->lname }}"  name='lname' type='text' />
        <x-forms.error name='lname' />

        <x-forms.label>Email</x-forms.label>
        <x-forms.input value="{{ $user->email }}"  name='email' type='email' />
        <x-forms.error name='email' />

        <x-forms.label>Role</x-forms.label>
        <div class="p-2 border border-gray-300 rounded-md grid mb-4">
          <select name="role" class="border-none outline-none">
            <option disabled selected>Select Role</option>
            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
          </select>
        </div>
        <x-forms.error name='role' />

        <x-forms.label>Status</x-forms.label>
        <div class="p-2 border border-gray-300 rounded-md grid mb-4">
          <select name="status" class="border-none outline-none">
            <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ $user->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
          </select>
        </div>


        <div class="flex gap-5 mt-4 mb-3">
            <x-button class="px-3 py-2" type="submit">Update</x-button>
            <x-button href='/users' class="px-3 py-2" type='reset' variant='secondary'>Cancel</x-button>
        </div>

    </form>
  </div>
</x-layout>
