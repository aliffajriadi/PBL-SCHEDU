@props(['role'])

<aside id="menuMobile"
    class="w-4/5 max-w-xs bg-emerald-500 text-white flex-col p-5 fixed z-50 md:hidden overflow-y-auto">
    <div class="flex justify-between items-center mb-6 pt-3">
        <img src="{{ asset('image/logowhite.png') }}" alt="logo" class="w-28 h-auto" />
        <button class="text-white" onclick="toggleMenu()">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- MENU -->
    <p class="text-sm py-2 text-emerald-100 font-medium">MENU</p>
    <div>
        <a href="{{ $role== 'staff' ? '/staff/dashboard' : '/dashboard' }}"
            class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
            <img src="{{ asset('assets/Home.svg') }}" class="w-5 h-auto" />
            <p class="font-semibold">Dashboard</p>
        </a>

        @if ($role == 'student' or $role == 'teacher')
            <a href="/note"
                class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                <img src="{{ asset('assets/bx-notepad 2.svg') }}" class="w-5 h-auto" />
                <p class="font-semibold">Notes</p>
            </a>
            <a href="/task"
                class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                <img src="{{ asset('assets/bx-task (1) 2.svg') }}" class="w-5 h-auto" />
                <p class="font-semibold">Task</p>
            </a>
            <a href="/schedule"
                class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                <img src="{{ asset('assets/calender-white.svg') }}" class="w-5 h-auto" />
                <p class="font-semibold">Schedule</p>
            </a>
        @endif

        <a href="/notification"
            class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
            <div class="flex items-center gap-2">
                <img src="{{ asset('assets/notifications.svg') }}" class="w-5 h-auto" />
                <p class="font-semibold">Notification</p>
            </div>
            <p class="text-xs text-emerald-50 bg-red-500 rounded-full px-2 py-1">3</p>
        </a>

        @if (in_array($role, ['student', 'teacher']))
            <!-- GROUP -->
            <p class="text-sm py-2 mt-4 text-emerald-100 font-medium">GROUP</p>
            <div>
                <a href="/groups"
                    class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                    <img src="{{ asset('assets/bx-group (1) 3.svg') }}" class="w-5 h-auto" />
                    <p class="font-semibold">Group</p>
                </a>

                <div class="ps-5">
                    <a href="/group"
                        class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                        <img src="{{ asset('assets/Home.svg') }}" class="w-5 h-auto" />
                        <p class="font-semibold">Group Dashboard</p>
                    </a>
                    <a href="/group/note"
                        class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                        <img src="{{ asset('assets/bx-notepad 2.svg') }}" class="w-5 h-auto" />
                        <p class="font-semibold">Group Notes</p>
                    </a>

                    <a href="/group/task"
                        class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                        <img src="{{ asset('assets/bx-task (1) 2.svg') }}" class="w-5 h-auto" />
                        <p class="font-semibold">Group Task</p>
                    </a>

                    <a href="/group/schedule"
                        class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                        <img src="{{ asset('assets/calender-white.svg') }}" class="w-5 h-auto" />
                        <p class="font-semibold">Group Schedule</p>
                    </a>
                    @if ($role == 'teacher')
                        <a href="#"
                            class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                            <img src="{{ asset('assets/setting.svg') }}" class="w-5 h-auto" />
                            <p class="font-semibold">Group Settings</p>
                        </a>
                    @endif
                </div>
            </div>
        @endif

        <!-- MANAGE ACCOUNT BY STAFF -->
        @if ($role == 'staff')
            <p class="text-sm py-2 mt-4 text-emerald-100 font-medium">MANAGE</p>
            <div>
                <a href="/staff/account"
                    class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                    <img src="{{ asset('assets/bx-group (1) 3.svg') }}" class="w-5 h-auto" />
                    <p class="font-semibold">Manage Account</p>
                </a>
                <a href="/staff/group"
                    class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                    <img src="{{ asset('assets/bx-group (1) 3.svg') }}" class="w-5 h-auto" />
                    <p class="font-semibold">Manage Group</p>
                </a>
            </div>
        @endif

        <!-- SETTING -->
        <p class="text-sm py-2 mt-4 text-emerald-100 font-medium">SETTING</p>
        <div>
            <a href="{{$role !== 'staff' ? '' : '/staff'}}/profile"
                class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                <img src="{{ asset('assets/profile.svg') }}" class="w-5 h-auto" />
                <p class="font-semibold">Edit Profile</p>
            </a>

            <a href="{{ $role == 'staff' ? '/staff/logout' : '/logout'}}"
                class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                <img src="{{ asset('assets/Log out.svg') }}" class="w-5 h-auto" />
                <p class="font-semibold">Logout</p>
            </a>
        </div>

</aside>