<div class="flex justify-between bg-white shadow-sm rounded-md px-4 py-3">
    <div>
        <p>Active Accounts</p>
        <p class="text-4xl font-bold">{{ $totalAccounts }}</p>
    </div>
    <div class="bg-[#d1ffd8] p-2 rounded-lg h-15 w-15 flex items-center justify-center">
        <img src="{{ asset('icons/activeAcc.svg') }}" alt="Logo" class="h-10 w-auto">
    </div>
</div>

<div class="flex justify-between bg-white shadow-sm rounded-md px-4 py-3">
    <div>
        <p>Active Users</p>
        <p class="text-4xl font-bold">{{ $totalUsers }}</p>
    </div>
    <div class="bg-[#fffbd9] p-2 rounded-lg h-15 w-15 flex items-center justify-center">
        <img src="{{ asset('icons/activeUser.svg') }}" alt="Logo" class="h-10 w-auto">
    </div>
</div>

<div class="flex justify-between bg-white shadow-sm rounded-md px-4 py-3">
    <div>
        <p>Admin</p>
      <p class="text-4xl font-bold">{{ $totalAdmin }}</p>
    </div>
    <div class="bg-[#dad9ff] p-2 rounded-lg h-15 w-15 flex items-center justify-center">
        <img src="{{ asset('icons/activeAdmin.svg') }}" alt="Logo" class="h-10 w-auto">
    </div>
</div>
