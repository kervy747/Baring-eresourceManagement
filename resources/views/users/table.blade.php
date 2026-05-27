{{-- top container --}}

<div class=" flex justify-between mb-6 items-center">
  <div>
    <p class="font-medium text-lg">Users List</p>
  </div>
  <div class="flex gap-3 items-center">
    <form method="GET" class="flex gap-3 items-center">
      {{-- search --}}
      <div class="relative flex outline outline-gray-200 rounded-md items-center">
        <img 
          class="absolute h-5 left-3 opacity-50"
          src="https://i.imgur.com/CVkFdDe.png" 
          alt="search"
          referrerpolicy="no-referrer">
        <input 
          class="rounded-md pl-10 py-2"
          type="text" 
          name="search"
          value="{{ request('search') }}"
          placeholder="Search Users..."
          oninput="clearTimeout(window.timer); window.timer = setTimeout(() => this.form.submit(), 500)">
      </div>

      {{-- roles --}}
      <div class="bg-purple-200 rounded-md px-3 py-2">
        <select name="roles" class="rounded-md outline-none w-40" onchange="this.form.submit()">
          <option value="all" {{ request('roles') === 'all' ? 'selected' : '' }}>All Roles</option>
          <option value="admin" {{ request('roles') === 'admin' ? 'selected' : '' }}>Admin</option>
          <option value="user" {{ request('roles') === 'user' ? 'selected' : '' }}>User</option>
        </select>
      </div>

      {{-- status --}}
      <div class="bg-purple-200 rounded-md px-3 py-2">
        <select name="status" class="rounded-md outline-none w-40" onchange="this.form.submit()">
          <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>All Status</option>
          <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
          <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
      </div>
    </form>
    <x-button class="py-1.5 px-2 shadow-sm" href='/users/create'>&#43; Add User</x-button>
  </div>
</div>


{{-- table container --}}
<div class="overflow-x-auto">
  
  <table class="min-w-full text-md text-left">

    {{-- Header --}}
    <thead class="text-gray-600 text-md border-t border-b border-gray-300">
      <tr >
        <th class="px-6 py-4">User</th>
        <th class="px-6 py-4">Email</th>
        <th class="px-6 py-4">Role</th>
        <th class="px-6 py-4">Join Date</th>
        <th class="px-6 py-4">Status</th>
        <th class="px-6 py-4 text-center">Actions</th>
      </tr>
    </thead>
    
    {{-- Body --}}
    <tbody class="divide-y divide-gray-200 text-gray-700">

      @foreach ($users as $user)
         <tr class="hover:bg-gray-50">

          <td class="px-6 py-4 font-medium">
            {{$user->fullName()}}
          </td>
          <td class="px-6 py-4">
            {{ $user->email }}
          </td>
          <td class="px-6 py-4">
            {{ $user->role }}
          </td>
          <td class="px-6 py-4">
            {{ $user->created_at }}
          </td>
          <td class="px-6 py-4 uppercase">
            @if ($user->status==='active')
              <span  class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">{{ $user->status}}</span>
            @else 
              <span  class="px-3 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">{{ $user->status }}</span>
            @endif
            
          </td>

          <td class="px-6 py-4">
            <div class="flex justify-center gap-3">
              @if ($user->role === 'admin' && !auth()->user()->isSuperAdmin())
                <a class="p-2 rounded-lg bg-gray-200 cursor-not-allowed">
                  <img src="{{ asset('icons/edit.svg') }}" alt="Edit Icon" class="h-5 w-5 opacity-40">
                </a>
              @else
                <a class="p-2 rounded-lg hover:bg-purple-100 transition" href="/users/{{ $user->id }}/edit">
                  <img src="{{ asset('icons/edit.svg') }}" alt="Edit Icon" class="h-5 w-5">
                </a>
              @endif
            </div>
          </td>

        </tr>  
      @endforeach
     

    </tbody>

    {{-- Footer --}}
    <tfoot class="text-sm text-gray-500">
      <tr>
        <td colspan="6" class="px-6 py-3 text-center">
          {{ $users->links() }}
        </td>
      </tr>
    </tfoot>

  </table>

  


</div>