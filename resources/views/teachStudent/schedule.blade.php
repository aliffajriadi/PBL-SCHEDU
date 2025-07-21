<x-layout title="Schedule" role="teacher" :user="$userData" :image="$userData->profile_pic !== null ? asset('storage/' . $userData->instance->folder_name . '/' . $userData->profile_pic) : 'image/Ryan-Gosling.jpg'">
    <!-- Header Section -->
    <div class="bg-white mb-3 p-3 shadow-md rounded-2xl">
        <div class="flex flex-col-reverse md:flex-row md:items-center md:justify-between gap-2">
            <input 
                type="text" 
                id="search" 
                placeholder="Search schedule list..." 
                class="w-full md:w-1/3 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-300 transition-all"
                oninput="debounce_search()"
            >
            <button 
                onclick="open_add_modal()"
                class="bg-emerald-500 text-white hover:bg-emerald-600 px-4 py-2 rounded-lg text-sm transition-all duration-300 w-full md:w-auto"
            >
                + Add Schedule
            </button>
        </div>
    </div>
    

    <!-- Main Content -->
    <div class="flex flex-col md:flex-row gap-3 mt-3 pb-7 animate-fadeIn w-full">
        <!-- Note List Section -->
        <div class="bg-white p-3 w-full md:w-5/12 shadow-md rounded-2xl">
            <h2 class="text-lg mb-4 font-semibold text-gray-800">Schedule List</h2>
            <div id="schedule-list" class="p-3 rounded-2xl h-96 overflow-auto">
              
            </div>
            <x-pagination></x-pagination>
        </div>

        <!-- Calendar Section -->
        <div class="bg-white shadow-md rounded-2xl p-3 md:w-7/12">
            <x-calender></x-calender>
        </div>
    </div>

    <div id="add-schedule-modal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Add New Schedule</h3>
            <form id="add-form" action="/schedules/add" method="POST">
                @csrf
                <input type="text" name="title" placeholder="Title Schedule" id="add-title" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                <textarea name="content" placeholder="Description Schedule" id="add-content" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" rows="4" required></textarea>
                <input type="datetime-local" name="start_datetime" id="add-start-datetime" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required min="{{ now()->format('Y-m-d\TH:i') }}">
                <input type="datetime-local" name="end_datetime" id="add-end-datetime" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required min="{{ now()->format('Y-m-d\TH:i') }}">
                <div class="flex justify-end gap-4">
                    <button type="button" onclick="close_add_modal()"
                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                        Cancel
                    </button>
                    <button type="button"
                        onclick="insert_data()"
                        class="bg-emerald-400 text-white px-4 py-2 rounded-lg hover:bg-emerald-500 transition">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="update-schedule-modal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Update Schedule</h3>
            <form id="update-form" action="/schedules/add" method="POST">
                @csrf
                <input type="text" id="title-update" name="title" placeholder="Title Schedule" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                <textarea name="content" id="content-update" placeholder="Description Schedule" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" rows="4" required></textarea>
                <input type="datetime-local" id="start-update" name="start_datetime" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required min="{{ now()->format('Y-m-d\TH:i') }}">
                <input type="datetime-local" id="end-update" name="end_datetime" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required min="{{ now()->format('Y-m-d\TH:i') }}">
                <div class="flex justify-end gap-4">
                    <button type="button" onclick="close_update_modal_schedule()"
                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                        Cancel
                    </button>
                    <button type="button" id="update-button-schedule"
                        {{-- onclick="update_data()" --}}
                        class="bg-emerald-400 text-white px-4 py-2 rounded-lg hover:bg-emerald-500 transition">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <x-delete-modal></x-delete-modal>
    <x-update-modal></x-update-modal>
    <x-success></x-success>

</x-layout>

