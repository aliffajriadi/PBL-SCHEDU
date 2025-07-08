
<x-layout title="Group Schedule" role="{{ $role }}" :user="$user" :image="$userData->profile_pic !== null ? asset('storage/' . $userData->instance->folder_name . '/' . $userData->profile_pic) : 'image/Ryan-Gosling.jpg'">
    <x-nav-group type="search" page="schedule"></x-nav-group>

    <!-- Konten Utama -->
    <section class="flex flex-col lg:flex-row mt-3 gap-4">
        <!-- Kolom Kiri: Daftar Jadwal -->
        <div class="bg-white shadow-md rounded-2xl w-full lg:w-5/12 p-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Schedule List</h2>
                @if($role === 'teacher')
                    <button onclick="openAddScheduleModal()"
                        class="bg-emerald-400 text-white px-3 py-1 rounded-lg hover:bg-emerald-500 transition">
                        + Add Schedule
                    </button>
                @endif
            </div>
            <div id="schedule-list" class="flex flex-col gap-3 max-h-96 overflow-auto">
             
            </div>
            <x-pagination></x-pagination>
        </div>

        <!-- Kolom Kanan: Kosong -->
        <div class="bg-white shadow-md rounded-2xl w-full lg:w-7/12 p-4">
            <x-calender></x-calender>
        </div>
    </section>

    <!-- Modal Tambah Jadwal (Hanya untuk Guru) -->
    @if($role === 'teacher')
        <div id="add-schedule-modal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-full max-w-md slide-down">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Tambah Jadwal Baru</h3>
                <form id="add-form" action="/schedules/add" method="POST">
                    @csrf
                    <input type="text" name="title" placeholder="Judul Jadwal" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                    <textarea name="content" placeholder="Deskripsi Jadwal" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" rows="4" required></textarea>
                    <input type="datetime-local" name="start_datetime" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                    <input type="datetime-local" name="end_datetime" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                    <div class="flex justify-end gap-4">
                        <button type="button" onclick="closeAddScheduleModal()"
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
    @endif

    <!-- Modal Edit Jadwal (Hanya untuk Guru) -->
    @if($role === 'teacher')
        <div id="edit-schedule-modal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Edit Jadwal</h3>
                <form id="edit-schedule-form" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="text" name="title" id="edit-title" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                    <textarea name="content" id="edit-body" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" rows="4" required></textarea>
                    <input type="datetime-local" name="start_datetime" id="edit-start" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                    <input type="datetime-local" name="end_datetime" id="edit-end" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                    <div class="flex justify-end gap-4">
                        <button type="button" onclick="closeEditScheduleModal()"
                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                            Batal
                        </button>
                        <button type="button"
                            onclick="open_update_modal(false, update_data); closeEditScheduleModal();"
                            class="bg-emerald-400 text-white px-4 py-2 rounded-lg hover:bg-emerald-500 transition">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Modal Konfirmasi Delete (Hanya untuk Guru) -->
    @if($role === 'teacher')
        <div id="delete-modal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Hapus Jadwal</h3>
                <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus jadwal "<span id="delete-schedule-title"></span>"? Tindakan ini tidak dapat dibatalkan.</p>
                <form id="delete-schedule-form" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-end gap-4">
                        <button type="button" onclick="closeDeleteModal()"
                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                            Batal
                        </button>
                        <button type="button"
                            onclick="delete_data()"
                            class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                            Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <x-success></x-success>
    <x-update-modal></x-update-modal>

    <!-- JavaScript untuk Modal -->
    <script>


        const path = window.location.pathname;
        let schedule_selected = -1;
        const debounce_refresh = debounce(search, 500);

        function debounce_search()
        {
            current_page = 1;
            debounce_refresh();
        }

        function search()
        {
            const keyword = document.getElementById('search').value;
            get_data(`${path}/api?keyword=${keyword}&page=${current_page}`, schedule_list);   
        }

        search();

        function insert_data()
        {
            const form = document.getElementById('add-form');
            const formData = new FormData(form);
            api_store(`${path}/api`, formData).then(response => {
                search();
                if(response.status) open_success(response.message);
                else open_fail(response.message);
                
            });
        
            closeAddScheduleModal();
        }

        function schedule_list(datas)
        {
            const schedules = datas.datas;
            max_page = datas.datas.last_page;
            set_calendar(datas.calendar);

            if(datas.datas.last_page <= 1) document.getElementById('pagination').classList.add('hidden'); 
            else document.getElementById('pagination').classList.remove('hidden');  

            const parent = document.getElementById('schedule-list');
            parent.innerHTML = '';

            schedules.data.forEach(schedule => {
                parent.innerHTML += `
                <div class="block border-l-4 border-emerald-400 pl-3 py-2 rounded-sm hover:bg-emerald-50 transition-all duration-300">
                        <div class="flex justify-between items-center">
                            <h3 class="font-medium text-gray-800">${schedule['title']}</h3>
                            @if($role === 'teacher')
                                <div class="flex gap-2">
                                    <button onclick="openEditScheduleModal(${schedule['id']}, '${schedule['title']}', '${schedule['content']}', '${schedule['start_datetime']}', '${schedule['end_datetime']}')"
                                        class="text-blue-500 hover:text-blue-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <button onclick="openDeleteModal(${schedule['id']}, '${schedule['title']}')"
                                        class="text-red-500 hover:text-red-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <p class="text-sm text-gray-700">${schedule['content']}</p>
                        <p class="text-sm text-gray-500">Mulai: ${schedule['start_datetime']}</p>
                        <p class="text-sm text-gray-500">Selesai: ${schedule['end_datetime']}</p>
                    </div>`
            });
        }


        function update_data()
        {
            const form = document.getElementById('edit-schedule-form');
            const formData = new FormData(form);

            api_update(`${path}/api`, formData, schedule_selected).then(response => {
                search();
                if(response.status) open_success(response.message);
                else open_fail(response.message);
                
                close_update_modal();
            });
        
        }

        function delete_data()
        {
            api_destroy(`${path}/api`, schedule_selected).then(response => {
                search();
                if(response.status) open_success(response.message);
                else open_fail(response.message);
                
            });
            closeDeleteModal();
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Fungsi Modal Tambah Jadwal
            window.openAddScheduleModal = function() {
                const modal = document.getElementById('add-schedule-modal');
                modal.classList.remove('hidden');
            };

            window.closeAddScheduleModal = function() {
                const modal = document.getElementById('add-schedule-modal');
                modal.classList.add('hidden');
            };

            // Fungsi Modal Edit Jadwal
            window.openEditScheduleModal = function(id, title, body, start, end) {
                schedule_selected = id;
                console.log(schedule_selected);
                const modal = document.getElementById('edit-schedule-modal');
                const form = document.getElementById('edit-schedule-form');
                document.getElementById('edit-title').value = title;
                document.getElementById('edit-body').value = body;
                document.getElementById('edit-start').value = start.replace(' ', 'T');
                document.getElementById('edit-end').value = end.replace(' ', 'T');
                // form.action = `/schedules/update/${id}`;
                modal.classList.remove('hidden');
            };

            window.closeEditScheduleModal = function() {

                const modal = document.getElementById('edit-schedule-modal');
                modal.classList.add('hidden');
            };

            // Fungsi Modal Delete
            window.openDeleteModal = function(id, title) {
                schedule_selected = id;

                const modal = document.getElementById('delete-modal');
                const titleSpan = document.getElementById('delete-schedule-title');
                const form = document.getElementById('delete-schedule-form');
                titleSpan.textContent = title;
                form.action = `/schedules/delete/${id}`;
                modal.classList.remove('hidden');
            };

            window.closeDeleteModal = function() {
                const modal = document.getElementById('delete-modal');
                modal.classList.add('hidden');
            };
        });

    </script>
</x-layout>