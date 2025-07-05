<x-layout title="Task" role="teacher" :user="$userData" :image="$userData->profile_pic !== null ? asset('storage/' . $userData->instance->folder_name . '/' . $userData->profile_pic) : 'image/Ryan-Gosling.jpg'">
    <!-- Header Section (unchanged as requested) -->
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

    <!-- Mobile-Only List (unchanged as requested) -->
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

    <!-- Enhanced Task Sections -->
    <section id="task-section" class="grid grid-cols-1 md:grid-cols-3 gap-8 pb-10">
        <!-- All Tasks Column - Enhanced -->
        <div id="tasks"
            class="bg-gradient-to-br from-emerald-500 to-emerald-600 p-6 h-fit rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg text-white font-bold flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                    </svg>
                    All Tasks
                </h3>
                <div class="bg-white/20 backdrop-blur-sm rounded-full px-3 py-1">
                    <span class="text-white text-sm font-medium" id="all-tasks-count">0</span>
                </div>
            </div>
            
            <div id="all-tasks" class="space-y-4 overflow-y-auto max-h-96 pr-2 custom-scrollbar">
                <!-- Tasks will be populated here -->
            </div>
            
            <button
                onclick="open_modal('add-task-modal')"
                class="w-full bg-white/10 backdrop-blur-sm border-2 border-white/30 text-white rounded-xl py-3 hover:bg-white hover:text-emerald-600 mt-6 transition-all duration-300 flex items-center justify-center group">
                <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add New Task
            </button>
        </div>

        <!-- On Progress Column - Enhanced -->
        <div id="progress"
            class="bg-gradient-to-br from-amber-500 to-orange-500 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 h-fit">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg text-white font-bold flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                    In Progress
                </h3>
                <div class="bg-white/20 backdrop-blur-sm rounded-full px-3 py-1">
                    <span class="text-white text-sm font-medium" id="progress-tasks-count">0</span>
                </div>
            </div>

            <div id="progress-task" class="space-y-4 overflow-y-auto max-h-96 pr-2 custom-scrollbar">
                <!-- Progress tasks will be populated here -->
            </div>
        </div>

        <!-- Complete Task Column - Enhanced -->
        <div id="complete"
            class="bg-gradient-to-br from-blue-500 to-indigo-600 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 h-fit">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg text-white font-bold flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Completed
                </h3>
                <div class="bg-white/20 backdrop-blur-sm rounded-full px-3 py-1">
                    <span class="text-white text-sm font-medium" id="complete-tasks-count">0</span>
                </div>
            </div>

            <div id="complete-task" class="space-y-4 overflow-y-auto max-h-96 pr-2 custom-scrollbar">
                <!-- Complete tasks will be populated here -->
            </div>
        </div>
    </section>

        
    <x-success></x-success>
    <x-delete-modal></x-delete-modal>
    <x-update-modal></x-update-modal>

    <!-- Enhanced Modals -->
    <div id="add-task-modal" class="all-modal hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl p-8 w-full max-w-md transform transition-all duration-300 scale-95 opacity-0 modal-content">
            <div class="flex items-center mb-6">
                <div class="bg-emerald-100 p-3 rounded-full mr-4">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800">Add New Task</h3>
            </div>
            
            <form id="add-form" action="task/api" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Task Title</label>
                    <input type="text" name="title" placeholder="Enter task title" 
                        class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deadline</label>
                    <input type="datetime-local" name="deadline" 
                        class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="content" placeholder="Enter task description" rows="4"
                        class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all resize-none" required></textarea>
                </div>
                
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="close_modal('add-task-modal')"
                        class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-xl hover:bg-gray-200 transition-all font-medium">
                        Cancel
                    </button>
                    <button type="button" onclick="insert_data()"
                        class="flex-1 bg-emerald-500 text-white px-6 py-3 rounded-xl hover:bg-emerald-600 transition-all font-medium">
                        Create Task
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <div id="update-task-modal" class="all-modal hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl p-8 w-full max-w-md transform transition-all duration-300 scale-95 opacity-0 modal-content">
            <div class="flex items-center mb-6">
                <div class="bg-blue-100 p-3 rounded-full mr-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800">Task Details</h3>
            </div>
            
            <form id="update-form" action="task/api" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Task Title</label>
                    <input type="text" id="update-title" name="title" placeholder="Enter task title" 
                        class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deadline</label>
                    <input type="datetime-local" id="update-deadline" name="deadline" 
                        class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="content" id="update-content" placeholder="Enter task description" rows="4"
                        class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none" required></textarea>
                </div>
                
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="close_modal('update-task-modal')"
                        class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-xl hover:bg-gray-200 transition-all font-medium">
                        Cancel
                    </button>
                    <button type="button" id="update-button-task" 
                        class="flex-1 bg-blue-500 text-white px-6 py-3 rounded-xl hover:bg-blue-600 transition-all font-medium">
                        Update Task
                    </button>
                </div>
            </form>
        </div>
    </div>


    <style>
        /* Enhanced Dropdown Animation */
        .dropdown-menu {
            transform: translateY(-10px);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .dropdown-menu.show {
            transform: translateY(0);
            opacity: 1;
        }

        .dropdown-menu {
            z-index: 20;
        }

        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        /* Modal Animation */
        .all-modal:not(.hidden) .modal-content {
            animation: modalSlideIn 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        @keyframes modalSlideIn {
            from {
                transform: scale(0.95);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Task Card Animations */
        .task-card {
            animation: slideInUp 0.3s ease-out;
        }

        @keyframes slideInUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Priority Indicators */
        .priority-high {
            border-left: 4px solid #ef4444;
        }

        .priority-medium {
            border-left: 4px solid #f59e0b;
        }

        .priority-low {
            border-left: 4px solid #10b981;
        }
    </style>

    <script>
        const debounce_refresh = debounce(search, 500);
        let note_picked = -1;
        const path = window.location.pathname;

        function debounce_search() {
            debounce_refresh();
        }

        function search() {
            const keyword = document.getElementById('search').value;
            get_data(`${path}/api?keyword=${keyword}`, set_list);   
        }

        search();

        function open_modal(id, button = false) {
            if(button !== false) {
                const data = JSON.parse(button.getAttribute('data-detail'));
                document.getElementById('update-title').value = data.title;
                document.getElementById('update-content').value = data.content;
                document.getElementById('update-deadline').value = data.deadline;
                document.getElementById('update-button-task').onclick = () => {
                    open_update_modal(data.id, update_data);
                    document.getElementById('update-task-modal').classList.add('hidden');
                };
                console.log(data.id)
            }

            close_all_modal();
            document.getElementById(id).classList.remove('hidden');
            
            // Trigger animation
            setTimeout(() => {
                const modalContent = document.querySelector(`#${id} .modal-content`);
                if (modalContent) {
                    modalContent.style.transform = 'scale(1)';
                    modalContent.style.opacity = '1';
                    modalContent.ad
                }
            }, 10);
        }

        function close_modal(id) {
            const modal = document.getElementById(id);
            const modalContent = modal.querySelector('.modal-content');
            
            if (modalContent) {
                modalContent.style.transform = 'scale(0.95)';
                modalContent.style.opacity = '0';
            }
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        }

        function set_list(datas) {
            const all_list = document.getElementById('all-tasks');
            const progress_task = document.getElementById('progress-task');
            const complete_task = document.getElementById('complete-task');
            
            // Update counters
            document.getElementById('all-tasks-count').textContent = datas.datas.length;
            document.getElementById('progress-tasks-count').textContent = datas.datas.filter(d => d.is_finished === 0).length;
            document.getElementById('complete-tasks-count').textContent = datas.datas.filter(d => d.is_finished === 1).length;

            all_list.innerHTML = '';
            progress_task.innerHTML = '';
            complete_task.innerHTML = '';

            datas.datas.forEach((data, index) => {
                const taskCard = createTaskCard(data, 'all', index);
                all_list.innerHTML += taskCard;

                if(data.is_finished === 0) {
                    const progressCard = createTaskCard(data, 'progress', index);
                    progress_task.innerHTML += progressCard;
                } else {
                    const completeCard = createTaskCard(data, 'complete', index);
                    complete_task.innerHTML += completeCard;
                }
            });
        }

        function createTaskCard(data, type, index) {
            const isComplete = data.is_finished === 1;
            const cardClass = `task-card bg-white/95 backdrop-blur-sm mb-4 p-5 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 border-l-4 ${getPriorityClass()}`;
            
            const actionButton = isComplete 
                ? `<button onclick="openDeleteModal(${data.id}, delete_data)" class="bg-red-500 hover:bg-red-600 text-white rounded-lg text-xs py-2 px-4 transition-all duration-300 flex items-center">
                     <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"></path>
                     </svg>
                     Delete
                   </button>`
                : `<button onclick="set_finish(${data.id})" class="bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-xs py-2 px-4 transition-all duration-300 flex items-center">
                     <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                     </svg>
                     ${type === 'progress' ? 'Mark Done' : 'Start Task'}
                   </button>`;

            return `
                <div class="${cardClass}" style="animation-delay: ${index * 0.1}s">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="text-base font-bold text-gray-800 leading-tight">${data.title}</h3>
                        ${!isComplete ? `
                        <div class="relative">
                            <button class="dropdown-toggle bg-gray-100 hover:bg-gray-200 rounded-lg text-xs py-2 px-3 text-gray-600 transition-all duration-300"
                                onclick="open_dropdown('${type}-task-${data.id}')">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                </svg>
                            </button>
                            <div id="${type}-task-${data.id}" class="all-modal hidden absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-xl bg-white shadow-lg ring-1 ring-black/5 overflow-hidden">
                                <div class="py-1">
                                    <button data-detail='${JSON.stringify(data).replace(/'/g, "&apos;")}' onclick="open_modal('update-task-modal', this)" 
                                        class="block w-full px-4 py-3 text-left text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View Details
                                    </button>
                                    <button onclick="openDeleteModal(${data.id}, delete_data)" 
                                        class="block w-full px-4 py-3 text-left text-sm text-red-600 hover:bg-red-50 transition-colors">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Delete Task
                                    </button>
                                </div>
                            </div>
                        </div>
                        ` : ''}
                    </div>
                    
                    <div class="flex items-center text-sm text-gray-500 mb-3">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        ${formatDate(data.deadline)}
                    </div>
                    
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">${data.content}</p>
                    
                    <div class="flex justify-between items-center">
                        ${actionButton}
                        ${isComplete ? '<span class="text-xs text-green-600 font-medium flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>Completed</span>' : ''}
                    </div>
                </div>
            `;
        }

        function getPriorityClass() {
            const priorities = ['priority-high', 'priority-medium', 'priority-low'];
            return priorities[Math.floor(Math.random() * priorities.length)];
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { 
                month: 'short', 
                day: 'numeric', 
                hour: '2-digit', 
                minute: '2-digit' 
            });
        }

        // Rest of your existing JavaScript functions remain the same
        function open_dropdown(id) {
            close_all_modal();
            document.getElementById(id).classList.toggle('hidden');
        }

        function insert_data() {
            const form = document.getElementById('add-form');
            const formData = new FormData(form);

            api_store('/task/api', formData).then(response => {
                search();
                close_modal('add-task-modal');
                if(response.status) open_success(response.message);
                else open_fail(response.message);
            });
        }

        function update_data(id) {
            const form = document.getElementById('update-form');
            const formData = new FormData(form);
            formData.append('_method', 'PATCH');

            api_update('/task/api', formData, id).then(response => {
                search();
                if(response.status) open_success(response.message);
                else open_fail(response.message);

                close_update_modal()

            });

            close_all_modal();
        }

        function delete_data(id) {
            api_destroy('/task/api', id).then(response => {
                search();
                if(response.status) open_success(response.message);
                else open_fail(response.message);
                closeDeleteModal();
            });
        }

        function close_all_modal() {
            const all_modals = document.querySelectorAll('.all-modal');
            all_modals.forEach(el => {
                el.classList.add('hidden');
            });
        }

        function set_finish(id) {
            const formData = new FormData();
            formData.append('is_finished', 1);

            api_update('/task/set_finished', formData, id).then(response => {
                search();
            });
        }

        function reset_finish(id) {
            api_update('/task/reset_finished', null, id).then(response => {
                search();
            });
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
    </script>
</x-layout>