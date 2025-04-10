<x-layout title="Task" role="teacher">
    <!-- Header Section -->
    <div
        class="bg-white flex items-center justify-between p-3 mt-3 mb-3 rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
        <button id="openModalBtn"
            class="bg-emerald-500 text-white hover:bg-emerald-600 px-4 py-2 rounded-lg text-sm transition-all duration-300">
            Add Notes
        </button>
        <input type="text" id="search" placeholder="Search Note list...."
            class="mt-2 sm:mt-0 w-full sm:w-1/3 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-300 transition-all"
            onkeyup="getSearch()">
    </div>

    <!-- Mobile-Only List (Visible only on screens < md) -->
    <div class="block md:hidden bg-white p-4 rounded-xl shadow-md mb-6">
        <h3 class="text-md font-semibold text-gray-800 mb-3">Task Overview</h3>
        <ul class="space-y-3">
            <li>
                <a href="#tasks" class="text-sm text-emerald-500 hover:underline">Tasks (3)</a>
            </li>
            <li>
                <a href="#progress" class="text-sm text-emerald-500 hover:underline">On Progress (1)</a>
            </li>
            <li>
                <a href="#complete" class="text-sm text-emerald-500 hover:underline">Completed (1)</a>
            </li>
        </ul>
    </div>

    

    <!-- Task Sections -->
    <section id="task-section" class="grid grid-cols-1 md:grid-cols-3 gap-6 pb-10">
        <!-- Task Column -->
        <div id="tasks"
            class="bg-emerald-500 p-4 h-fit rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
            <h3 class="text-md text-white font-semibold mb-4">Task</h3>
            <!-- Task Item -->
            @foreach ([1, 2, 3] as $task)
                <div class="bg-white mb-4 p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                    <div class="flex  justify-between items-center mb-2">
                        <h3 class="text-md font-semibold text-gray-800">Tugas MTK</h3>
                        <button
                            class="bg-emerald-400 rounded-xl text-xs py-1 px-3 text-white hover:bg-emerald-500 transition-all">
                            Dropdown
                        </button>
                    </div>
                    <p class="text-sm text-emerald-500 opacity-70 mb-3">Monday, 23 January 2024</p>
                    <p class="text-xs text-gray-600">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa quia deleniti unde laudantium?
                        Corporis cupiditate officia...
                    </p>
                    <button
                        class="bg-emerald-500 mt-3 text-white rounded-2xl text-xs py-1 px-4 hover:bg-emerald-600 transition-all">
                        Set to Progress
                    </button>
                </div>
            @endforeach
            <button
                class="w-full bg-white text-emerald-500 rounded-lg py-2 hover:bg-emerald-300 hover:text-white transition-all duration-500">
                + Add New Task
            </button>
        </div>

        <!-- On Progress Column -->
        <div id="progress"
            class="bg-emerald-500 p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 h-fit">
            <h3 class="text-md text-white font-semibold mb-4">On Progress</h3>
            <!-- Progress Item -->
            <div class="bg-white mb-4 p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-2">
                    <h3 class="text-md font-semibold text-gray-800">Tugas MTK</h3>
                    <button
                        class="bg-emerald-400 rounded-xl text-xs py-1 px-3 text-white mt-2 sm:mt-0 hover:bg-emerald-500 transition-all">
                        Dropdown
                    </button>
                </div>
                <p class="text-sm text-emerald-500 opacity-70 mb-3">Monday, 23 January 2024</p>
                <p class="text-xs text-gray-600">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa quia deleniti unde laudantium?
                    Corporis cupiditate officia...
                </p>
                <button
                    class="bg-emerald-500 mt-3 text-white rounded-2xl text-xs py-1 px-4 hover:bg-emerald-600 transition-all">
                    Set to Done
                </button>
            </div>
        </div>

        <!-- Complete Task Column -->
        <div id="complete"
            class="bg-emerald-500 p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 h-fit">
            <h3 class="text-md text-white font-semibold mb-4">Complete Task</h3>
            <!-- Complete Item -->
            <div class="bg-white mb-4 p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-2">
                    <h3 class="text-md font-semibold text-gray-800">Tugas MTK</h3>
                    <button
                        class="bg-emerald-400 rounded-xl text-xs py-1 px-3 text-white mt-2 sm:mt-0 hover:bg-emerald-500 transition-all">
                        Dropdown
                    </button>
                </div>
                <p class="text-sm text-emerald-500 opacity-70 mb-3">Monday, 23 January 2024</p>
                <p class="text-xs text-gray-600">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa quia deleniti unde laudantium?
                    Corporis cupiditate officia...
                </p>
                <button
                    class="bg-emerald-500 mt-3 text-white rounded-2xl text-xs py-1 px-4 hover:bg-emerald-600 transition-all">
                    Delete Task
                </button>
            </div>
        </div>
    </section>


    <script>
        function getSearch() {
            let input = document.getElementById('search').value.toLowerCase();
            let tasks = document.querySelectorAll('#task-section .bg-white');
    
            tasks.forEach(task => {
                let text = task.textContent.toLowerCase();
                if (text.includes(input)) {
                    task.classList.remove('hidden');
                } else {
                    task.classList.add('hidden');
                }
            });
        }
    </script>
    
</x-layout>
