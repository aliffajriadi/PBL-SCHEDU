<x-layout title="Group Task" role="{{ $role }}" :user="$user">
    <x-nav-group type="search" page="tasks"></x-nav-group>

    <!-- Konten Utama -->
    <section class="flex flex-col lg:flex-row mt-3 gap-4">
        <!-- Kolom Kiri: Daftar Tugas -->
        <div class="bg-white shadow-md rounded-2xl w-full lg:w-5/12 p-4">
            <div class="flex justify-between items-center mb-4">
                <p class="text-md font-semibold text-gray-800">Task List</p>
                @if($role === 'teacher')
                    <div class="flex gap-2">
                        <button onclick="openAddTaskModal()"
                            class="bg-emerald-400 text-white px-3 py-1 rounded-lg hover:bg-emerald-500 transition">
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
                        <textarea id="content-description" name="description" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" rows="6" required></textarea>
                        
                        
                        <div class="flex gap-4">
                            <button type="button" onclick="update_data()" class="bg-emerald-400 text-white px-4 py-2 rounded-lg hover:bg-emerald-500 transition">Update Task</button>
                            <button type="button" onclick="openDeleteModal()"
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
                        
                        <form id="submission-form" action="/group/bPXpTh/task/submit/1" method="POST" enctype="multipart/form-data" id="submission-form">
                            @csrf
                            <textarea id="content-submission-description" name="description" placeholder="Deskripsi Tugas" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" rows="4" required></textarea>
                            {{-- <input type="file" name="file_submmissions[]" multiple>//// --}}
                            
                            <div id="content-file-list" class="hidden">
                                <ul id="file-list" class="list-disc pl-5 text-sm text-gray-600">
                                </ul>
                            </div>

                            <x-multiple-file></x-multiple-file>

                            <br>

                            <button onclick="insert_data2()" type="button" class="bg-emerald-400 text-white px-6 py-2 rounded-lg hover:bg-emerald-500 transition">Kumpul Tugas</button>
                        </form>
                    </div>
                @endif
            
            </div>

            <div id="default-content" class="flex items-center justify-center h-full text-gray-500">
                <p>Pilih tugas di sebelah kiri untuk melihat detail.</p>
            </div>
        
        </div>
    </section>

    <!-- Section History Task -->
    <section class="bg-white rounded-2xl shadow-md p-4 w-full mt-3">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">History Task</h3>
        @php
            $submissions = [
                [
                    'task_id' => 1,
                    'student_name' => 'Andi Pratama',
                    'title' => 'Tugas Matematika',
                    'submitted_at' => '2025-04-14',
                    'files' => [
                        ['name' => 'jawaban_aljabar.pdf', 'path' => 'submissions/jawaban_aljabar.pdf'],
                        ['name' => 'catatan_aljabar.docx', 'path' => 'submissions/catatan_aljabar.docx']
                    ],
                    'grade' => 85,
                    'graded_at' => '2025-04-16'
                ],
                [
                    'task_id' => 2,
                    'student_name' => 'Budi Santoso',
                    'title' => 'Tugas Bahasa',
                    'submitted_at' => '2025-04-16',
                    'files' => [
                        ['name' => 'esai_lingkungan.pdf', 'path' => 'submissions/esai_lingkungan.pdf']
                    ],
                    'grade' => null,
                    'graded_at' => null
                ],
                [
                    'task_id' => 3,
                    'student_name' => 'Cindy Amelia',
                    'title' => 'Tugas IPA',
                    'submitted_at' => '2025-04-19',
                    'files' => [
                        ['name' => 'laporan_fotosintesis.pdf', 'path' => 'submissions/laporan_fotosintesis.pdf'],
                        ['name' => 'data_eksperimen.docx', 'path' => 'submissions/data_eksperimen.docx']
                    ],
                    'grade' => 90,
                    'graded_at' => '2025-04-21'
                ]
            ];
        @endphp

        @if(request()->query('task') && $role === 'teacher')
            @php
                $taskId = request()->query('task');
                $filteredSubmissions = array_filter($submissions, function($submission) use ($taskId) {
                    return $submission['task_id'] == $taskId;
                });
            @endphp
            @if(!empty($filteredSubmissions))
                <div class="flex flex-col gap-3 max-h-96 overflow-auto">
                    @foreach($filteredSubmissions as $submission)
                        <div class="bg-white border border-gray-200 rounded-md p-3">
                            <p class="text-gray-800 font-medium">{{ $submission['title'] }} - {{ $submission['student_name'] }}</p>
                            <p class="text-sm text-gray-500">Dikumpulkan: {{ $submission['submitted_at'] }}</p>
                            <div class="mt-2">
                                <p class="text-sm font-medium text-gray-700">File:</p>
                                <ul class="list-disc pl-5 text-sm text-gray-600">
                                    @foreach($submission['files'] as $file)
                                        <li>
                                            <a href="{{ asset('storage/' . $file['path']) }}" target="_blank" class="text-emerald-400 hover:underline">
                                                {{ $file['name'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="mt-2">
                                <p class="text-sm font-medium text-gray-700">Nilai:</p>
                                <form action="/grade-task/{{ $submission['task_id'] }}" method="POST" class="flex gap-2 items-center">
                                    @csrf
                                    <input type="number" name="grade" value="{{ $submission['grade'] ?? '' }}" min="0" max="100"
                                        class="p-1 border border-gray-200 rounded-lg w-20" placeholder="0-100">
                                    <input type="hidden" name="student_name" value="{{ $submission['student_name'] }}">
                                    <button type="submit" class="bg-emerald-400 text-white px-3 py-1 rounded-lg hover:bg-emerald-500 transition">
                                        Simpan Nilai
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-gray-500 text-center">
                    <p>Belum ada pengumpulan untuk tugas ini.</p>
                </div>
            @endif
        @elseif($role === 'student')
            <div class="flex flex-col gap-3 max-h-96 overflow-auto">
                @foreach($submissions as $submission)
                    <div class="bg-white border border-gray-200 rounded-md p-3">
                        <p class="text-gray-800 font-medium">{{ $submission['title'] }}</p>
                        <p class="text-sm text-gray-500">Dikumpulkan: {{ $submission['submitted_at'] }}</p>
                        <div class="mt-2">
                            <p class="text-sm font-medium text-gray-700">File:</p>
                            <ul class="list-disc pl-5 text-sm text-gray-600">
                                @foreach($submission['files'] as $file)
                                    <li>
                                        <a href="{{ asset('storage/' . $file['path']) }}" target="_blank" class="text-emerald-400 hover:underline">
                                            {{ $file['name'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <p class="text-sm mt-2">
                            <span class="font-medium text-gray-700">Nilai: </span>
                            @if($submission['grade'] !== null)
                                <span class="text-emerald-400">{{ $submission['grade'] }}/100</span>
                                <span class="text-gray-500">(Dinilai pada {{ $submission['graded_at'] }})</span>
                            @else
                                <span class="text-gray-500">Menunggu Penilaian</span>
                            @endif
                        </p>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-gray-500 text-center">
                <p>Pilih tugas untuk melihat riwayat pengumpulan.</p>
            </div>
        @endif
</section>

    <!-- Modal Tambah Tugas (Hanya untuk Guru) -->
    @if($role === 'teacher')
        <div id="add-task-modal" class="hidden fixed inset-0 slide-down shadow-md bg-slate-50/50 backdrop-blur-sm flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Tambah Tugas Baru</h3>
                <form id="add-form" action="task/api" method="POST">
                    @csrf
                    <input type="text" name="title" placeholder="Judul Tugas" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                    <select name="unit_id" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                        <option value="" disabled selected>Pilih Unit</option>
                        @foreach($unit_datas as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                        @endforeach
                    </select>
                    <input type="datetime-local" name="deadline" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                    <textarea name="content" placeholder="Deskripsi Tugas" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" rows="4" required></textarea>
                    <div class="flex justify-end gap-4">
                        <button type="button" onclick="closeAddTaskModal()"
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

    <!-- Modal Tambah Unit (Hanya untuk Guru) -->
    @if($role === 'teacher')
        <div id="add-unit-modal" class="hidden fixed inset-0 slide-down shadow-md bg-slate-50/50 backdrop-blur-sm flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Tambah Unit Baru</h3>
                <form action="task/unit" method="POST">
                    @csrf
                    <input type="text" name="name" placeholder="Nama Unit (contoh: Unit 3)" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                    <div class="flex justify-end gap-4">
                        <button type="button" onclick="closeAddUnitModal()"
                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                            Batal
                        </button>
                        <button type="submit"
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
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Hapus Tugas</h3>
                <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus tugas "<span id="delete-task-title"></span>"? Tindakan ini tidak dapat dibatalkan.</p>
                <form id="delete-task-form" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-end gap-4">
                        <button type="button" onclick="closeDeleteModal()"
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
    @endif

    <!-- JavaScript untuk Pratinjau File, Modal Tambah, Modal Unit, dan Modal Delete -->
    <script>

        const path = window.location.pathname;
        let task_selected = -1;

        const debounce_refresh = debounce(search, 500);
        let note_picked = -1;

        function debounce_search()
        {
            debounce_refresh();
        }

        // function submit()
        // {
        //     const form = new FormData('submissions');
        //     api_store(`${path}/submit/1`, );

        // }

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
                modal.classList.remove('hidden');
            };

            window.closeAddUnitModal = function() {
                const modal = document.getElementById('add-unit-modal');
                modal.classList.add('hidden');
            };

            // Fungsi Modal Delete
            window.openDeleteModal = function() {
                const modal = document.getElementById('delete-modal');
                // const titleSpan = document.getElementById('delete-task-title');
                // const form = document.getElementById('delete-task-form');
                // titleSpan.textContent = taskTitle;
                // form.action = `/tasks/delete/${taskId}`;
                modal.classList.remove('hidden');
            };

            window.closeDeleteModal = function() {
                const modal = document.getElementById('delete-modal');
                modal.classList.add('hidden');
            };
        });


        function reset_list()
        {
            get_data(`${path}/api`, show_task_list);
        }


        // function show_task_list(units)
        // {
        //     console.log(units)

        //     const parent = document.getElementById('task-list');
        //     parent.innerHTML = '';

        //     units.datas.forEach(unit => {
        //         let subparent = `
        //         <div class="bg-white border border-gray-200 rounded-md p-3">
        //             <p class="text-gray-800 font-medium mb-2">${unit.name}</p>
        //             <div class="flex flex-col gap-2">`;

        //         console.log(unit.task)

        //         unit.task.forEach(data => {
        //             subparent.innerHTML += `
        //             <a href="${data.id}" class="tasks block border-l-4 border-emerald-400 pl-3 py-2 rounded-sm hover:bg-emerald-50">
        //                 <p class="font-medium text-gray-800">${data.title}</p>
        //                 <p class="text-sm text-gray-500">Tenggat: ${data.deadline} </p>
        //             </a>`;
        //         });

        //         subparent.innerHTML += `
        //             </div>
        //         </div>`

        //         parent.innerHTML += subparent;
        //     });
        // }

        function show_task_list(units) {
            const parent = document.getElementById('task-list');
            parent.innerHTML = '';

            units.datas.forEach(unit => {
                const wrapper = document.createElement('div');
                wrapper.className = 'bg-white border border-gray-200 rounded-md p-3';

                const title = document.createElement('p');
                title.className = 'text-gray-800 font-medium mb-2';
                title.textContent = unit.name;

                const container = document.createElement('div');
                container.className = 'flex flex-col gap-2';

                unit.task.forEach(data => {
                    const a = document.createElement('a');
                    // a.href = data.id;
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
                        show_data(data.id)
                    };
                });

                wrapper.appendChild(title);
                wrapper.appendChild(container);
                parent.appendChild(wrapper);

            });
        }

        function content(task)
        {
            const data = task.data;
            const submission = task.submission;
            document.getElementById('default-content').classList.add('hidden');
            document.getElementById('content-active').classList.remove('hidden');

            if('{{ $role }}' == 'teacher'){
                document.getElementById('content-title').value = data.title;
                document.getElementById('content-deadline').value = data.deadline;
                document.getElementById('content-description').value = data.content;
            }else{
                document.getElementById('content-title').textContent = data.title;
                document.getElementById('content-deadline').textContent = data.deadline;
                document.getElementById('content-description').textContent = data.content;
                // document.getElementById('content-files').
                if(submission !== null){
                    document.getElementById('content-submission-description').value = submission.description;

                    console.log(task.file)

                    if(task.file !== null){
                        document.getElementById('content-file-list').classList.remove('hidden');
                        const file_list = document.getElementById('file-list');

                        const files = task.file;
                        files.forEach(file => {
                            console.log(file);

                            file_list.innerHTML +=                `<li>
                                            <a href="{{  }}" target="_blank" class="text-emerald-400 hover:underline">
                                                ${file.stored_name}
                                            </a>       <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                                        </li>`
                        });
                    }
                }

                console.log(submission);

   
                

                document.getElementById('submission-form').action = `${path}/submit/${data.id}`
            }
        }

        function insert_data()
        {
            const form = document.getElementById('add-form');
            const formData = new FormData(form);

            api_store(`${path}/api`, formData);

            closeAddTaskModal();
            reset_list();
            
        }

        function update_data()
        {
            const form = document.getElementById('update-task');
            const formData =  new FormData(form);

            api_update(`${path}/api`, formData, task_selected);
            reset_list();
        }

        function delete_data()
        {
            api_destroy(`${path}/api`, task_selected);

            closeDeleteModal();
            reset_list();
        }

        function show_data(id)
        {
            task_selected = id;
            get_data(`${path}/api`, content, id);
        }

    </script>



    <script>
    function handleDrop(event) {
        event.preventDefault();
        const dt = event.dataTransfer;
        const files = dt.files;
        document.getElementById('drop-area').classList.remove('bg-green-100', 'border-green-400');
        handleFiles(files);
    }

    function handleFiles(files) {
        const preview = document.getElementById('preview');
        preview.innerHTML = ''; // clear previous

        [...files].forEach(file => {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function (e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'w-full h-32 object-cover rounded border';
            preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
        });
    }

    const fileTempl = document.getElementById("file-template"),
    imageTempl = document.getElementById("image-template"),
    empty = document.getElementById("empty");

    // use to store pre selected files
    let FILES = {};

    // check if file is of type image and prepend the initialied
    // template to the target element
    function addFile(target, file) {
    const isImage = file.type.match("image.*"),
        objectURL = URL.createObjectURL(file);

    const clone = isImage
        ? imageTempl.content.cloneNode(true)
        : fileTempl.content.cloneNode(true);

    clone.querySelector("h1").textContent = file.name;
    clone.querySelector("li").id = objectURL;
    clone.querySelector(".delete").dataset.target = objectURL;
    clone.querySelector(".size").textContent =
        file.size > 1024
        ? file.size > 1048576
            ? Math.round(file.size / 1048576) + "mb"
            : Math.round(file.size / 1024) + "kb"
        : file.size + "b";

    isImage &&
        Object.assign(clone.querySelector("img"), {
        src: objectURL,
        alt: file.name
        });

    empty.classList.add("hidden");
    target.prepend(clone);

    FILES[objectURL] = file;
    }

    const gallery = document.getElementById("gallery"),
    overlay = document.getElementById("overlay");

    // click the hidden input of type file if the visible button is clicked
    // and capture the selected files
    const hidden = document.getElementById("hidden-input");
    document.getElementById("button").onclick = () => hidden.click();
    hidden.onchange = (e) => {
    for (const file of e.target.files) {
        addFile(gallery, file);
    }
    };

    // use to check if a file is being dragged
    const hasFiles = ({ dataTransfer: { types = [] } }) =>
    types.indexOf("Files") > -1;

    // use to drag dragenter and dragleave events.
    // this is to know if the outermost parent is dragged over
    // without issues due to drag events on its children
    let counter = 0;

    // reset counter and append file to gallery when file is dropped
    function dropHandler(ev) {
    ev.preventDefault();
    for (const file of ev.dataTransfer.files) {
        addFile(gallery, file);
        overlay.classList.remove("draggedover");
        counter = 0;
    }
    }

    // only react to actual files being dragged
    function dragEnterHandler(e) {
    e.preventDefault();
    if (!hasFiles(e)) {
        return;
    }
    ++counter && overlay.classList.add("draggedover");
    }

    function dragLeaveHandler(e) {
    1 > --counter && overlay.classList.remove("draggedover");
    }

    function dragOverHandler(e) {
    if (hasFiles(e)) {
        e.preventDefault();
    }
    }

    // event delegation to caputre delete events
    // fron the waste buckets in the file preview cards
    // gallery.onclick = ({ target }) => {
    // if (target.classList.contains("delete")) {
    //     const ou = target.dataset.target;
    //     document.getElementById(ou).remove(ou);
    //     gallery.children.length === 1 && empty.classList.remove("hidden");
    //     delete FILES[ou];
    // }
    // };

    // // print all selected files
    // document.getElementById("submit").onclick = () => {
    // alert(`Submitted Files:\n${JSON.stringify(FILES)}`);
    // console.log(FILES);
    // };

    // // clear entire selection
    // document.getElementById("cancel").onclick = () => {
    // while (gallery.children.length > 0) {
    //     gallery.lastChild.remove();
    // }
    // FILES = {};
    // empty.classList.remove("hidden");
    // gallery.append(empty);
    // };

    // document.getElementById("submission-form").onsubmit = function (e) {
    //   e.preventDefault();

    // function insert_data2(){

    // const formData = new FormData();
    // formData.append("description", document.getElementById("content-submission-description").value);

    // // Tambahkan file dari FILES
    // Object.values(FILES).forEach((file, index) => {
    //     formData.append("file_submissions[]", file);
    // });

    // fetch(`${path}/submit/1`, {
    //     method: "POST",
    //     body: formData,
    //     headers: {
    //     'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
    //     }
    // })
    //     .then(response => response.json())
    //     .then(data => console.log(data))
    //     .catch(error => console.error("Upload failed", error));
    // };

    function createFileList(files) {
        const dataTransfer = new DataTransfer(); // untuk Chrome, Firefox
        files.forEach(file => dataTransfer.items.add(file));
        return dataTransfer.files;
    }


    function insert_data2() {
        // Buat form baru secara dinamis
        const form = document.createElement('form');
        form.action = `${path}/submit/1`;
        form.method = 'POST';
        form.enctype = 'multipart/form-data';

        // Tambahkan CSRF token
        const csrf = document.querySelector('input[name="_token"]').value;
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrf;
        form.appendChild(csrfInput);

        // Tambahkan description
        const description = document.getElementById("content-submission-description").value;
        const descriptionInput = document.createElement('input');
        descriptionInput.type = 'hidden';
        descriptionInput.name = 'description';
        descriptionInput.value = description;
        form.appendChild(descriptionInput);

        // Tambahkan file satu per satu sebagai input[type=file] (workaround)
        Object.values(FILES).forEach((file, index) => {
            const fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.name = 'file_submissions[]';
            fileInput.files = createFileList([file]); // <- pakai helper
            form.appendChild(fileInput);
        });

        // Tambahkan form ke body dan submit
        document.body.appendChild(form);
        form.submit();
    }


    </script>

</x-layout>