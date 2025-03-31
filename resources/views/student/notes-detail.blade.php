<x-layout title="Notes" role="teacher">
    <div class="bg-white mb-3 flex md:flex-row justify-between p-3 shadow-md rounded-2xl items-center">
        <button class="bg-emerald-400 text-white hover:opacity-75 cursor-pointer rounded-2xl py-1 px-3 text-sm">Back to list</button>
        <input type="text" id="search" placeholder="Search Note list...."
            class="border-2 hidden md:block border-emerald-400 rounded-2xl py-1 px-2 text-sm w-1/3 md:w-1/4" onkeyup="getSearch()">
    </div>

    <div class="flex gap-3">
        {{-- BAGIAN KIRI --}}
        <div class="bg-white p-3 hidden md:block w-5/12 shadow-md rounded-2xl">
            <h2 class="text-lg mb-4">Note List</h2>
            <div class="p-3 rounded-2xl h-72 overflow-auto">
                {{-- DUMMY DATA --}}
                @php
                    $notes = [
                        ['title' => 'Nasi Padang', 'created_at' => '87 minutes ago'],
                        ['title' => 'Nasi Goreng', 'created_at' => '2 hours ago'],
                        ['title' => 'Sate Ayam', 'created_at' => '1 day ago'],
                        ['title' => 'Rendang Daging', 'created_at' => '3 days ago'],
                        ['title' => 'Gado-Gado', 'created_at' => '5 days ago'],
                    ];
                @endphp
                @foreach ($notes as $note)
                    <a href="#"
                        class="block w-full border-b-2 border-emerald-400 pb-3 hover:border-emerald-600 hover:bg-emerald-50 cursor-pointer transition-all duration-300 notelist">
                        <div class="flex justify-between items-center mt-3">
                            <h3 class="text-lg">{{ $note['title'] }}</h3>
                            <p>{{ $loop->iteration }}</p>
                        </div>
                        <p class="text-xs opacity-60">Created at {{ $note['created_at'] }}</p>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- BAGIAN KANAN --}}
        <div class="bg-emerald-400 p-3 w-full md:w-7/12 shadow-md rounded-2xl h-96">
            <div class="flex justify-between items-center text-white">
                <div>
                    <h2 class="text-xl font-semibold text-white">Masakan Padang</h2>
                    <p class="text-xs text-gray-100">Created at 27 November 2024</p>
                </div>
                <div class="flex gap-x-2">
                    <button onclick="openModal()"
                        class="text-sm flex py-1 items-center gap-1 cursor-pointer bg-amber-500 px-2 rounded-2xl hover:opacity-75 transition-all duration-300">
                        <img src="{{ asset('assets/edit.svg') }}" class="w-4 h-auto">
                        <p>Edit</p>
                    </button>

                    <button
                        class="text-sm py-1 flex items-center gap-1 cursor-pointer bg-red-500 px-2 rounded-2xl hover:opacity-75 transition-all duration-300">
                        <img src="{{ asset('assets/edit.svg') }}" class="w-4 h-auto">
                        <p>Delete</p>
                    </button>
                </div>
            </div>
            <div class="bg-emerald-50 p-3 mt-3 rounded-2xl h-72 overflow-auto">
                <p class="text-sm">Lorem ipsum dolor Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia,
                    labore vero quasi voluptas incidunt et voluptatum, asperiores soluta reprehenderit quod dolorem est
                    eius id consectetur ex ut esse repudiandae laboriosam! sit amet consectetur adipisicing elit.
                    Quisquam, voluptatibus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem quia quae
                    excepturi odio facilis obcaecati minus tempore? Laudantium quis ut odio ipsum corrupti quaerat fuga.
                    Eos fugiat eveniet commodi repudiandae.
                    Laborum at repudiandae ratione et laudantium corrupti, labore tempora corporis temporibus cupiditate
                    nisi! Rerum ipsam soluta quam esse amet laborum similique. Nam at quae sit incidunt ad ullam nobis?
                    Recusandae.
                    Iste repudiandae veritatis ut tempora voluptas minus? Cupiditate, laboriosam dolor repellendus
                    dolorem id illo quisquam quibusdam aut rerum libero nostrum numquam ad officia, eius quia nam ab cum
                    architecto temporibus?</p>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Edit Note</h3>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form>
                <div class="mb-4">
                    <label for="noteTitle" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <input type="text" id="noteTitle" class="w-full border-2 border-emerald-400 rounded-xl p-2 focus:outline-none focus:border-emerald-600" value="Masakan Padang">
                </div>
                
                <div class="mb-4">
                    <label for="noteContent" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                    <textarea id="noteContent" class="w-full border-2 border-emerald-400 rounded-xl p-2 h-32 focus:outline-none focus:border-emerald-600">Lorem ipsum dolor sit amet consectetur adipisicing elit...</textarea>
                </div>
                
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded-xl hover:opacity-75">Cancel</button>
                    <button type="submit" class="bg-emerald-400 text-white px-4 py-2 rounded-xl hover:opacity-75">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function getSearch() {
            let input = document.getElementById("search").value.toLowerCase();
            let items = document.querySelectorAll(".notelist");

            items.forEach(item => {
                let text = item.textContent.toLowerCase();
                if (text.includes(input)) {
                    item.classList.remove("hidden");
                } else {
                    item.classList.add("hidden");
                }
            });
        }

        // Fungsi untuk membuka modal
        function openModal() {
            document.getElementById("editModal").classList.remove("hidden");
        }

        // Fungsi untuk menutup modal
        function closeModal() {
            document.getElementById("editModal").classList.add("hidden");
        }
    </script>
</x-layout>