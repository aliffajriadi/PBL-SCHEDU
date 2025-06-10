<x-layout title="Task" role="teacher" :user="$user">
    <!-- Header Section -->
    <div
        class="bg-white flex items-center justify-between p-3 mt-3 mb-3 rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
        <button id="openModalBtn"
            onclick="open_modal('add-task-modal')"

            class="bg-emerald-500 text-white hover:bg-emerald-600 px-4 py-2 rounded-lg text-sm transition-all duration-300">
            Add Task
        </button>
        <input type="text" id="search" placeholder="Search Note list...."
            class="mt-2 sm:mt-0 w-full sm:w-1/3 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-300 transition-all"
            oninput="debounce_search()">
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
            <h3 class="text-md text-white font-semibold mb-4">All Tasks</h3>
            <!-- Task Item -->
            <div id="all-tasks">

            </div>
            
            <button
            onclick="open_modal('add-task-modal')"
                class="w-full bg-white text-emerald-500 rounded-lg py-2 hover:bg-emerald-300 hover:text-white transition-all duration-500">
                + Add New Task
            </button>
        </div>

        <!-- On Progress Column -->
        <div id="progress"
            class="bg-emerald-500 p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 h-fit">
            <h3 class="text-md text-white font-semibold mb-4">On Progress</h3>
            <!-- Progress Item -->

            <div id="progress-task">

            </div>
            
        </div>

        <!-- Complete Task Column -->
        <div id="complete"
            class="bg-emerald-500 p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 h-fit">
            <h3 class="text-md text-white font-semibold mb-4">Complete Task</h3>
            <!-- Complete Item -->
            <div id="complete-task"></div>


        </div>
    </section>


        <div id="add-task-modal" class="all-modal hidden fixed inset-0 slide-down shadow-md bg-slate-50/50 backdrop-blur-sm flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Tambah Tugas Baru</h3>
                <form id="add-form" action="task/api" method="POST">
                    @csrf
                    <input type="text" name="title" placeholder="Judul Tugas" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
 
                    <input type="datetime-local" name="deadline" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                    <textarea name="content" placeholder="Deskripsi Tugas" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" rows="4" required></textarea>
                    <div class="flex justify-end gap-4">
                        <button type="button" onclick="close_modal('add-task-modal')"
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
        
        <div id="update-task-modal" class="all-modal hidden fixed inset-0 slide-down shadow-md bg-slate-50/50 backdrop-blur-sm flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Task Detail</h3>
                <form id="update-form" action="task/api" method="POST">
                    @csrf
                    <input type="text" id="update-title" name="title" placeholder="Judul Tugas" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
 
                    <input type="datetime-local" id="update-deadline" name="deadline" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                    <textarea name="content" id="update-content" placeholder="Deskripsi Tugas" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" rows="4" required></textarea>
                    <div class="flex justify-end gap-4">
                        <button type="button" onclick="close_modal('update-task-modal')"
                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                            Batal
                        </button>
                        <button type="button"
                            id="update-button"
                            onclick="update_data()"
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
        const debounce_refresh = debounce(search, 500);
        let note_picked = -1;
        const path = window.location.pathname;

        function debounce_search()
        {
            debounce_refresh();
        }

        function search()
        {
            const keyword = document.getElementById('search').value;
            get_data(`${path}/api?keyword=${keyword}`, set_list);   
        }

        search();

        function open_modal(id, button = false)
        {
            if(button !== false){

                const data = JSON.parse(button.getAttribute('data-detail'));

                document.getElementById('update-title').value = data.title;
                document.getElementById('update-content').value = data.content;
                document.getElementById('update-deadline').value = data.deadline;

                document.getElementById('update-button').onclick = () => {
                    update_data(data.id);
                }
            }


            close_all_modal();
            document.getElementById(id).classList.remove('hidden');
            console.log('berhasil');
        }

        function close_modal(id)
        {
            document.getElementById(id).classList.add('hidden');
        }

        search()

        function set_list(datas){
            console.log(datas);
            const all_list = document.getElementById('all-tasks');
            const progress_task = document.getElementById('progress-task');
            const complete_task = document.getElementById('complete-task');
            // const unfinished_list = document.getElementById('unfinished-tasks');
            // const finished_list = document.getElementById('finished-tasks');

            all_list.innerHTML = '';
            progress_task.innerHTML = '';
            complete_task.innerHTML = '';

            datas.datas.forEach(data => {

                console.log(data)
                
                all_list.innerHTML += `<div class="bg-white mb-4 p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="text-md font-semibold text-gray-800">${data.title}</h3>
                        <div class="relative">
                            <div class="relative inline-block text-left">
                            <button
                                class="dropdown-toggle bg-emerald-400 rounded-xl text-xs py-1 px-3 text-white hover:bg-emerald-500 transition-all"
                                onclick="open_dropdown('all-task-${data.id}')">
                                Options
                            </button>

                            <div
                                id="all-task-${data.id}"

                                class="all-modal hidden absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-hidden" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                                <div class="py-1" role="none">
                                <!-- Active: "bg-gray-100 text-gray-900 outline-hidden", Not Active: "text-gray-700" -->
                                <button data-detail='${JSON.stringify(data).replace(/'/g, "&apos;")}' onclick="open_modal('update-task-modal', this)" type="button" class="block w-full px-4 py-2 text-left text-sm hover:bg-gray-200" role="menuitem" tabindex="-1" id="menu-item-3">Detail</button>
                                <button type="submit" onclick="delete_data(${data.id})" class="block w-full px-4 py-2 text-left text-sm text-red-700 hover:bg-gray-200" role="menuitem" tabindex="-1" id="menu-item-3">Delete</button>
                                </div>
                            </div>
                            </div>


                        </div>
                    </div>
                    <p class="text-sm text-emerald-500 opacity-70 mb-3">${data.deadline}</p>
                    <p class="text-xs text-gray-600">
                        ${data.content}
                    </p>
                    <button onclick="set_finish(${data.id})"
                        class="bg-emerald-500 mt-3 text-white rounded-2xl text-xs py-1 px-4 hover:bg-emerald-600 transition-all">
                        Set to finish
                    </button>

                </div>`;

                if(data.is_finished === 0){
                    progress_task.innerHTML += `<div class="bg-white mb-4 p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-2">
                    <h3 class="text-md font-semibold text-gray-800">${data.title}</h3>
                                            <div class="relative">
                            <div class="relative inline-block text-left">
                            <button
                                class="dropdown-toggle bg-emerald-400 rounded-xl text-xs py-1 px-3 text-white hover:bg-emerald-500 transition-all"
                                onclick="open_dropdown('p-task-${data.id}')">
                                Options
                            </button>

                            <div
                                id="p-task-${data.id}"

                                class="all-modal hidden absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-hidden" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                                <div class="py-1" role="none">
                                <!-- Active: "bg-gray-100 text-gray-900 outline-hidden", Not Active: "text-gray-700" -->
                                <button data-detail='${JSON.stringify(data).replace(/'/g, "&apos;")}' onclick="open_modal('update-task-modal', this)" type="button" class="block w-full px-4 py-2 text-left text-sm hover:bg-gray-200" role="menuitem" tabindex="-1" id="menu-item-3">Detail</button>
                                <button type="submit" onclick="delete_data(${data.id})" class="block w-full px-4 py-2 text-left text-sm text-red-700 hover:bg-gray-200" role="menuitem" tabindex="-1" id="menu-item-3">Delete</button>
                                </div>
                            </div>
                            </div>


                        </div>

                </div>
                <p class="text-sm text-emerald-500 opacity-70 mb-3">${data.deadline}</p>
                <p class="text-xs text-gray-600">
                    ${data.content}
                </p>
                <button
                    onclick="set_finish(${data.id})"
                    class="bg-emerald-500 mt-3 text-white rounded-2xl text-xs py-1 px-4 hover:bg-emerald-600 transition-all">
                    Set to Done
                </button>
            </div>`
                }else{
                    complete_task.innerHTML += 
                    `
                    <div class="bg-white mb-4 p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-2">
                            <h3 class="text-md font-semibold text-gray-800">${data.title}</h3>
                            
                            
                        </div>
                        <p class="text-sm text-emerald-500 opacity-70 mb-3">${data.deadline}</p>
                        <p class="text-xs text-gray-600">
                            ${data.title}
                        </p>
                        <button 
                            onclick="delete_data(${data.id})"
                            class="bg-emerald-500 mt-3 text-white rounded-2xl text-xs py-1 px-4 hover:bg-emerald-600 transition-all">
                            Delete Task
                        </button>
                    </div>`;
                }

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
        // function getSearch() {
        //     let input = document.getElementById('search').value.toLowerCase();
        //     let tasks = document.querySelectorAll('#task-section .bg-white');

        //     tasks.forEach(task => {
        //         let text = task.textContent.toLowerCase();
        //         if (text.includes(input)) {
        //             task.classList.remove('hidden');
        //         } else {
        //             task.classList.add('hidden');
        //         }
        //     });
        // }

        function open_dropdown(id)
        {
            // console.log('berhasil')

            close_all_modal();
            document.getElementById(id).classList.toggle('hidden');
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
            api_update('/task/done/', taskId).then(response => {
                search();
            });
        }

        function setToInitial(taskId) {
            console.log(`Setting task ${taskId} to Initial`);
            // Add your set to initial logic here
        }

        function insert_data()
        {
            const form = document.getElementById('add-form');
            const formData = new FormData(form);

            api_store('/task/api', formData).then(response => {
                search();
            });

            close_modal('add-task-modal');
        }

        function update_data(id)
        {
            const form = document.getElementById('update-form');
            const formData = new FormData(form);

            formData.append('_method', 'PATCH');

            api_update('/task/api', formData, id).then(response => {
                search();
            });

            close_all_modal();
        }

        function delete_data(id)
        {
            api_destroy('/task/api', id).then(response => {
                search();
            });
        }

        function close_all_modal()
        {
            const all_modals = document.querySelectorAll('.all-modal');

            all_modals.forEach(el => {
                el.classList.add('hidden');
            });
        }

        function set_finish(id)
        {
            console.log(id);

            const formData = new FormData();

            formData.append('is_finished', 1)

            api_update('/task/set_finished', formData, id).then(response => {
                search();
                console.log('berhasil');
            });;
        }

        function reset_finish(id)
        {
            api_update('/task/reset_finished', null, id).then(response => {
                search();
            });;
        }

    </script>
</x-layout>