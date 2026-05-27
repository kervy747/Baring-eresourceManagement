<x-layout title="My Profile">
  <div class="max-w-4xl mx-auto py-10 flex gap-6">

    {{-- Sidebar --}}
    <aside class="w-52 shrink-0">
      <div class="  overflow-hidden">
        <a href="/profile"
          class="flex items-center gap-3 px-4 py-3 text-sm font-medium bg-purple-50 text-purple-700 border-l-4 border-purple-600">
          My Profile
        </a>
        <a href="/profile/requests"
          class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-purple-600 border-l-4 border-transparent transition-colors">
          My Requests
        </a>
      </div>
    </aside>

    {{-- Main Content --}}
    <div class="flex-1">

      @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md text-sm">
          {{ session('success') }}
        </div>
      @endif

      @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md text-sm">
          <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      {{-- Account Info --}}
      <div class="bg-white rounded-md border border-gray-100 shadow-sm p-6 mb-6">
        <h2 class="text-base font-semibold text-gray-700 mb-4">Account Information</h2>
        <div class="flex items-center gap-4">
          <div class="w-14 h-14 bg-purple-600 rounded-full flex items-center justify-center text-white text-lg font-bold">
            {{ strtoupper(substr(auth()->user()->fname, 0, 1)) . strtoupper(substr(auth()->user()->lname, 0, 1)) }}
          </div>
          <div>
            <p class="font-semibold text-gray-800">{{ auth()->user()->fname }} {{ auth()->user()->lname }}</p>
            <p class="text-gray-400 text-sm">{{ auth()->user()->email }}</p>
            <span class="inline-block mt-1 px-2.5 py-0.5 bg-purple-100 text-purple-700 text-xs rounded-full capitalize">
              {{ auth()->user()->role ?? 'User' }}
            </span>
          </div>
        </div>
      </div>

      {{-- Change Password --}}
      <div class="bg-white rounded-md border border-gray-100 shadow-sm p-6">
        <h2 class="text-base font-semibold text-gray-700 mb-1">Change Password</h2>
        <p class="text-gray-400 text-sm mb-6">Minimum 8 characters.</p>

        <form method="POST" action="/profile/password" class="space-y-5">
          @csrf
          @method('PATCH')

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Current Password</label>
            <input type="password" name="current_password"
              class="w-full border border-gray-200 rounded-md px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent @error('current_password') border-red-400 @enderror"
              placeholder="Enter current password">
            @error('current_password')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">New Password</label>
            <input type="password" name="password"
              class="w-full border border-gray-200 rounded-md px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent @error('password') border-red-400 @enderror"
              placeholder="Enter new password">
            @error('password')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Confirm New Password</label>
            <input type="password" name="password_confirmation"
              class="w-full border border-gray-200 rounded-md px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent"
              placeholder="Confirm new password">
          </div>

          <button type="submit"
            class="bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium px-6 py-2.5 rounded-md transition-colors">
            Update Password
          </button>
        </form>
      </div>

    </div>
  </div>
</x-layout>