<x-layout title="Notes" role="teacher">
    <!-- Header dengan Search dan Tombol Add -->
    <div class="bg-white mb-3 flex flex-row-reverse md:flex-row justify-between p-3 shadow-md rounded-2xl items-center">
        <button onclick="openModal()"
            class="bg-emerald-500 text-white hover:bg-emerald-600 px-4 py-2 rounded-lg text-sm transition-all duration-300">
            + Add Notes
        </button>
        <input type="text" id="search" placeholder="Search Note list...."
            class="mt-2 sm:mt-0 w-full sm:w-1/3 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-300 transition-all"
            onkeyup="getSearch()">
    </div>

    <!-- Modal untuk Add Notes -->
    <div id="addNoteModal"
        class="fixed inset-0 bg-slate-100/50 flex backdrop-blur-xs items-center justify-center z-50 opacity-0 invisible transition-opacity duration-300">
        <div class="bg-white rounded-3xl p-6 w-full max-w-md shadow-2xl transform transition-all duration-300 scale-95">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-emerald-600">Add New Note</h2>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 text-2xl font-bold">×</button>
            </div>
            <form>
                <div class="mb-4">
                    <label for="noteTitle" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" id="noteTitle"
                        class="mt-1 w-full border-2 border-emerald-400 rounded-xl py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-300 transition-all"
                        placeholder="Enter note title">
                </div>
                <div class="mb-4">
                    <label for="noteContent" class="block text-sm font-medium text-gray-700">Content</label>
                    <textarea id="noteContent"
                        class="mt-1 w-full border-2 border-emerald-400 rounded-xl py-2 px-3 text-sm h-32 resize-none focus:outline-none focus:ring-2 focus:ring-emerald-300 transition-all"
                        placeholder="Write your note here..."></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeModal()"
                        class="bg-gray-200 text-gray-700 py-2 px-4 rounded-xl hover:bg-gray-300 transition-all duration-300">Cancel</button>
                    <button type="submit"
                        class="bg-emerald-400 text-white py-2 px-4 rounded-xl hover:bg-emerald-500 transition-all duration-300">Save
                        Note</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Konten Utama -->
    <div class="flex gap-3">
        <!-- Bagian Kiri -->
        <div class="bg-white p-3 fade-in-left w-full md:w-5/12 shadow-md rounded-2xl">
            <h2 class="text-lg mb-4 font-semibold text-gray-800">Note List</h2>
            <div class="p-3 rounded-2xl h-72 overflow-auto">
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
                    <a href="/notes/detail"
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

        <!-- Bagian Kanan -->
        <div class="bg-white flex-col fade-in-right justify-center hidden md:flex items-center p-3 shadow-md rounded-2xl w-7/12 h-96">
            <img src="/image/ilustr1.jpg" alt="ilustrator" class="w-40 h-auto">
            <p class="text-gray-600">Click Note list for Preview</p>
        </div>
    </div>

    <!-- Script untuk Modal dan Search -->
    <script>
        function openModal() {
            const modal = document.getElementById('addNoteModal');
            modal.classList.remove('invisible');

            // Gunakan requestAnimationFrame agar perubahan opacity lebih smooth
            requestAnimationFrame(() => {
                modal.classList.remove('opacity-0');
                modal.querySelector('div').classList.remove('scale-95');
            });
        }

        function closeModal() {
            const modal = document.getElementById('addNoteModal');

            // Tambahkan kembali opacity-0 untuk animasi keluar
            modal.classList.add('opacity-0');
            modal.querySelector('div').classList.add('scale-95');

            // Setelah animasi selesai, sembunyikan modal dengan invisible
            setTimeout(() => {
                modal.classList.add('invisible');
            }, 300); // Sesuaikan dengan duration-300 di Tailwind
        }

        // Fungsi pencarian
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
    </script>
</x-layout>