<!-- JavaScript untuk Dropdown -->
<script>
    const debounce_refresh = debounce(search, 500);
    let note_picked = -1;
    const path = window.location.pathname;

    function debounce_search()
    {
        current_page = 1;
        debounce_refresh();
    }

    function search()
    {
        const keyword = document.getElementById('search').value;
        get_data(`${path}/api?keyword=${keyword}&page=${current_page}`, show_list);   
    }

    search();

    function show_list(datas)
    {
        const schedules = datas.datas.data;

        const parent = document.getElementById('schedule-list');
        parent.innerHTML = '';

        if(datas.datas.last_page <= 1) document.getElementById('pagination').classList.add('hidden'); 
        else document.getElementById('pagination').classList.remove('hidden');  

        max_page = datas.datas.last_page;

        set_calendar(datas.calendar);

        schedules.forEach((data, index) => {
            const date = new Date(data.created_at);
            const formatted = date.toLocaleString('en-US', {
                timezone: 'Asia/Jakarta',
                day: '2-digit',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            parent.innerHTML += `
            <div class="relative mb-3 border-b-2 border-emerald-400 pb-3 hover:border-emerald-600 hover:bg-emerald-50 transition-all duration-300 notelist">
                        <div class="block w-full">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg">${data.title}</h3>
                                <p>${index + 1}</p>
                            </div>
                            <p class="text-xs opacity-60">Created at ${ formatted }</p>
                        </div>
                        <!-- Dropdown Menu -->
                        <div class="absolute right-7 top-0">
                            <button class="text-white hover:text-gray-700 bg-emerald-500 px-2 focus:outline-none" onclick="toggleDropdown(this)">
                                <span class="text-lg font-bold hover:text-2xl">⋮</span>
                            </button>
                            <div class="all-modal dropdown-menu hidden absolute right-0 mt-2 w-32 bg-white rounded-md shadow-lg z-10">
                                <button data-detail='${JSON.stringify(data).replace(/'/g, "&apos;")}' class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-emerald-100" onclick="open_update_modal_schedule(this)">
                                    Detail
                                </button>
                                <button class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-emerald-100" onclick="openDeleteModal(${data.id}, delete_data)">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
            `;
        });
    }

    function insert_data()
    {
        const form = document.getElementById('add-form');
        const formData = new FormData(form);

        api_store('/schedule/api', formData).then(response => {
            search();

            document.getElementById('add-content').value = '';
            document.getElementById('add-title').value = '';
            document.getElementById('add-start-datetime').value = '';
            document.getElementById('add-end-datetime').value = '';

            if(response.status) open_success(response.message);
            else open_fail(response.message);

        });

        close_add_modal();
    }

    function delete_data(id)
    {
        api_destroy('/schedule/api', id).then(response => {
            search();
            if(response.status) open_success(response.message);
            else open_fail(response.message);
            closeDeleteModal()
        });
    }

    function update_data(id)
    {
        const form = document.getElementById('update-form');
        const formData = new FormData(form);

        api_update('/schedule/api', formData, id).then(response => {
            search();
            if(response.status) open_success(response.message);
            else open_fail(response.message);

            close_update_modal_schedule();
            close_update_modal();
        });
    }

    function open_add_modal()
    {
        const modal = document.getElementById('add-schedule-modal');
        modal.classList.remove('hidden')
    }

    function close_add_modal()
    {
        const modal = document.getElementById('add-schedule-modal');
        modal.classList.add('hidden')
    }

    function open_update_modal_schedule(el)
    {
        const schedule = JSON.parse(el.getAttribute('data-detail'));

        const modal = document.getElementById('update-schedule-modal');
        modal.classList.remove('hidden');
        document.getElementById('title-update').value = schedule.title;
        document.getElementById('content-update').value = schedule.content;
        document.getElementById('start-update').value = schedule.start_datetime;
        document.getElementById('end-update').value = schedule.end_datetime;

        document.getElementById('update-button-schedule').onclick = () => {
            open_update_modal(schedule.id, update_data)
            close_update_modal_schedule();
            
        };
        
    }

    function close_update_modal_schedule()
    {
        const modal = document.getElementById('update-schedule-modal');
        modal.classList.add('hidden');
    }

    function toggleDropdown(button) {
        const dropdown = button.nextElementSibling;
        dropdown.classList.toggle('hidden');
    }

    // Menutup dropdown ketika klik di luar
    document.addEventListener('click', function(event) {
        const dropdowns = document.getElementsByClassName('dropdown-menu');
        for (let i = 0; i < dropdowns.length; i++) {
            const dropdown = dropdowns[i];
            if (!dropdown.previousElementSibling.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        }
    });



</script>

<style>
    .dropdown-menu {
        min-width: 8rem;
    }
</style>