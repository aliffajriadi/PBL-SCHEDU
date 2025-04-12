<x-layout title="Group Notes" role="student">
    <x-nav-group type="search" page="notes"></x-nav-group>

    <!-- Konten Utama -->
    <div class="flex gap-3 mt-3">
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
                        class="block w-full border-b-2 notes border-emerald-400 pb-3 hover:border-emerald-600 hover:bg-emerald-50 cursor-pointer transition-all duration-300 notelist">
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
</x-layout>