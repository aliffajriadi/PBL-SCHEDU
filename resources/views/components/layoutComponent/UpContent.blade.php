@props(['role', 'title'])


<div class="flex justify-between items-center mb-4">
    <h1 class="text-xl md:text-2xl font-semibold text-emerald-800">
        {{$title}}
    </h1>
    <img src="{{ asset('image/Ryan-Gosling.jpg') }}" id="dropdownButton" onclick="dropdown('dropdownMenu')"
        class="w-12 hidden md:block h-12 cursor-pointer hover:w-14 hover:h-14 transition-all duration-700 rounded-full border-2 border-green-600"
        alt="profile" />
</div>
<div id="dropdownMenu"
    class="hidden slide-down origin-top-right right-0 md:mt-12 h-auto me-6 w-56 rounded-md text-sm text-emerald-900 text-center shadow-xl bg-white ring-1 ring-black ring-opacity-5 focus:outline-none p-2 z-30 fixed md:absolute">
    <p class="text-md font-semibold">Ryan Gosling</p>
    <p style="font-size: smaller">ryangosling@gmail.com</p>
    <p>{{ ucfirst($role) }}</p>
    <hr class="my-2">
    <div class="flex-col flex text-start px-2 space-y-2">
        <a class="flex gap-x-1 hover:bg-emerald-300 cursor-pointer rounded-lg py-1 px-3">
            <img src="{{ asset('assets/profile-green.svg') }}" alt="avatar" class="w-5 h-auto">
            <p
                class="text-sm font-semibold text-emerald-800 transition-all duration-500 hover:text-emerald-600">
                Profile</p>
        </a>
        <a class="flex gap-x-1 hover:bg-red-300 rounded-lg cursor-pointer py-1 px-3">
            <img src="{{ asset('assets/Log out (1).svg') }}" alt="avatar" class="w-5 h-auto">
            <p class="text-sm font-semibold text-red-600 transition-all duration-500 hover:text-red-600 ">
                Logout</p>
        </a>
    </div>
</div>