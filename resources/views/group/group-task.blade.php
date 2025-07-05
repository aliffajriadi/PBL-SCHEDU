

<x-layout title="Group Task" role="{{ $role }}" :user="$user" :image="$userData->profile_pic !== null ? asset('storage/' . $userData->instance->folder_name . '/' . $userData->profile_pic) : 'image/Ryan-Gosling.jpg'">
    <x-nav-group type="search" page="tasks"></x-nav-group>

    @php
        $url = request()->url();

        $priviledge = $role === 'teacher';
    @endphp

    <!-- Konten Utama -->
    <section class="flex flex-col lg:flex-row mt-3 gap-4">
        <!-- Kolom Kiri: Daftar Tugas -->
        <div class="bg-white shadow-md rounded-2xl w-full lg:w-5/12 p-4">
            <div class="flex justify-between items-center mb-4">
                <p class="text-md font-semibold text-gray-800">Task List</p>
                @if($role === 'teacher')
                    <div class="flex gap-2">
                        
                        
                        <button onclick="openAddTaskModal()"
                            class="bg-emerald-400 {{ count($unit_datas) > 0 ? 'block' : 'hidden' }}
 text-white px-3 py-1 rounded-lg hover:bg-emerald-500 transition">
                            + Add Task
                        </button>
                        

                        <button onclick="openAddUnitModal()"
                            class="bg-blue-400 text-white px-3 py-1 rounded-lg hover:bg-blue-500 transition">
                            + Add Unit
                        </button>
                    </div>
                @endif
            </div>

            <div id="task-list" class="flex flex-col gap-3 max-h-96 overflow-auto"></div>
            <x-pagination></x-pagination>
        </div>

        <!-- Kolom Kanan: Detail Tugas -->
        <div id="task-content" class="bg-white shadow-md rounded-2xl w-full lg:w-7/12 p-4 mt-4 lg:mt-0">
            <div id="content-active" class="hidden">
                @if($role === 'teacher')
                    <!-- Form Edit Tugas untuk Guru -->
                    <form id="update-task" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <input id="content-title" type="text" name="title" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                        <input id="content-deadline" type="datetime-local" name="deadline" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                        <textarea id="content-description" name="content" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" rows="6" required></textarea>
                        
                        
                        <div class="flex gap-4">
                            <button type="button" onclick="open_update_modal(false, update_data)" class="bg-emerald-400 text-white px-4 py-2 rounded-lg hover:bg-emerald-500 transition">Update Task</button>
                            <button type="button" onclick="openDeleteModalTask()"
                                class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">Delete Task</button>
                        </div>
                    </form>
                @else
                    <!-- Tampilan untuk Murid -->
                    <h3 id="content-title" class="text-xl font-bold text-gray-800 mb-2">**title**</h3>
                    <p id="content-deadline" class="text-sm text-gray-500 mb-4">Tenggat: **tanggal**</p>
                    <p id="content-description" class="text-gray-700 mb-6">**deskriprsi**</p>
                    <div class="border-t border-gray-200 pt-4">
                        <h4 class="font-semibold text-gray-700 mb-2">Kumpulkan Tugas</h4>
                        
                        <form id="submission-form" method="POST" enctype="multipart/form-data">
                            @csrf
                            <textarea id="content-submission-description" name="description" placeholder="Deskripsi Tugas" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" rows="4" required></textarea>
                            {{-- <input type="file" name="file_submmissions[]" multiple>//// --}}
                            
                            <div id="content-file-list" class="hidden">
                                <ul id="file-list" class="list-disc pl-5 text-sm text-gray-600">
                                </ul>
                            </div>

                            <x-multiple-file></x-multiple-file>

                            <br>

                            <div id="submitted-button">
                                <button id="update-submission" type="button" class="bg-emerald-400 text-white px-4 py-2 rounded-lg hover:bg-emerald-500 transition">Update Submission</button>
                                <button id="delete-submission" type="button" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">Delete Submission</button>
                            </div>

                            <div id="not-submitted-button">
                                <button id="submit-submission" type="button" class="bg-emerald-400 text-white px-6 py-2 rounded-lg hover:bg-emerald-500 transition">Kumpul Tugas</button>
                            </div>

                        </form>
                    </div>
                @endif
            
            </div>

            <div id="default-content" class="flex items-center justify-center h-full text-gray-500">
                <p>Select Task for Review.</p>
            </div>
        
        </div>
    </section>

    <!-- Section History Task -->
    <section class="bg-white rounded-2xl shadow-md p-4 w-full mt-3">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">History Task</h3>

        @if($role === 'teacher')
            
            <span id="history-title"></span>

            <div id="submission-list" class="flex flex-col gap-3 max-h-96 overflow-auto">
                
            </div>
            
                {{-- <div class="text-gray-500 text-center">
                    <p>Belum ada pengumpulan untuk tugas ini.</p>
                </div> --}}
        @elseif($role === 'student')
            <div class="flex flex-col gap-3 max-h-96 overflow-auto">
                @foreach($submissions as $submission)
                    <div class="bg-white border border-gray-200 rounded-md p-3">
                        <p class="text-gray-800 font-medium">{{ $submission->task->title }}</p>
                        <p class="text-sm text-gray-500">Submit at: {{ $submission['updated_at'] }}</p>
                        <div class="mt-2">
                            <p class="text-sm font-medium text-gray-700">File:</p>
                            <ul class="list-disc pl-5 text-sm text-gray-600">
                                @foreach($submission->file as $file)
                                    <li>
                                        <a href="{{ $url }}/file/{{ $file->stored_name }}" target="_blank" class="text-emerald-400 hover:underline">
                                            {{ $file['original_name'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <p class="text-sm mt-2">
                            <span class="font-medium text-gray-700">Score: </span>
                            @if($submission['score'] !== null)
                                <span class="text-emerald-400">{{ $submission['score'] }}/100</span>
                                <span class="text-gray-500">(Scoring at {{ $submission['updated_at'] }})</span>
                            @else
                                <span class="text-gray-500">Waiting for Scoring</span>
                            @endif
                        </p>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-gray-500 text-center">
                <p>Select Task for Review History.</p>
            </div>
        @endif
</section>

    <!-- Modal Tambah Tugas (Hanya untuk Guru) -->
    @if($role === 'teacher')
        <div id="add-task-modal" class="hidden fixed inset-0 slide-down shadow-md bg-black/50 backdrop-blur-sm flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Add New Task</h3>
                <form id="add-form" action="task/api" method="POST">
                    @csrf
                    <input type="text" name="title" placeholder="Title Task" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                    <select name="unit_id" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                        <option value="" disabled selected>Select Unit</option>
                        @foreach($unit_datas as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                        @endforeach
                    </select>
                    <input type="datetime-local" name="deadline" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                    <textarea name="content" placeholder="Description Task" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" rows="4" required></textarea>
                    <div class="flex justify-end gap-4">
                        <button type="button" onclick="closeAddTaskModal()"
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

    <!-- Modal Tambah Unit (Hanya untuk Guru) -->
        <div id="add-unit-modal" class="hidden fixed inset-0 slide-down shadow-md bg-black/50 backdrop-blur-sm flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-2xl">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Add New Unit</h3>
                <form id="form-unit" action="{{ $url }}/unit" method="POST">
                    @csrf
                    <input type="text" name="name" placeholder="Name for unit (example : BAB 1)" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                    <div class="flex justify-end gap-4">
                        <button type="button" onclick="close_unit_modal()"
                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                            Cancel
                        </button>
                        <button type="submit"
                            class="bg-emerald-400 text-white px-4 py-2 rounded-lg hover:bg-emerald-500 transition">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div id="update-unit-modal" class="hidden fixed inset-0 slide-down shadow-md bg-black/50 backdrop-blur-sm flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-2xl">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Update Unit</h3>
                <form id="update-form-unit" action="/task/unit" method="POST">
                    @method("PATCH")
                    @csrf
                    <input id="unit-name" type="text" name="name" placeholder="Nama Unit (contoh: Unit 3)" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                    <div class="flex justify-end gap-4">
                        <button type="button" onclick="unit_update_toggle()"
                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                            Cancel
                        </button>
                        <button type="submit"
                            class="bg-emerald-400 text-white px-4 py-2 rounded-lg hover:bg-emerald-500 transition">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>


    <!-- Modal Konfirmasi Delete (Hanya untuk Guru) -->
        <div id="delete-modal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Confirmation for <span class="text-red-400">DELETE</span>Task</h3>
                <p class="text-gray-600 mb-6">Are you sure you want to delete this note? <span id="delete-task-title"></span>This action cannot be undone.</p>
                <form id="delete-task-form" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-end gap-4">
                        <button type="button" onclick="closeDeleteModalTask()"
                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                            Batal
                        </button>
                        <button type="button" onclick="delete_data()"
                            class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                            Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Konfirmasi Delete (Hanya untuk Guru) -->
        <div id="unit-delete-modal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Confirmation for <span class="text-red-400">DELETE</span>  Unit</h3>
                <p class="text-gray-600 mb-6">Are you sure you want to delete this Unit along with its tasks and answers? "<span id='delete-task-title'></span>" This action cannot be undone.</p>
                <form id="delete-unit-form" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-end gap-4">
                        <button type="button" onclick="unit_delete_toggle()"
                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                            Cancel
                        </button>
                        <button type="submit"
                            class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                            Delete
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <x-success></x-success>
    <x-update-modal></x-update-modal>
    <x-delete-modal></x-delete-modal>


    <!-- JavaScript untuk Pratinjau File, Modal Tambah, Modal Unit, dan Modal Delete -->
    <script>

        const path = window.location.pathname;
        let task_selected = -1;

        const debounce_refresh = debounce(search, 500);
        let note_picked = -1;

        function debounce_search()
        {
            current_page = 1;
            debounce_refresh();
        }

        function search()
        {
            const keyword = document.getElementById('search').value;
            get_data(`${path}/api?keyword=${keyword}&page=${current_page}`, show_task_list);   
        }

    
        document.addEventListener('DOMContentLoaded', function () {
            // Pratinjau File
            reset_list()

            const fileInput = document.getElementById('hidden-input');
            if (fileInput) {
                fileInput.addEventListener('change', function(event) {
                    const filePreview = document.getElementById('file-preview');
                    filePreview.innerHTML = ''; // Kosongkan pratinjau sebelumnya

                    const files = event.target.files;
                    for (let file of files) {
                        const fileItem = document.createElement('div');
                        fileItem.className = 'flex items-center gap-2 text-gray-700';

                        // Tentukan ikon berdasarkan tipe file
                        let icon = '';
                        if (file.type === 'application/pdf') {
                            icon = '<svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>';
                        } else if (file.type.includes('msword') || file.type.includes('wordprocessingml')) {
                            icon = '<svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>';
                        } else {
                            icon = '<svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>';
                        }

                        fileItem.innerHTML = `
                            ${icon}
                            <span class="text-sm">${file.name}</span>
                        `;
                        filePreview.appendChild(fileItem);
                    }
                });
            }

            function get_student_submission(id)
            {
                get_data();
            }

            // Fungsi Modal Tambah Tugas
            window.openAddTaskModal = function() {
                const modal = document.getElementById('add-task-modal');
                modal.classList.remove('hidden');
            };

            window.closeAddTaskModal = function() {
                const modal = document.getElementById('add-task-modal');
                modal.classList.add('hidden');
            };

            // Fungsi Modal Tambah Unit
            window.openAddUnitModal = function() {
                const modal = document.getElementById('add-unit-modal');
                const form = document.getElementById('form-unit');
                modal.classList.remove('hidden');
            };

            window.close_unit_modal = function() {
                const modal = document.getElementById('add-unit-modal');
                modal.classList.add('hidden');
            };

            // Fungsi Modal Delete
            window.openDeleteModalTask = function() {
                const modal = document.getElementById('delete-modal');
                // const titleSpan = document.getElementById('delete-task-title');
                // const form = document.getElementById('delete-task-form');
                // titleSpan.textContent = taskTitle;
                // form.action = `/tasks/delete/${taskId}`;
                modal.classList.remove('hidden');
            };

            window.closeDeleteModalTask = function() {
                const modal = document.getElementById('delete-modal');
                modal.classList.add('hidden');
            };
        });   

    function reset_list()
    {
        get_data(`${path}/api`, show_task_list);
    }

    function unit_delete_toggle(id = false)
    {
        if(id !== false){
            // document.getElementById('unit-name').value = title;

            document.getElementById('delete-unit-form').action = `${path}/unit/${id}`;
        }
        document.getElementById('unit-delete-modal').classList.toggle('hidden');
    }

    function unit_update_toggle(id = false, title = false)
    {
        document.getElementById('update-unit-modal').classList.toggle('hidden');

        if(title !== false && id !== false){
            document.getElementById('unit-name').value = title;
            document.getElementById('update-form-unit').action = `${path}/unit/${id}`;
        }

    }

    function show_task_list(units) {
        const parent = document.getElementById('task-list');
        parent.innerHTML = '';
        max_page = units.datas.last_page;

        if(units.datas.last_page <= 1) document.getElementById('pagination').classList.add('hidden'); 
        else document.getElementById('pagination').classList.remove('hidden');  

        units.datas.data.forEach(unit => {
            const wrapper = document.createElement('div');
            wrapper.className = 'bg-white border border-gray-200 rounded-md p-3';

            // Container untuk title dan button
            const header = document.createElement('div');
            header.className = 'flex justify-between items-center mb-2';

            const title = document.createElement('p');
            title.className = 'text-gray-800 font-medium';
            title.textContent = unit.name;

            header.appendChild(title);

            @if($role === 'teacher')
                const buttonGroup = document.createElement('div');
                buttonGroup.className = 'flex gap-2';

                const editBtn = document.createElement('button');
                editBtn.className = 'bg-blue-500 hover:bg-blue-600 text-white text-sm px-2 py-1 rounded';
                editBtn.textContent = 'Edit';
                // Tambahkan event listener jika perlu
                editBtn.onclick = () => {
                    // console.log('Edit:', unit.name);
                    unit_update_toggle(unit.id, unit.name)
                };

                const deleteBtn = document.createElement('button');
                deleteBtn.className = 'bg-red-500 hover:bg-red-600 text-white text-sm px-2 py-1 rounded';
                deleteBtn.textContent = 'Delete';
                // Tambahkan event listener jika perlu
                deleteBtn.onclick = () => {
                    unit_delete_toggle(unit.id);
                };

                buttonGroup.appendChild(editBtn);
                buttonGroup.appendChild(deleteBtn);

                header.appendChild(buttonGroup);
            @endif

            const container = document.createElement('div');
            container.className = 'flex flex-col gap-2';

            unit.task.forEach(data => {
                const a = document.createElement('a');
                a.className = 'tasks block border-l-4 border-emerald-400 pl-3 py-2 rounded-sm hover:bg-emerald-50';

                const p1 = document.createElement('p');
                p1.className = 'font-medium text-gray-800';
                p1.textContent = data.title;

                const p2 = document.createElement('p');
                p2.className = 'text-sm text-gray-500';
                p2.textContent = `Tenggat: ${data.deadline}`;

                a.appendChild(p1);
                a.appendChild(p2);
                container.appendChild(a);

                a.onclick = () => {
                    show_data(data.id);
                };
            });

            wrapper.appendChild(header); // gunakan header (title + button)
            wrapper.appendChild(container);
            parent.appendChild(wrapper);
        });

    }

    function insert_submission(id) 
    {
        // Buat objek FormData
        const form = document.getElementById('submission-form');
        const formData = new FormData(form);

        // Tambahkan file satu per satu
        Object.values(FILES).forEach((file) => {
            formData.append('files[]', file);
        });

        for (let [key, value] of formData.entries()) {
            console.log(`${key}: ${value}`);
        }

        api_store(`${path}/s/${id}`, formData).then((response) => {
            show_data(id);

            if(response.status) open_success(response.message);
            else open_fail(response.message);

        });
    }

    function update_submission(submission_id)
    {
        const form = document.getElementById('submission-form');

        const formData = new FormData(form);

        // Tambahkan file satu per satu
        Object.values(FILES).forEach((file) => {
            formData.append('files[]', file);
        });

        api_update(`${path}/s`, formData, submission_id, true).then((response) => {
            show_data(task_selected);
            close_update_modal();
        });
    }

    function delete_submission(id)
    {
        api_destroy(`${path}/s`, id).then((response) => {
            show_data(task_selected);
            if(response.status) open_success(response.message);
            else open_fail(response.message);

            closeDeleteModal();
        });

    }

    function content(task)
    {
        console.log('a');
        console.log(task);
        const data = task.data;
        console.log(task);
        const submission = task.submission;
        document.getElementById('default-content').classList.add('hidden');
        document.getElementById('content-active').classList.remove('hidden');

        const submission_list = document.getElementById('submission-list');

        if('{{ $role }}' == 'teacher'){
            document.getElementById('content-title').value = data.title;
            document.getElementById('content-deadline').value = data.deadline;
            document.getElementById('content-description').value = data.content;
            document.getElementById('history-title').innerHTML = data.title;
            submission.forEach(result => {
                submission_list.innerHTML += `
                 <div class="bg-white border border-gray-200 rounded-md p-3">
                            <p class="text-gray-800 font-medium">${result.user.name}</p>
                            <span>Description : </span>
                                <br>
                            <span> ${result.description} </span>
                                <br>
                            <span> Score : ${result.score ? result.score : 'Belum Dinilai'} </span>
                            

                            <p class="text-sm text-gray-500">Dikumpulkan: ${result.updated_at}</p>
                            <div class="mt-2 ${!result.file ? '': 'hidden'}">
                                <p class="text-sm font-medium text-gray-700">File:</p>
                                <ul class="list-disc pl-5 text-sm text-gray-600">
                                `;                                
                
                // console.log(file);

                result.file.forEach((file) => {
                    submission_list.innerHTML += `        
                    <li>
                        <a href="${path}/file/${file.stored_name}" target="_blank" class="text-emerald-400 hover:underline">
                            ${file.original_name}
                        </a>
                    </li>`;
                });

                submission_list.innerHTML += `
                                </ul>
                            </div>
                            <div class="mt-2">
                                <p class="text-sm font-medium text-gray-700">Nilai:</p>
                                <form class="grade-form flex gap-2 items-center">
                                    <input type="number" name="score" min="0" max="100" class="p-1 border border-gray-200 rounded-lg w-20" placeholder="0-100">
                                    <input type="hidden" value="${result.id}" name="submission_id">
                                    <button type="button" onclick="scoring(this)" class="bg-emerald-400 text-white px-3 py-1 rounded-lg hover:bg-emerald-500 transition">
                                        Simpan Nilai
                                    </button>
                                </form>
                            </div>
                        </div>`;
            });

        }else{
            document.getElementById('content-title').textContent = data.title;
            document.getElementById('content-deadline').textContent = data.deadline;
            document.getElementById('content-description').textContent = data.content;

            const file_list = document.getElementById('file-list');
            file_list.innerHTML = ''; 

            document.getElementById('content-submission-description').value = '';

            
            if(submission !== null){
                document.getElementById('submitted-button').classList.remove('hidden');
                document.getElementById('not-submitted-button').classList.add('hidden');

                document.getElementById('delete-submission').onclick = () => {
                    openDeleteModal(submission.id, delete_submission);
                };

                document.getElementById('update-submission').onclick = () => {
                    open_update_modal(submission.id, update_submission);
                };

                document.getElementById('content-submission-description').value = submission.description;

            
                console.log(task.file)

                if(task.file !== null){
                    document.getElementById('content-file-list').classList.remove('hidden');
                    const files = task.file;

                    files.forEach(file => {

                        file_list.innerHTML +=                `<li>
                                        <a href="${path}/file/${file.stored_name}" target="_blank" class="text-emerald-400 hover:underline">
                                            ${file.original_name}
                                        </a>
                                        <button type="button" onclick="delete_file('${file.stored_name}', ${data.id})"> <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg></button>
                                    </li>`
                    });
                }
            }else{
                document.getElementById('submitted-button').classList.add('hidden');
                document.getElementById('not-submitted-button').classList.remove('hidden');

                document.getElementById('submit-submission').onclick = () => {
                    insert_submission(data.id);
                }
            }
            
            document.getElementById('submission-form').action = `${path}/submit/${data.id}`
        }
    }

    function delete_file(stored_name, id)
    {
        api_destroy(`${path}/file`, stored_name).then(response => {
            show_data(id);
            if(response.status) open_success(response.message);
            else open_fail(response.message);
        });
    }

    function insert_data()
    {
        const form = document.getElementById('add-form');
        const formData = new FormData(form);

        api_store(`${path}/api`, formData).then(response => {
            if(response.status) open_success(response.message);
            else open_fail(response.message);
            reset_list();
            closeAddTaskModal();
        });
        
        
    }

    function update_data()
    {
        const form = document.getElementById('update-task');
        const formData =  new FormData(form);

        api_update(`${path}/api`, formData, task_selected).then(response => {
            if(response.status) open_success(response.message);
            else open_fail(response.message);
            reset_list();

            close_update_modal();
        });
    }

    function delete_data()
    {
        api_destroy(`${path}/api`, task_selected).then(response => {
            if(response.status) open_success(response.message);
            else open_fail(response.message);
            closeDeleteModal();
            reset_list();
            document.getElementById('default-content').classList.remove('hidden');
            document.getElementById('content-active').classList.add('hidden');
        });

    }

    function show_data(id)
    {
        task_selected = id;
        
        console.log(id);
        get_data(`${path}/api`, content, id);

        @if($role === 'student')
            document.getElementById("gallery").innerHTML = '';
            document.getElementById("hidden-input").value = '';
            FILES = {};
            empty.classList.remove("hidden");
        @endif
    }

    function scoring(button)
    {
        const form = button.closest('form');
        const formData = new FormData(form);

        api_update(`${path}/s`, formData, formData.get('submission_id')).then(response => {
            if(response.status) open_success(response.message);
            else open_fail(response.message);
        });
    }

    </script>

</x-layout>