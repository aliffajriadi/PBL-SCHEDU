<x-layout title="Notes" role="teacher" :user="$user">

    <div class="bg-white mb-3 flex md:flex-row justify-between p-3 shadow-md rounded-2xl items-center">
        {{-- <button class="bg-emerald-500 text-white hover:bg-emerald-600 px-4 py-2 rounded-lg text-sm transition-all duration-300">Back to list</button> --}}
        <button onclick="openAddModal()"
            class="bg-emerald-500 text-white hover:bg-emerald-600 px-4 py-2 rounded-lg text-sm transition-all duration-300">
            + Add Notes
        </button>
        <input type="text" id="search" placeholder="Search Note list...."
            class="mt-2 sm:mt-0 w-full sm:w-1/3 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-300 transition-all" oninput="search()">
    </div>

    <div class="flex gap-3">
        {{-- BAGIAN KIRI --}}
        <div class="bg-white p-3 hidden md:block w-5/12 shadow-md rounded-2xl">
            <h2 class="text-lg mb-4">Note List</h2>
            <div id="note-list" class="p-3 rounded-2xl h-72 overflow-auto">
                {{-- isi datanya --}}
            </div>
        </div>

        <button onclick="closeContent()">a</button>

        {{-- BAGIAN KANAN --}}
        <div id="card-parent"
         class="bg-white flex-col fade-in-right justify-center hidden md:flex items-center p-3 shadow-md rounded-2xl w-7/12 h-96">
            <img src="/image/ilustr1.jpg" alt="ilustrator" class="w-40 h-auto">
            <p class="text-gray-600">Click Note list for Preview</p>
        </div>

    </div>

    <!-- Modal untuk Add Notes -->
    <div id="addNoteModal"
        class="fixed inset-0 bg-slate-100/50 flex backdrop-blur-xs items-center justify-center z-50 opacity-0 invisible transition-opacity duration-300">
        <div class="bg-white rounded-3xl p-6 w-full max-w-md shadow-2xl transform transition-all duration-300 scale-95">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-emerald-600">Add New Note</h2>
                <button onclick="closeAddModal()" class="text-gray-500 hover:text-gray-700 text-2xl font-bold">×</button>
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


    <!-- Modal Edit -->
    <div id="editModalParent" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Edit Note</h3>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="editModal">
                <div class="mb-4">
                    <label for="editTitle" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <input type="text" name="title" id="editTitle" class="w-full border-2 border-emerald-400 rounded-xl p-2 focus:outline-none focus:border-emerald-600" value="Masakan Padang">
                </div>
                
                <div class="mb-4">
                    <label for="editContent" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                    <textarea name="content" id="editContent" class="w-full border-2 border-emerald-400 rounded-xl p-2 h-32 focus:outline-none focus:border-emerald-600">Lorem ipsum dolor sit amet consectetur adipisicing elit...</textarea>
                </div>
                
                <input type="hidden" id="note_id">

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded-xl hover:opacity-75">Cancel</button>
                    <button type="button" onclick="update_data()" 
                    class="bg-emerald-400 text-white px-4 py-2 rounded-xl hover:opacity-75">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <x-success></x-success>

    <script>
        const debounce_search = debounce(refresh_list, 500);

        function search()
        {
            debounce_search();

        }

        function refresh_list()
        {
            const keyword = document.getElementById('search').value ? document.getElementById('search').value : '';
            get_data(`/note/api?keyword=${encodeURIComponent(keyword)}`, show_list);

        }

        refresh_list();

        function insert_data()
        {
            const form = document.getElementById('addNote');
            const formData = new FormData(form);


            api_store('/note/api', formData).then(response => {
                if(response.status) open_success('Berhasil menambahkan catatan baru');
                else open_fail(response.message);
            });
            closeAddModal();

            const add_title = document.getElementById('add_title');
            const add_content = document.getElementById('add_content');

            add_title.value = '';
            add_content.value = '';
            refresh_list();
            
        }

        function update_data()
        {
            const form = document.getElementById('editModal');
            const id = document.getElementById('note_id');
            
            const formData = new FormData(form);

            api_update('/note/api', formData, id.value);
            refresh_list();
        
            open_success();

            closeModal();
        }

        function delete_data(id)
        {
            api_destroy('/note/api', id).then(response => {
                closeContent()
                refresh_list();
            });
        }

        function show_list(datas) {
            const parent = document.getElementById('note-list');
            parent.innerHTML = '';
            
            datas.datas.forEach((data) => {
                parent.innerHTML += ` <div onclick="openContent(${data.id})"
                        class="block w-full border-b-2 border-emerald-400 pb-3 hover:border-emerald-600 hover:bg-emerald-50 cursor-pointer transition-all duration-300 notelist">
                        <div class="flex justify-between items-center mt-3">
                            <h3 class="text-lg">${data.title}</h3>
                            <p>${data.content}</p>
                        </div>
                        <p class="text-xs opacity-60"></p>
                    </div>`;
            });
        }

        function content(data)
        {
            note = data.data;
            const card_parent = document.getElementById('card-parent');

            card_parent.className = "bg-emerald-400 p-3 w-full md:w-7/12 shadow-md rounded-2xl h-96" 
            card_parent.innerHTML = 
            `<div class="flex justify-between items-center text-white">
                <div>
                    <h2 class="text-lg md:text-xl font-semibold text-white">${note.title}</h2>
                    <p class="text-xs text-gray-100">Created at 27 November 2024</p>
                </div>
                <div class="flex flex-col md:flex-row gap-2">
                    <button onclick="openEditModal(${note.id})"
                        class="text-sm flex py-1 items-center gap-1 cursor-pointer bg-amber-500 px-2 rounded-lg hover:opacity-75 transition-all duration-300">
                        <img src="{{ asset('assets/edit.svg') }}" class="w-4 h-auto">
                        <p class="text-xs md:text-md">Edit</p>
                    </button>

                    <button onclick="delete_data(${note.id})"
                        class="text-sm py-1 flex items-center gap-1 cursor-pointer bg-red-500 px-2 rounded-lg hover:opacity-75 transition-all duration-300">
                        <img src="{{ asset('assets/edit.svg') }}" class="w-4 h-auto">
                        <p class="text-xs md:text-md">Delete</p>
                    </button>
                </div>
            </div>
            <div class="bg-emerald-50 p-3 mt-3 rounded-2xl h-72 overflow-auto">
                <p class="text-sm">${note.content}</p>
            </div>`;
        }

        async function openContent(id)
        {

            get_data(`/note/api`, content, id);    
        }

        function closeContent()
        {
            const card_parent = document.getElementById('card-parent');

            card_parent.className = "transition-all duration-500 ease-out flex-col justify-center hidden md:flex items-center p-3 shadow-md rounded-2xl w-7/12 h-96 bg-white" 
            card_parent.innerHTML = `
              <img src="/image/ilustr1.jpg" alt="ilustrator" class="w-40 h-auto">
            <p class="text-gray-600">Click Note list for Preview</p>`;
        }

        function getSearch() 
        {
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

        function set_edit_modal(data)
        {
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