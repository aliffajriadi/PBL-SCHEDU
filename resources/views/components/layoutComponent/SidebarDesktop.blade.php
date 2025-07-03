@props(['role'])
@php
    $path = '/group/' . Request::segment(2);    
@endphp
<aside class="w-64 bg-emerald-500 text-white flex-col p-4 fixed h-screen overflow-y-auto hidden md:flex">
    <div class="flex justify-center bg-emerald-500 mb-2">
        <img src="{{ asset('image/logowhite.png') }}" alt="logo" class="w-36 h-auto" />
    </div>

    <!-- MENU -->
    <p class="text-sm py-2 text-emerald-100 font-medium">MENU</p>
    <div>
        @php
            $isDashboard = $role == 'staff' ? request()->is('staff/dashboard') : request()->is('dashboard');
        @endphp

        <a href="{{ $role == 'staff' ? '/staff/dashboard' : '/dashboard' }}" class="flex items-center gap-2 p-2 rounded-xl cursor-pointer menu-item 
          {{ $isDashboard ? 'bg-green-400' : 'hover:bg-green-400' }}">
            <img src="{{ asset('assets/Home.svg') }}" class="w-5 h-auto" />
            <p class="font-semibold">Dashboard</p>
        </a>


        @if ($role == 'teacher' or $role == 'student')
            <a href="/note" class="flex items-center gap-2 p-2 rounded-xl cursor-pointer menu-item 
                   hover:bg-green-400 
                   {{ Request::is('note') ? 'bg-green-400 text-white' : '' }}">
                <img src="{{ asset('assets/bx-notepad 2.svg') }}" class="w-5 h-auto" />
                <p class="font-semibold">Notes</p>
            </a>

            <a href="/task" class="flex items-center gap-2 p-2 rounded-xl cursor-pointer menu-item 
                   hover:bg-green-400 
                   {{ Request::is('task') ? 'bg-green-400 text-white' : '' }}">
                <img src="{{ asset('assets/bx-task (1) 2.svg') }}" class="w-5 h-auto" />
                <p class="font-semibold">Task</p>
            </a>

            <a href="/schedule" class="flex items-center gap-2 p-2 rounded-xl cursor-pointer menu-item 
                   hover:bg-green-400 
                   {{ Request::is('schedule') ? 'bg-green-400 text-white' : '' }}">
                <img src="{{ asset('assets/calender-white.svg') }}" class="w-5 h-auto" />
                <p class="font-semibold">Schedule</p>
            </a>

        @endif

        @php
            $notifUrl = $role == "staff" ? "/staff/notification" : "/notification";
            $isActive = request()->is(ltrim($notifUrl, '/')) ? 'bg-green-400' : '';
        @endphp

        <a href="{{ $notifUrl }}"
            class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item {{ $isActive }}">
            <div class="flex items-center gap-2">
                <img src="{{ asset('assets/notifications.svg') }}" class="w-5 h-auto" />
                <p class="font-semibold">Notification</p>
            </div>
            <p id="side-notif-badge"
                class="{{ session('notification_count') ? '' : 'hidden' }} text-xs text-emerald-50 bg-red-500 rounded-full px-2 py-1">
                {{ session('notification_count') }}
            </p>
        </a>

    </div>
    @if (in_array($role, ['student', 'teacher']))
        <!-- GROUP -->
        <p class="text-sm py-2 mt-4 text-emerald-100 font-medium">GROUP</p>
        <div>
            <a href="/group" class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item">
                <img src="{{ asset('assets/bx-group (1) 3.svg') }}" class="w-5 h-auto" />
                <p class="font-semibold">Group</p>
            </a>

            @if(Request::segment(1) === 'group' && Request::segment(2) !== null)
                <div class="ps-5">
                    <a href="/group" class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item">
                        <img src="{{ asset('assets/Home.svg') }}" class="w-5 h-auto" />
                        <p class="font-semibold">Group Dashboard</p>
                    </a>
                    <a href="{{ $path }}/note"
                        class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item">
                        <img src="{{ asset('assets/bx-notepad 2.svg') }}" class="w-5 h-auto" />
                        <p class="font-semibold">Group Notes</p>
                    </a>
                    <a href="{{ $path }}/task"
                        class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item">
                        <img src="{{ asset('assets/bx-task (1) 2.svg') }}" class="w-5 h-auto" />
                        <p class="font-semibold">Group Task</p>
                    </a>
                    <a href="{{ $path }}/schedule"
                        class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item">
                        <img src="{{ asset('assets/calender-white.svg') }}" class="w-5 h-auto" />
                        <p class="font-semibold">Group Schedule</p>
                    </a>
                    @if ($role == 'teacher')
                        <a href="{{ $path }}/settings"
                            class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item">
                            <img src="{{ asset('assets/setting.svg') }}" class="w-5 h-auto" />
                            <p class="font-semibold">Group Settings</p>
                        </a>
                    @endif

                </div>

            @endif


        </div>
    @endif



    <!-- MANAGE ACCOUNT BY STAFF -->
    @if ($role == 'staff')
        <p class="text-sm py-2 mt-4 text-emerald-100 font-medium">MANAGE</p>
        <div>
            <a href="/staff/account"
                class="flex items-center {{ request()->is('staff/account') ? 'bg-green-400' : 'hover:bg-green-400' }} gap-2 p-2 rounded-xl cursor-pointer menu-item">
                <img src="{{ asset('assets/bx-group (1) 3.svg') }}" class="w-5 h-auto" />
                <p class="font-semibold">Manage Account</p>
            </a>
            <a href="/staff/group"
                class="flex items-center gap-2 p-2 {{ request()->is('staff/group') ? 'bg-green-400' : 'hover:bg-green-400' }} rounded-xl cursor-pointer menu-item">
                <img src="{{ asset('assets/bx-group (1) 3.svg') }}" class="w-5 h-auto" />
                <p class="font-semibold">Manage Group</p>
            </a>

        </div>
    @endif


    <!-- SETTING -->
    <p class="text-sm py-2 mt-4 text-emerald-100 font-medium">SETTING</p>
    <div>
        <a href="{{ $role === 'staff' ? '/staff/profile' : '/profile' }}"
            class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item">
            <img src="{{ asset('assets/profile.svg') }}" class="w-5 h-auto" />
            <p class="font-semibold">Edit Profile</p>
        </a>

        <form action="/logout" method="POST"
            class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item">
            @csrf
            <button type="submit" class="flex items-center gap-2 w-full text-left">
                <img src="{{ asset('assets/Log out.svg') }}" class="w-5 h-auto" />
                <p class="font-semibold">Logout</p>
            </button>
        </form>
    </div>

</aside>