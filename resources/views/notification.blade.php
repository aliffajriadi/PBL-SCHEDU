<x-layout title="Notification" role="teacher">
    <div class="bg-white mb-3 flex md:flex-row justify-between p-3 shadow-md rounded-2xl items-center">
        <button class="bg-emerald-400 text-white hover:opacity-75 cursor-pointer rounded-2xl py-1 px-3 text-sm">Back to list</button>
        <input type="text" id="search" placeholder="Search Note list...."
            class="border-2 hidden md:block border-emerald-400 rounded-2xl py-1 px-2 text-sm w-1/3 md:w-1/4" onkeyup="getSearch()">
    </div>


    
</x-layout>