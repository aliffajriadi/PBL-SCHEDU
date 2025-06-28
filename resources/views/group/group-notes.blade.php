<x-layout title="Group Notes" role="{{ $role }}" :user="$user">
    <x-nav-group type="search" page="notes"></x-nav-group>

    <!-- Konten Utama -->
    <section class="flex flex-col lg:flex-row mt-3 gap-4">
        <!-- Bagian Kiri: Daftar Catatan -->
        <div class="bg-white shadow-md rounded-2xl w-full lg:w-5/12 p-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Note List</h2>
                @if($role === 'teacher')
                    <button onclick="openAddNoteModal()"
                        class="bg-emerald-400 text-white px-3 py-1 rounded-lg hover:bg-emerald-500 transition">
                        + Add Note
                    </button>
                @endif
            </div>
            <!-- Daftar Catatan -->
            <div id="note-list" class="flex flex-col gap-3 max-h-96 overflow-auto">
          
            </div>
            <x-pagination></x-pagination>
        </div>

        <!-- Bagian Kanan: Detail Catatan -->
        <div class="bg-white shadow-md rounded-2xl w-full lg:w-7/12 p-4 mt-4 lg:mt-0">
            @if($role === 'teacher')
                <!-- Form Edit Catatan untuk Guru -->
                <form id="note-content" class="hidden">
                    {{-- @csrf
                    @method('PUT') --}}
                    <input id="title" type="text" name="title" value="aaaa" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                    <textarea id="content" name="content" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" rows="6" required></textarea>
                    <input id="update-file" type="file" name="file" class="mb-2 p-2 border border-gray-200 rounded-lg w-full">
                    <div class="mt-2">
                        <p class="text-sm font-medium text-gray-700">File:</p>
                        <ul id="content-files" class="list-disc pl-5 text-sm text-gray-600">
    
                        </ul>
                    </div>

                    <br>
                    <div class="flex gap-4">
                        <button type="button" onclick="open_update_modal(false, update_data)" class="bg-emerald-400 text-white px-4 py-2 rounded-lg hover:bg-emerald-500 transition">Update Note</button>
                        <button id="delete-button" type="button" onclick="openDeleteModal(1, a)"
                            class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">Delete Note</button>
                    </div>
                </form>
            @else
                <!-- Tampilan untuk Murid (Hanya Baca) -->
                <div id="note-content" class="hidden">
                    <h3 id="title" class="text-xl font-bold text-gray-800 mb-2">a</h3>
                    <p class="text-sm text-gray-500 mb-4">Created at: a</p>
                    <div class="mt-2">
                        <p class="text-sm font-medium text-gray-700">File:</p>
                        <ul id="content-files" class="list-disc pl-5 text-sm text-gray-600">
 
                        </ul>
                    </div>
                    <p id="content" class="text-gray-700 mb-6"></p>
                </div>
            @endif
            {{-- @if(!empty($note['attachments']))
                <div id="teacher-button" class="border-t border-gray-200 pt-4 mt-4">
                    <h4 class="font-semibold text-gray-700 mb-2">Existing Attachments</h4>
                    <ul class="list-disc pl-5 text-sm text-gray-600">
                        @foreach($note['attachments'] as $attachment)
                            <li>
                                <a href="{{ asset('storage/' . $attachment['path']) }}" target="_blank"
                                    class="text-emerald-400 hover:underline">{{ $attachment['name'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif --}}
                   
            <div id="note-null" class="flex flex-col items-center justify-center h-full text-gray-500">
                <img src="/image/ilustr1.jpg" alt="ilustrator" class="w-40 h-auto mb-4">
                <p>Pilih catatan di sebelah kiri untuk melihat detail.</p>
            </div>
        </div>
    </section>

    <!-- Bagian Riwayat Catatan -->
    <section class="bg-white rounded-2xl shadow-md p-4 w-full mt-3">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Note History</h3>



        @if(!empty($latest_notes))
            <div class="flex flex-col gap-3 max-h-96 overflow-auto">
                @foreach($latest_notes as $note)
                    <div class="bg-white border border-gray-200 rounded-md p-3">
                        <p class="text-gray-800 font-medium">{{ $note['title'] }} - {{ strcmp($note['created_at'], $note['updated_at']) === 0 ? 'Created' : 'Updated'}}</p>
                        <p class="text-sm text-gray-500">Timestamp: {{ $note['created_at'] }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ $note['content'] }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-gray-500 text-center">
                <p>Belum ada riwayat catatan.</p>
            </div>
        @endif
    </section>

    <!-- Modal Tambah Catatan (Hanya untuk Guru) -->
    @if($role === 'teacher')
        <div id="add-note-modal" class="hidden overflow-auto fixed inset-0 bg-slate-50/50 backdrop-blur-sm flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Tambah Catatan Baru</h3>
                <form id="add-note-form" action="api" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input id="add-title" type="text" name="title" placeholder="Note Title" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                    <textarea id="add-content" name="content" placeholder="Note Content" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" rows="4" required></textarea>
                    {{-- <input type="file" name="file" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" accept=".pdf,.doc,.docx,.jpg,.png" multiple> --}}
                        <x-multiple-file></x-multiple-file>

                    <br>
                    <div class="flex justify-end gap-4">
                        <button type="button" onclick="closeAddNoteModal()"
                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                            Batal
                        </button>
                        <button 
                            type="button"
                            onclick="insert_data()"
                            class="bg-emerald-400 text-white px-4 py-2 rounded-lg hover:bg-emerald-500 transition">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    <!-- Modal Konfirmasi Delete (Hanya untuk Guru) -->
        <div id="delete-modal" class="hidden fixed inset-0 bg-slate-50/50 shadow-md backdrop-blur-sm flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Hapus Catatan</h3>
                <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus catatan ini? Tindakan ini tidak dapat dibatalkan.</p>
                <form id="delete-note-form" action="" method="POST">
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

    <x-success></x-success>
    <x-update-modal></x-update-modal>

    <!-- JavaScript untuk Pratinjau File, Modal Tambah, dan Modal Delete -->
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


        function show_data(id)
        {
            note_picked = id;

            get_data(path + `/api`, function (data) {
                const note = data.data;
                const files = data.files;

                console.log(note.id);

                document.getElementById('note-null').classList.add('hidden');
                document.getElementById('note-content').classList.remove('hidden');

                if('{{$role}}' === 'teacher'){
                    const update_file = document.getElementById('update-file');
                    update_file.value = '';
                    update_file.onchange = () => {
                        new_file(note.id);
                    }

                    document.getElementById('delete-button').onclick = () => {
                        openDeleteModal(note.id, note.title)
                    };
                    title.value = note.title;
                    content.value = note.content;
                }else{
                    title.textContent = note.title;
                    content.textContent = note.content;
                }

                const file_list = document.getElementById('content-files');

                file_list.innerHTML = '';

                files.forEach((file) => {
                    file_list.innerHTML += `
                        <li>
                                        <a href="${path}/file/${file.stored_name}" target="_blank" class="text-emerald-400 hover:underline">
                                            ${file.original_name}
                                        </a>
                                        <button type="button" onclick="delete_file('${file.stored_name}', ${id})"> <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg></button>
                                    </li>
                    `;
                })
                

            }, id);
        }

        function show_list(notes)
        {
            const parent = document.getElementById('note-list');
            parent.innerHTML = '';

            if(notes.datas.last_page <= 1) document.getElementById('pagination').classList.add('hidden'); 
            else document.getElementById('pagination').classList.remove('hidden');  

            max_page = notes.datas.last_page;

            notes.datas.data.forEach((note) => {
                parent.innerHTML += `
                    <div onclick="show_data(${note.id})"
                        class="block border-l-4 border-emerald-400 pl-3 py-2 rounded-sm hover:bg-emerald-50 transition-all duration-300">
                        <div class="flex justify-between items-center">
                            <h3 class="font-medium text-gray-800">${note.title}</h3>
                            <p class="text-sm text-gray-500"></p>
                        </div>
                        <p class="text-sm text-gray-500">Created at ${note.created_at}</p>
                    </a>
                `;
            });

        }

        function new_file(id)
        {
            const formData = new FormData();
            const file_input = document.getElementById('update-file');
            
            if(file_input.files.length > 0){
                formData.append('file', file_input.files[0]);
            }
            
            api_update(`${path}/file`, formData, id).then(response => {
                if(response.status === true){
                    open_success(response.message);
                    document.getElementById('content-files').innerHTML += `
                        <li>
                                        <a href="${path}/file/${response.stored_name}" target="_blank" class="text-emerald-400 hover:underline">
                                            ${response.original_name}
                                        </a>
                                        <button type="button" onclick="delete_file('${response.stored_name}', ${response.id})"> <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg></button>
                                    </li>
                    `
                }
            });
        
            file_input.value = '';
        }

        function insert_data()
        {
            const form = document.getElementById('add-note-form');
            const formData = new FormData(form);

            Object.values(FILES).forEach((file) => {
                formData.append('files[]', file);
            });

            for (let [key, value] of formData.entries()) {
                console.log(`${key}: ${value}`);
            }

            api_store(path + '/api', formData).then((response) =>{
                document.getElementById("gallery").innerHTML = '';
                document.getElementById("hidden-input").value = '';
                FILES = {};
                empty.classList.remove("hidden");
                search();

                if(response.status) open_success(response.message);
                else open_fail(response.message);

            });

            closeAddNoteModal();
        }

        function delete_data()
        {
            api_destroy(`${path}/api`, note_picked).then(response => {
                search();

                if(response.status) open_success(response.message);
                else open_fail(response.message);
            });
            closeDeleteModal();

            document.getElementById('note-null').classList.remove('hidden');
            document.getElementById('note-content').classList.add('hidden');
        }

        function update_data()
        {
            const form = document.getElementById('note-content');
            const fileInputs = document.getElementById('update-file');
            const formData = new FormData(form);

            formData.delete('files[]');

            console.log(fileInputs.files.length)

            for(let i = 0; i < fileInputs.files.length; i++){
                formData.append('files[]', fileInputs.files[i]);
            }

            api_update(`${path}/api`, formData, note_picked).then(response => {
                search();
                show_data(note_picked);

                if(response.status) open_success(response.message);
                else open_fail(response.message);

                close_update_modal();
            });
        }

        function delete_file(stored_name, id)
        {
            api_destroy(`${path}/file`, stored_name).then(response => {
                show_data(id);

                if(response.status) open_success(response.message);
                else open_fail(response.message);
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            // // Pratinjau File
            // const fileInputs = document.getElementById('update-data');

            // fileInputs.addEventListener('');
            // fileInputs.addEventListener('change', function (event) {
            //         const preview = document.createElement('div');
            //         preview.className = 'flex flex-col gap-2 mb-4';
            //         const files = event.target.files;
            //         for (let file of files) {
            //             const fileItem = document.createElement('div');
            //             fileItem.className = 'flex items-center gap-2 text-gray-700';
            //             let icon = '';
            //             if (file.type === 'application/pdf') {
            //                 icon = '<svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>';
            //             } else if (file.type.includes('msword') || file.type.includes('wordprocessingml')) {
            //                 icon = '<svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>';
            //             } else if (file.type.includes('image')) {
            //                 icon = '<svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>';
            //             } else {
            //                 icon = '<svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>';
            //             }
            //             fileItem.innerHTML = `${icon}<span class="text-sm">${file.name}</span>`;
            //             preview.appendChild(fileItem);
            //         }
            //         input.parentNode.insertBefore(preview, input.nextSibling);
            //     });
            // });

            // Fungsi Modal Tambah Catatan
            window.openAddNoteModal = function() {
                const modal = document.getElementById('add-note-modal');
                modal.classList.remove('hidden');
                modal.classList.add('slide-down');
            };

            window.closeAddNoteModal = function() {
                const modal = document.getElementById('add-note-modal');
                modal.classList.add('hidden');


                document.getElementById('add-title').value = '';
                document.getElementById('add-content').value = '';
            };

            // Fungsi Modal Delete
            window.openDeleteModal = function(noteId, noteTitle) {
                const modal = document.getElementById('delete-modal');
                // const titleSpan = document.getElementById('delete-note-title');
                const form = document.getElementById('delete-note-form');
                // titleSpan.textContent = noteTitle;
                
                // form.action = `/notes/delete/${noteId}`;
                modal.classList.remove('hidden');
            };

            window.closeDeleteModal = function() {
                note_picked = -1;
                const modal = document.getElementById('delete-modal');
                modal.classList.add('hidden');
            };
        });
    </script>
</x-layout>