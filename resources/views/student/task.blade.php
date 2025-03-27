<x-layout title="Task">
    <div class="bg-white items-center rounded-xl flex justify-between p-3 mt-3 mb-3 shadow-md hover:shadow-lg transition-all duration-300">
        <button id="openModalBtn" class="bg-emerald-400 text-white text-sm px-2 py-1 rounded-xl hover:bg-emerald-500 transition-all">Add Notes</button>
        <form id="searchForm" class="">
            <input type="text" id="searchInput" name="search" class="px-2 placeholder:text-sm py-1 bg-emerald-200 rounded-xl" placeholder="Search....">
        </form>
    </div>
    <section class="flex flex-col md:flex-row space-y-6 justify-between pb-10 md:space-x-3">

        {{-- TASK --}}
        <div class="bg-emerald-500 h-fit md:w-4/12 p-3 rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
            <h3 class="text-md text-white mb-3">Task</h3>
            {{-- FOREACH DISINI --}}
            <div class="bg-white mb-3 p-3 rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                <div class="flex justify-between items-center">
                    <h3 class="text-md font-semibold">Tugas MTK</h3>
                    <button class="bg-emerald-400 rounded-xl text-xs py-1 px-3">dropdown</button>
                </div>
                <p class="text-sm mb-3 text-emerald-500 opacity-70">Monday, 23 January 2024</p>
                <p class="text-xs ">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa quia deleniti unde laudantium? Corporis cupiditate officia reprehenderit qui sed inventore sunt, nulla pariatur consectetur aut? Voluptates perferendis ullam blanditiis doloribus?</p>
                <button class="bg-emerald-500 mt-2 text-white rounded-2xl text-xs py-1 px-3 m">Set to progress</button>
            </div>
            <div class="bg-white mb-3 p-3 rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                <div class="flex justify-between items-center">
                    <h3 class="text-md font-semibold">Tugas MTK</h3>
                    <button class="bg-emerald-400 rounded-xl text-xs py-1 px-3">dropdown</button>
                </div>
                <p class="text-sm mb-3 text-emerald-500 opacity-70">Monday, 23 January 2024</p>
                <p class="text-xs ">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa quia deleniti unde laudantium? Corporis cupiditate officia reprehenderit qui sed inventore sunt, nulla pariatur consectetur aut? Voluptates perferendis ullam blanditiis doloribus?</p>
                <button class="bg-emerald-500 mt-2 text-white rounded-2xl text-xs py-1 px-3 m">Set to progress</button>
            </div>
            <div class="bg-white mb-3 p-3 rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                <div class="flex justify-between items-center">
                    <h3 class="text-md font-semibold">Tugas MTK</h3>
                    <button class="bg-emerald-400 rounded-xl text-xs py-1 px-3">dropdown</button>
                </div>
                <p class="text-sm mb-3 text-emerald-500 opacity-70">Monday, 23 January 2024</p>
                <p class="text-xs ">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa quia deleniti unde laudantium? Corporis cupiditate officia reprehenderit qui sed inventore sunt, nulla pariatur consectetur aut? Voluptates perferendis ullam blanditiis doloribus?</p>
                <button class="bg-emerald-500 mt-2 text-white rounded-2xl text-xs py-1 px-3 m">Set to progress</button>
            </div>
            {{-- END FOREACH --}}
            <button class="w-full hover:bg-emerald-300 hover:text-white bg-white rounded-lg transition-all duration-500 py-1">+ Add New Task</button>
        </div>

        {{-- ON PROGRESS TASK --}}
        <div class="bg-emerald-500 md:w-4/12 h-fit p-3 rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
            <h3 class="text-md text-white mb-3">On Progress</h3>
            {{-- FOREACH --}}
            <div class="bg-white p-3 mb-3 rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                <div class="flex justify-between items-center">
                    <h3 class="text-md font-semibold">Tugas MTK</h3>
                    <button class="bg-emerald-400 rounded-xl text-xs py-1 px-3">dropdown</button>
                </div>
                <p class="text-sm mb-3 text-emerald-500 opacity-70">Monday, 23 January 2024</p>
                <p class="text-xs ">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa quia deleniti unde laudantium? Corporis cupiditate officia reprehenderit qui sed inventore sunt, nulla pariatur consectetur aut? Voluptates perferendis ullam blanditiis doloribus?</p>
                <button class="bg-emerald-500 mt-2 text-white rounded-2xl text-xs py-1 px-3 m">Set to done</button>
            </div>
            {{-- END FOREACH --}}
        </div>

        <div class="bg-emerald-500 h-fit md:w-4/12 p-3 rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
            <h3 class="text-md text-white mb-3">Complete Task</h3>
            {{-- FOREACH --}}
            <div class="bg-white mb-3 p-3 rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                <div class="flex justify-between items-center">
                    <h3 class="text-md font-semibold">Tugas MTK</h3>
                    <button class="bg-emerald-400 rounded-xl text-xs py-1 px-3">dropdown</button>
                </div>
                <p class="text-sm mb-3 text-emerald-500 opacity-70">Monday, 23 January 2024</p>
                <p class="text-xs ">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa quia deleniti unde laudantium? Corporis cupiditate officia reprehenderit qui sed inventore sunt, nulla pariatur consectetur aut? Voluptates perferendis ullam blanditiis doloribus?</p>
                <button class="bg-emerald-500 mt-2 text-white rounded-2xl text-xs py-1 px-3 m">Delete Task</button>
            </div>
            {{-- END FOREACH --}}
        </div>
    </section>
</x-layout>