@props(['role', 'title', 'user'])


<div class="flex justify-between items-center mb-4">
    <h1 class="text-xl md:text-2xl font-semibold text-emerald-800">
        {{$title}}
    </h1>
    <div class="flex items-center gap-4">
        <!-- Notification Button -->
        <div class="relative">
            <a href="/notification">
                <button
                    class="p-2 bg-emerald-100 rounded-full cursor-pointer hover:bg-emerald-200 transition-all duration-300"
                    title="Notifications">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
            </a>

            <!-- Red Badge -->
            <span id="notification-badge"
                class="{{ session('notification_count') ? '' : 'hidden' }} absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                {{ session('notification_count') }}
            </span>
        </div>
        <!-- Profile Image -->

        @if ($role == "staff")
            @if ($user->logo_instance !== null)
                <img src="{{ asset('storage/' . $user->logo_instance) }}"
                    class="w-12 border-2 border-green-500 h-12 rounded-full shadow-md transition-all duration-300 hover:border-emerald-600 cursor-pointer"
                    alt="{{ $user->instance_name ?? 'Profile' }}" onclick="dropdown('dropdownMenu')" id="dropdownButton" />
            @else
                <div class="bg-emerald-500 border-2 md:flex hidden hover:border-yellow-300 text-white rounded-full w-12 h-12 items-center justify-center text-xl transition-all duration-300 font-semibold cursor-pointer"
                    onclick="dropdown('dropdownMenu')" id="dropdownButton">
                    {{ strtoupper(substr($user->instance_name ?? 'U', 0, 1)) }}
                </div>
            @endif
        @endif






    </div>
</div>
<div id="dropdownMenu"
    class="hidden slide-down origin-top-right right-0 md:mt-12 h-auto me-6 w-56 rounded-md text-sm text-emerald-900 text-center shadow-xl bg-white ring-1 ring-black ring-opacity-5 focus:outline-none p-2 z-30 fixed md:absolute">
    <p class="text-md font-semibold">{{ $role == "staff" ? $user->instance_name : $user[0] }}</p>
    <p style="font-size: smaller">{{$role == "staff" ? $user->email : $user[1]}}</p>
    <p>{{ ucfirst($role) }}</p>
    <hr class="my-2">
    <div class="flex-col flex text-start px-2 space-y-2">
        <a href="profile" class="flex gap-x-1 hover:bg-emerald-300 cursor-pointer rounded-lg py-1 px-3">
            <img src="{{ asset('assets/profile-green.svg') }}" alt="avatar" class="w-5 h-auto">
            <p class="text-sm font-semibold text-emerald-800 transition-all duration-500 hover:text-emerald-600">
                Profile</p>
        </a>
        <form action="logout" method="POST">
            @csrf
            <button type="submit" class="flex gap-x-1 hover:bg-red-300 rounded-lg cursor-pointer py-1 px-3">
                <img src="{{ asset('assets/Log out (1).svg') }}" alt="avatar" class="w-5 h-auto">
                <p class="text-sm font-semibold text-red-600 transition-all duration-500 hover:text-red-600 ">
                    Logout</p>
            </button>
        </form>

    </div>
</div>


