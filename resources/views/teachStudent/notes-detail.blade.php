<x-layout title="Notes" role="teacher" :user="$userData" :image="$userData->profile_pic !== null ? asset('storage/' . $userData->instance->folder_name . '/' . $userData->profile_pic) : 'image/Ryan-Gosling.jpg'">

    <div class="bg-white mb-3 p-3 shadow-md rounded-2xl">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <button onclick="openAddModal()"
                class="bg-emerald-500 text-white hover:bg-emerald-600 px-4 py-2 rounded-lg text-sm transition-all duration-300 w-full md:w-auto">
                + Add Note
            </button>
            <input type="text" id="search" placeholder="Search notes..."
                class="w-full md:w-80 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-300 transition-all"
                oninput="debounce_refresh()">
        </div>
    </div>
    

    <div class="flex gap-3">
        {{-- BAGIAN KIRI --}}
        <div class="bg-white p-3 hidden md:block w-5/12 shadow-md rounded-2xl">
            <h2 class="text-lg mb-4">Note List</h2>
            <div id="note-list" class="p-3 rounded-2xl h-72 overflow-auto">
                {{-- isi datanya --}}
            </div>

            <x-pagination></x-pagination>

        </div>

        {{-- <button onclick="closeContent()">a</button> --}}

        {{-- BAGIAN KANAN --}}
        <div id="card-parent"
            class="bg-white flex-col fade-in-right justify-center hidden md:flex items-center p-3 shadow-md rounded-2xl w-7/12 h-96">
            <img src="/image/ilustr1.jpg" alt="ilustrator" class="w-40 h-auto">
            <p class="text-gray-600">Click Note list for Preview</p>
        </div>

    </div>

    <!-- Modal untuk Add Notes -->
    <div id="addNoteModal"
        class="fixed inset-0 bg-black/50 flex backdrop-blur-xs items-center justify-center z-50 opacity-0 invisible transition-opacity duration-300">
        <div class="bg-white rounded-3xl p-6 w-full max-w-md shadow-2xl transform transition-all duration-300 scale-95">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-emerald-600">Add New Note</h2>
                <button onclick="closeAddModal()"
                    class="text-gray-500 hover:text-gray-700 text-2xl font-bold">×</button>
            </div>
            <form action="/note/api" method="POST" id="addNote">
                {{-- @csrf --}}
                <div class="mb-4">
                    <label for="add_title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" id="add_title" name="title"
                        class="mt-1 w-full border-2 border-emerald-400 rounded-xl py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-300 transition-all"
                        placeholder="Enter note title">
                </div>
                <div class="mb-4">
                    <label for="add_content" class="block text-sm font-medium text-gray-700">Content</label>
                    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
                    {{-- <textarea
                        class="mt-1 w-full border-2 border-emerald-400 rounded-xl py-2 px-3 text-sm h-32 resize-none focus:outline-none focus:ring-2 focus:ring-emerald-300 transition-all"
                        placeholder="Write your note here..." name="content" id="add_content"></textarea>
                    <script>
                        ClassicEditor
                            .create(document.querySelector('#add_content'))
                            .catch(error => {
                                console.error(error);
                            });
                    </script> --}}

                    <textarea id="add_content" name="content"
                        class="mt-1 w-full border-2 border-emerald-400 rounded-xl py-2 px-3 text-sm h-32 resize-none focus:outline-none focus:ring-2 focus:ring-emerald-300 transition-all"
                        placeholder="Write your note here..."></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeAddModal()"
                        class="bg-gray-200 text-gray-700 py-2 px-4 rounded-xl hover:bg-gray-300 transition-all duration-300">Cancel</button>
                    <button type="button" onclick="insert_data()"
                        class="bg-emerald-400 text-white py-2 px-4 rounded-xl hover:bg-emerald-500 transition-all duration-300">Save
                        Note</button>
                </div>
            </form>
        </div>
    </div>

    <br>

    <!-- Modal Edit -->
    <div id="editModalParent" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Edit Note</h3>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <form id="editModal">
                <div class="mb-4">
                    <label for="editTitle" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <input type="text" name="title" id="editTitle"
                        class="w-full border-2 border-emerald-400 rounded-xl p-2 focus:outline-none focus:border-emerald-600"
                        value="Masakan Padang">
                </div>

                <div class="mb-4">
                    <label for="editContent" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                    <textarea name="content" id="editContent"
                        class="w-full border-2 border-emerald-400 rounded-xl p-2 h-32 focus:outline-none focus:border-emerald-600">Lorem ipsum dolor sit amet consectetur adipisicing elit...</textarea>
                </div>

                <input type="hidden" id="note_id">

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal()"
                        class="bg-gray-500 text-white px-4 py-2 rounded-xl hover:opacity-75">Cancel</button>
                    <button type="button" onclick="open_update_modal(-1, update_data); closeModal();"
                        class="bg-emerald-400 text-white px-4 py-2 rounded-xl hover:opacity-75">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <x-delete-modal></x-delete-modal>
    <x-success></x-success>
    <x-update-modal></x-update-modal>

    <script>
   

        const debounce_search = debounce(search, 500);

        function debounce_refresh() {
            current_page = 1;
            debounce_search();
        }

        function search() {
            document.getElementById('page_count').textContent = current_page;
            const keyword = document.getElementById('search').value ? document.getElementById('search').value : '';
            get_data(`/note/api?keyword=${encodeURIComponent(keyword)}&page=${current_page}`, show_list);
        }

        search();

        function insert_data() {
            const form = document.getElementById('addNote');
            // Sinkronisasi manual isi editor ke textarea
            // for (const instance of ClassicEditor.instances ?? []) {
            //     instance.updateSourceElement(); // optional backup
            // }
            // document.querySelector('#add_content').value = document.querySelector('.ck-editor__editable').innerHTML;

            const formData = new FormData(form);


            api_store('/note/api', formData).then(response => {
                if (response.status) open_success(response.message);
                else open_fail(response.message);
            });
            closeAddModal();

            const add_title = document.getElementById('add_title');
            const add_content = document.getElementById('add_content');

            add_title.value = '';
            add_content.value = '';
            search();

        }

        function update_data() {
            const form = document.getElementById('editModal');
            const id = document.getElementById('note_id').value;

            const formData = new FormData(form);

            api_update('/note/api', formData, id).then(response => {
                closeModal();
                if (response.status) open_success(response.message);
                else open_fail(response.message);
                search();
                openContent(id);
                close_update_modal();
            });
        }

        function delete_data(id) {
            api_destroy('/note/api', id).then(response => {
                if (response.status) open_success(response.message);
                else open_fail(response.message);
                closeDeleteModal()
                closeContent()
                search();
            });
        }

        function show_list(datas) {
            const parent = document.getElementById('note-list');
            parent.innerHTML = '';

            max_page = datas.datas.last_page;

            if (datas.datas.last_page <= 1) document.getElementById('pagination').classList.add('hidden');
            else document.getElementById('pagination').classList.remove('hidden');

            datas.datas.data.forEach((data) => {
                parent.innerHTML += `
                <div onclick="openContent(${data.id})"
                    class="block w-full border-l-4 border-emerald-400 bg-white p-4 mb-3 rounded-lg shadow-sm hover:shadow-md hover:border-emerald-600 cursor-pointer transition-all duration-300 transform hover:-translate-y-0.5 notelist">
                    <div class="flex justify-between items-start">
                        <div class="flex-1 min-w-0 mr-3">
                            <h3 class="text-lg font-semibold text-gray-800 truncate">${data.title}</h3>
                            <p class="text-gray-600 mt-2 text-sm line-clamp-2">${strLimit(data.content, 100)}</p>
                        </div>
                        <div class="flex flex-col items-end">
                            <span class="bg-emerald-100 text-emerald-800 text-xs px-2 py-1 rounded-full whitespace-nowrap">
                                ${formatTanggal1(data.created_at)}
                            </span>
                        </div>
                    </div>
                </div>
                `;
            });
        }

        function content(data) {
            note = data.data;
            const card_parent = document.getElementById('card-parent');

            card_parent.className = "bg-emerald-400 p-3 w-full md:w-7/12 shadow-md rounded-2xl h-full max-h-[32rem] flex flex-col overflow-hidden";

            card_parent.innerHTML = `
    <div class="flex flex-wrap break-words justify-between items-start text-white gap-3">
        <div class="max-w-[65%]">
            <h2 class="text-lg md:text-xl font-semibold text-white break-words">${note.title}</h2>
            <p class="text-xs text-gray-100 break-words">Created at ${formatTanggal(note.created_at)}</p>
        </div>
        <div class="flex flex-col md:flex-row gap-2">
            <button onclick="openEditModal(${note.id})"
                class="text-sm flex py-1 items-center gap-1 cursor-pointer bg-amber-500 px-2 rounded-lg hover:opacity-75 transition-all duration-300">
                <img src="{{ asset('assets/edit.svg') }}" class="w-4 h-auto">
                <p class="text-xs md:text-md">Edit</p>
            </button>
            <button onclick="openDeleteModal(${note.id}, delete_data)"
                class="text-sm py-1 flex items-center gap-1 cursor-pointer bg-red-500 px-2 rounded-lg hover:opacity-75 transition-all duration-300">
                <img src="{{ asset('assets/edit.svg') }}" class="w-4 h-auto">
                <p class="text-xs md:text-md">Delete</p>
            </button>
        </div>
    </div>
    <div class="bg-emerald-50 p-3 mt-3 rounded-2xl overflow-auto grow">
        <p class="text-sm break-words whitespace-pre-line text-gray-800">${note.content}</p>
    </div>`;

        }

        async function openContent(id) {

            get_data(`/note/api`, content, id);
        }

        function closeContent() {
            const card_parent = document.getElementById('card-parent');

            card_parent.className = "transition-all duration-500 ease-out flex-col justify-center hidden md:flex items-center p-3 shadow-md rounded-2xl w-7/12 h-96 bg-white"
            card_parent.innerHTML = `
              <img src="/image/ilustr1.jpg" alt="ilustrator" class="w-40 h-auto">
            <p class="text-gray-600">Click Note list for Preview</p>`;
        }

        function getSearch() {
            let input = document.getElementById("search").value.toLowerCase();
            let items = document.querySelectorAll(".notelist");

            items.forEach(item => {

                let text = item.textContent.toLowerCase();
                console.log(text);
                if (text.includes(input)) {
                    item.classList.remove("hidden");
                } else {
                    item.classList.add("hidden");
                }
            });
        }

        // Fungsi untuk membuka modal
        async function openEditModal(id) {
            await get_data('/note/api', set_edit_modal, id);
            document.getElementById("editModalParent").classList.remove("hidden");
        }

        function set_edit_modal(data) {
            const note = data.data;

            const id = document.getElementById('note_id');
            const title = document.getElementById('editTitle');
            const content = document.getElementById('editContent');

            id.value = note.id;
            title.value = note.title;
            content.value = note.content;
        }

        // Fungsi untuk menutup modal
        function closeModal() {
            document.getElementById("editModalParent").classList.add("hidden");
        }

        function openAddModal() {
            const modal = document.getElementById('addNoteModal');
            modal.classList.remove('invisible');

            // Gunakan requestAnimationFrame agar perubahan opacity lebih smooth
            requestAnimationFrame(() => {
                modal.classList.remove('opacity-0');
                modal.querySelector('div').classList.remove('scale-95');
            });
        }

        function closeAddModal() {
            const modal = document.getElementById('addNoteModal');

            // Tambahkan kembali opacity-0 untuk animasi keluar
            modal.classList.add('opacity-0');
            modal.querySelector('div').classList.add('scale-95');

            // Setelah animasi selesai, sembunyikan modal dengan invisible
            setTimeout(() => {
                modal.classList.add('invisible');
            }, 300); // Sesuaikan dengan duration-300 di Tailwind
        }



    </script>
</x-layout>