<x-layout title="Schedule" role="teacher" :user="$user">
    <!-- Header Section -->
    <div class="bg-white mb-3 flex flex-row-reverse md:flex-row justify-between items-center p-3 shadow-md rounded-2xl">
        <button 
            onclick="open_add_modal()"
            class="bg-emerald-500 text-white hover:bg-emerald-600 px-4 py-2 rounded-lg text-sm transition-all duration-300"
        >
            + Add schedule
        </button>
        <input 
            type="text" 
            id="search" 
            placeholder="Search Note list..." 
            class="mt-2 sm:mt-0 w-full sm:w-1/3 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-300 transition-all"
            oninput="debounce_search()"
        >
    </div>

    <!-- Main Content -->
    <div class="flex flex-col md:flex-row gap-3 mt-3 pb-7 animate-fadeIn w-full">
        <!-- Note List Section -->
        <div class="bg-white p-3 w-full md:w-5/12 shadow-md rounded-2xl">
            <h2 class="text-lg mb-4 font-semibold text-gray-800">Scheudle List</h2>
            <div id="schedule-list" class="p-3 rounded-2xl h-96 overflow-auto">
                @php
                    $notes = [
                        ['title' => 'Nasi Padang', 'created_at' => '87 minutes ago'],
                        ['title' => 'Nasi Goreng', 'created_at' => '2 hours ago'],
                        ['title' => 'Sate Ayam', 'created_at' => '1 day ago'],
                        ['title' => 'Rendang Daging', 'created_at' => '3 days ago'],
                        ['title' => 'Gado-Gado', 'created_at' => '5 days ago'],
                        ['title' => 'Nasi Padang', 'created_at' => '87 minutes ago'],
                        ['title' => 'Nasi Goreng', 'created_at' => '2 hours ago'],
                        ['title' => 'Sate Ayam', 'created_at' => '1 day ago'],
                        ['title' => 'Rendang Daging', 'created_at' => '3 days ago'],
                        ['title' => 'Gado-Gado', 'created_at' => '5 days ago'],
                    ];
                @endphp


            </div>
            <x-pagination></x-pagination>
        </div>

        <!-- Calendar Section -->
        <div class="bg-white shadow-md rounded-2xl p-3 md:w-7/12">
            <x-calender></x-calender>
        </div>
    </div>

    <div id="add-schedule-modal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Tambah Jadwal Baru</h3>
            <form id="add-form" action="/schedules/add" method="POST">
                @csrf
                <input type="text" name="title" placeholder="Judul Jadwal" id="add-title" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                <textarea name="content" placeholder="Deskripsi Jadwal" id="add-content" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" rows="4" required></textarea>
                <input type="datetime-local" name="start_datetime" id="add-start-datetime" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                <input type="datetime-local" name="end_datetime" id="add-end-datetime" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
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

    <div id="update-schedule-modal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Tambah Jadwal Baru</h3>
            <form id="update-form" action="/schedules/add" method="POST">
                @csrf
                <input type="text" id="title-update" name="title" placeholder="Judul Jadwal" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                <textarea name="content" id="content-update" placeholder="Deskripsi Jadwal" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" rows="4" required></textarea>
                <input type="datetime-local" id="start-update" name="start_datetime" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                <input type="datetime-local" id="end-update" name="end_datetime" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                <div class="flex justify-end gap-4">
                    <button type="button" onclick="close_update_modal()"
                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                        Batal
                    </button>
                    <button type="button" id="update-button"
                        {{-- onclick="update_data()" --}}
                        class="bg-emerald-400 text-white px-4 py-2 rounded-lg hover:bg-emerald-500 transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

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

        max_page = datas.datas.last_page;

        set_calendar(datas.calendar);

        schedules.forEach((data, index) => {
            parent.innerHTML += `
            <div class="relative mb-3 border-b-2 border-emerald-400 pb-3 hover:border-emerald-600 hover:bg-emerald-50 transition-all duration-300 notelist">
                        <div class="block w-full">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg">${data.title}</h3>
                                <p>${index + 1}</p>
                            </div>
                            <p class="text-xs opacity-60">Created at ${ data.created_at }</p>
                        </div>
                        <!-- Dropdown Menu -->
                        <div class="absolute right-7 top-0">
                            <button class="text-white hover:text-gray-700 bg-emerald-500 px-2 focus:outline-none" onclick="toggleDropdown(this)">
                                <span class="text-lg font-bold hover:text-2xl">⋮</span>
                            </button>
                            <div class="all-modal dropdown-menu hidden absolute right-0 mt-2 w-32 bg-white rounded-md shadow-lg z-10">
                                <button data-detail='${JSON.stringify(data).replace(/'/g, "&apos;")}' class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-emerald-100" onclick="open_update_modal(this)">
                                    Detail
                                </button>
                                <button class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-emerald-100" onclick="delete_data(${data.id})">
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
        api_destroy('schedule/api', id).then(response => {
            search();
            if(response.status) open_success(response.message);
            else open_fail(response.message);
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

    function open_update_modal(el)
    {
        const schedule = JSON.parse(el.getAttribute('data-detail'));
        console.log(schedule)

        const modal = document.getElementById('update-schedule-modal');
        modal.classList.remove('hidden');
        document.getElementById('title-update').value = schedule.title;
        document.getElementById('content-update').value = schedule.content;
        document.getElementById('start-update').value = schedule.start_datetime;
        document.getElementById('end-update').value = schedule.end_datetime;

        document.getElementById('update-button').onclick = () => update_data(schedule.id);
    }

    function close_update_modal()
    {
        const modal = document.getElementById('update-schedule-modal');
        modal.classList.add('hidden')
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