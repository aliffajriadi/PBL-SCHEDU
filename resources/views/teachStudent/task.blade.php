<x-layout title="Task" role="teacher" :user="$user">
    <!-- Header Section -->
    <div
        class="bg-white flex items-center justify-between p-3 mt-3 mb-3 rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
        <button id="openModalBtn"
            onclick="open_add_modal()"

            class="bg-emerald-500 text-white hover:bg-emerald-600 px-4 py-2 rounded-lg text-sm transition-all duration-300">
            Add Task
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
            <div id="all-tasks">

            </div>
            
            <button
            onclick="open_add_modal()"
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
                    <div class="relative">
                        <button
                            class="dropdown-toggle bg-emerald-400 rounded-xl text-xs py-1 px-3 text-white hover:bg-emerald-500 transition-all"
                            onclick="toggleDropdown(this)">
                            Options
                        </button>
                        <ul class="dropdown-menu hidden absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg z-10">
                            <li>
                                <button class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-emerald-100 hover:text-emerald-600 transition-all"
                                        onclick="editTask(1)">
                                    Edit
                                </button>
                            </li>
                            <li>
                                <button class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-emerald-100 hover:text-emerald-600 transition-all"
                                        onclick="deleteTask(1)">
                                    Delete
                                </button>
                            </li>
                            <li>
                                <button class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-emerald-100 hover:text-emerald-600 transition-all"
                                        onclick="setToDone(1)">
                                    Set to Done
                                </button>
                            </li>
                            <li>
                                <button class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-emerald-100 hover:text-emerald-600 transition-all"
                                        onclick="setToInitial(1)">
                                    Set to Initial
                                </button>
                            </li>
                        </ul>
                    </div>
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
                    <div class="relative">
                        <button
                            class="dropdown-toggle bg-emerald-400 rounded-xl text-xs py-1 px-3 text-white hover:bg-emerald-500 transition-all"
                            onclick="toggleDropdown(this)">
                            Options
                        </button>
                        <ul class="dropdown-menu hidden absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg z-10">
                            <li>
                                <button class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-emerald-100 hover:text-emerald-600 transition-all"
                                        onclick="editTask(1)">
                                    Edit
                                </button>
                            </li>
                            <li>
                                <button class="w-full text-left px-4 py-2 text-sm text-sm text-gray-700 hover:bg-emerald-100 hover:text-emerald-600 transition-all"
                                        onclick="deleteTask(1)">
                                    Delete
                                </button>
                            </li>
                            <li>
                                <button class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-emerald-100 hover:text-emerald-600 transition-all"
                                        onclick="setToInitial(1)">
                                    Set to Initial
                                </button>
                            </li>
                        </ul>
                    </div>
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


      <div id="add-task-modal" class="hidden fixed inset-0 slide-down shadow-md bg-slate-50/50 backdrop-blur-sm flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Tambah Tugas Baru</h3>
                <form id="add-form" action="task/api" method="POST">
                    @csrf
                    <input type="text" name="title" placeholder="Judul Tugas" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
 
                    <input type="datetime-local" name="deadline" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                    <textarea name="content" placeholder="Deskripsi Tugas" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" rows="4" required></textarea>
                    <div class="flex justify-end gap-4">
                        <button type="button" onclick="close_add_modal()"
                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                            Batal
                        </button>
                        <button type="button"
                            onclick="insert_data()"
                            class="bg-emerald-400 text-white px-4 py-2 rounded-lg hover:bg-emerald-500 transition">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    <style>
        /* Dropdown Animation */
        .dropdown-menu {
            transform: translateY(-10px);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .dropdown-menu.show {
            transform: translateY(0);
            opacity: 1;
        }

        /* Ensure dropdown is above other elements */
        .dropdown-menu {
            z-index: 20;
        }
    </style>

    <script>
        function open_add_modal()
        {
            document.getElementById('add-task-modal').classList.remove('hidden');
        }

        function close_add_modal()
        {
            document.getElementById('add-task-modal').classList.add('hidden');
        }

        function get_task()
        {
            get_data('/task/api', set_list);
        }

        get_task();

        function set_list(datas){
            console.log(datas);
            const all_list = document.getElementById('all-tasks');
            // const unfinished_list = document.getElementById('unfinished-tasks');
            // const finished_list = document.getElementById('finished-tasks');

            all_list.innerHTML = '';

            datas.datas.forEach(data => {

                all_list.innerHTML += `<div class="bg-white mb-4 p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="text-md font-semibold text-gray-800">${data.title}</h3>
                        <div class="relative">
                       <div class="relative inline-block text-left">
                        <div>
                            <button type="button" class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs ring-1 ring-gray-300 ring-inset hover:bg-gray-50" id="menu-button" aria-expanded="true" aria-haspopup="true">
                            Options
                            <svg class="-mr-1 size-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg>
                            </button>
                        </div>

                        <div 
                            class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-hidden transition ease-out duration-100 transform opacity-0 scale-95"
                            role="menu"
                            aria-orientation="vertical"
                            aria-labelledby="menu-button"
                            tabindex="-1"
                            data-entering="From: transform opacity-0 scale-95 To: transform opacity-100 scale-100"
                            data-leaving="From: transform opacity-100 scale-100 To: transform opacity-0 scale-95"
                        >
                            <div class="py-1" role="none">
                            <!-- "Active" state can use: bg-gray-100 text-gray-900 outline-hidden -->
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="menu-item-0">Account settings</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="menu-item-1">Support</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="menu-item-2">License</a>
                            <form method="POST" action="#" role="none">
                                <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-gray-700" role="menuitem" tabindex="-1" id="menu-item-3">Sign out</button>
                            </form>
                            </div>
                        </div>
                        </div>

                            <ul class="dropdown-menu hidden absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg z-10">
                                <li>
                                    <button class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-emerald-100 hover:text-emerald-600 transition-all"
                                            onclick="editTask()">
                                        Edit
                                    </button>
                                </li>
                                <li>
                                    <button class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-emerald-100 hover:text-emerald-600 transition-all"
                                            onclick="deleteTask()">
                                        Delete
                                    </button>
                                </li>
                                <li>
                                    <button class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-emerald-100 hover:text-emerald-600 transition-all"
                                            onclick="setToProgress(${data.id})">
                                        Set to Progress
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <p class="text-sm text-emerald-500 opacity-70 mb-3">${data.deadline}</p>
                    <p class="text-xs text-gray-600">
                        ${data.content}
                    </p>
                    <button
                        class="bg-emerald-500 mt-3 text-white rounded-2xl text-xs py-1 px-4 hover:bg-emerald-600 transition-all">
                        Set to Progress
                    </button>

                </div>`;
            });
        }

        // Toggle Dropdown
        function toggleDropdown(button) {
            const dropdown = button.nextElementSibling;
            const isOpen = dropdown.classList.contains('show');

            // Close all other dropdowns
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.remove('show');
            });

            // Toggle the clicked dropdown
            if (!isOpen) {
                dropdown.classList.add('show');
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdowns = document.querySelectorAll('.dropdown-menu');
            const buttons = document.querySelectorAll('.dropdown-toggle');

            if (!Array.from(buttons).some(button => button.contains(event.target))) {
                dropdowns.forEach(dropdown => {
                    dropdown.classList.remove('show');
                });
            }
        });

        // Search Functionality
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

        // Placeholder Actions for Dropdown Options
        function editTask(taskId) {
            console.log(`Editing task ${taskId}`);
            // Add your edit logic here (e.g., open a modal)
        }

        function deleteTask(taskId) {
            console.log(`Deleting task ${taskId}`);
            // Add your delete logic here (e.g., API call)
        }

        function setToProgress(taskId) {
            console.log(`Setting task ${taskId} to Progress`);
            // Add your set to progress logic here
        }

        function setToDone(taskId) {
            console.log(`Setting task ${taskId} to Done`);
            // Add your set to done logic here
        }

        function setToInitial(taskId) {
            console.log(`Setting task ${taskId} to Initial`);
            // Add your set to initial logic here
        }

        function insert_data()
        {
            const form = document.getElementById('add-form');
            const formData = new FormData(form);

            api_store('/task/api', formData);

            close_add_modal();
            get_task();
        }
    </script>
</x-layout>