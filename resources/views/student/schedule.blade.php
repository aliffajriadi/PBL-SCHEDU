<x-layout title="Shedule" role="teacher">
    <div class="bg-white mb-3 flex flex-row-reverse md:flex-row justify-between p-3 shadow-md rounded-2xl items-center">
        <button onclick="openModal()"
            class="bg-emerald-400 text-white hover:opacity-75 cursor-pointer rounded-2xl py-1 px-2 text-sm transition-all duration-300">
            + Add schedule
        </button>
        <input type="text" id="search" placeholder="Search Note list...."
            class="border-2 border-emerald-400 rounded-2xl py-1 px-2 text-sm w-1/3 md:w-1/4 focus:outline-none focus:ring-2 focus:ring-emerald-300 transition-all"
            onkeyup="getSearch()">
    </div>
    <div class="flex gap-3 mt-3 pb-7 animate-fadeIn w-full">
        <div class="bg-white shadow-md rounded-2xl p-3 w-5/12">
            
        </div>
        <div class="bg-white shadow-md rounded-2xl p-3 w-7/12">
            <x-calender></x-calender>
        </div>
    </div>
</x-layout>