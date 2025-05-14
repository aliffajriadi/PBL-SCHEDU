@props(['group_name' => '', 'type', 'page'])


@php

    $group_code = Request::segment(2);    
    $path = '/group/' . $group_code;
    $page_segment = Request::segment(3);

    $role = session('role');
@endphp


<div class="bg-white shadow-md items-center rounded-2xl w-full p-3 flex justify-between flex-col md:flex-row">
    <!-- Mobile Menu Button -->
    <div class="flex justify-between items-center w-full md:hidden">
        <button id="mobile-menu-button" class="text-emerald-600 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        <a href="" class="bg-emerald-200 p-2 rounded-md">
            <img src="{{asset('assets/calender-white.svg')}}" alt="Calendar" class="w-6 h-6">
        </a>
    </div>

    <!-- Mobile Menu (Hidden by default, Icons only) -->
    <div id="mobile-menu" class="hidden flex justify-around items-center w-full mt-3 md:hidden">
        <a href="{{ $path }}/" class="hover:text-emerald-400 transition-all duration-300" title="Dashboard">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
        </a>
        <a href="{{ $path }}/note" class="hover:text-emerald-400 transition-all duration-300" title="Notes">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
        </a>
        <a href="{{ $path }}/task" class="hover:text-emerald-400 transition-all duration-300" title="Task">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01m-.01 4h.01"></path>
            </svg>
        </a>
        <a href="{{ $path }}/schedule" class="hover:text-emerald-400 transition-all duration-300" title="Schedule">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
        </a>
        @if($role === 'teacher')

        <a href="{{ $path }}/settings" class="hover:text-emerald-400 transition-all duration-300" title="Settings">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 shark 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
        </a>
        @endif
    </div>

    <!-- Desktop Menu -->
    <div class="hidden md:flex gap-2 text-sm">
        <a href="{{ $path }}" class="hover:bg-emerald-400 hover:text-white rounded-md px-3 py-1.5 transition-all duration-300 {{ $page_segment === null ? 'bg-emerald-400 text-white' : '' }}">Dashboard</a>
        <a href="{{ $path }}/note" class="hover:bg-emerald-400 hover:text-white rounded-md px-3 py-1.5 transition-all duration-300 {{ $page_segment === 'note' ? 'bg-emerald-400 text-white' : '' }}">Notes</a>
        <a href="{{ $path }}/task" class="hover:bg-emerald-400 hover:text-white rounded-md px-3 py-1.5 transition-all duration-300 {{ $page_segment === 'task' ? 'bg-emerald-400 text-white' : '' }}">Task</a>
        <a href="{{ $path }}/schedule" class="hover:bg-emerald-400 hover:text-white rounded-md px-3 py-1.5 transition-all duration-300 {{ $page_segment === 'schedule' ? 'bg-emerald-400 text-white' : '' }}">Schedule</a>
        @if($role === 'teacher')
        <a href="{{ $path }}/settings" class="hover:bg-emerald-400 hover:text-white rounded-md px-3 py-1.5 transition-all duration-300 {{ $page_segment === 'settings' ? 'bg-emerald-400 text-white' : '' }}">Settings</a>
        @endif
    </div>

    <!-- Conditional Content (Hidden when mobile menu is open) -->
    <div id="conditional-content" class="mt-2 md:mt-0 w-full md:w-auto">
        @if ($type == "name")
        <p class="text-sm text-center md:text-left">{{ $group_name }}</p>
        @elseif ($type == "search")
        <input type="text" id="search" placeholder="Search {{$page}}...."
               class="w-full full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-300 transition-all"
               onkeyup="getSearch()">
        @endif
    </div>
</div>

<script>
    // Toggle Mobile Menu and Conditional Content
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        const mobileMenu = document.getElementById('mobile-menu');
        const conditionalContent = document.getElementById('conditional-content');
        mobileMenu.classList.toggle('hidden');
        mobileMenu.classList.add('slide-down');
        conditionalContent.classList.toggle('hidden');
    });

    // Search Functionality
    function getSearch() {
        let input = document.getElementById("search").value.toLowerCase();
        let items = document.querySelectorAll(".{{$page}}");

        items.forEach(item => {
            let text = item.textContent.toLowerCase();
            if (text.includes(input)) {
                item.classList.remove("hidden");
            } else {
                item.classList.add("hidden");
            }
        });
    }
</script>