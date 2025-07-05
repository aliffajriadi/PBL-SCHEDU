<x-layout title="Notes" role="teacher" :user="$user" :image="$data['user']->profile_pic !== null ? asset('storage/' . $data['user']->instance->folder_name . '/' . $data['user']->profile_pic) : 'image/Ryan-Gosling.jpg'">
    <!-- Header dengan Search dan Tombol Add -->
    <div class="bg-white mb-3 flex flex-row-reverse md:flex-row justify-between p-3 shadow-md rounded-2xl items-center">
  
        <input type="text" id="search" placeholder="Search Note list...."
            class="mt-2 sm:mt-0 w-full sm:w-1/3 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-300 transition-all"
            onkeyup="getSearch()">
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

    </div>

    <!-- Script untuk Modal dan Search -->
    <script>

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
