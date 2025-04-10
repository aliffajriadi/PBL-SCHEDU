<x-layout title="Schedule" role="teacher">
    <!-- Header Section -->
    <div class="bg-white mb-3 flex flex-row-reverse md:flex-row justify-between items-center p-3 shadow-md rounded-2xl">
        <button 
            onclick="openModal()"
            class="bg-emerald-500 text-white hover:bg-emerald-600 px-4 py-2 rounded-lg text-sm transition-all duration-300"
        >
            + Add schedule
        </button>
        <input 
            type="text" 
            id="search" 
            placeholder="Search Note list..." 
            class="mt-2 sm:mt-0 w-full sm:w-1/3 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-300 transition-all"
            onkeyup="getSearch()"
        >
    </div>

    <!-- Main Content -->
    <div class="flex flex-col md:flex-row gap-3 mt-3 pb-7 animate-fadeIn w-full">
        <!-- Note List Section -->
        <div class="bg-white p-3 w-full md:w-5/12 shadow-md rounded-2xl">
            <h2 class="text-lg mb-4 font-semibold text-gray-800">Note List</h2>
            <div class="p-3 rounded-2xl h-96 overflow-auto">
                @php
                    $notes = [
                        ['title' => 'Nasi Padang', 'created_at' => '87 minutes ago'],
                        ['title' => 'Nasi Goreng', 'created_at' => '2 hours ago'],
                        ['title' => 'Sate Ayam', 'created_at' => '1 day ago'],
                        ['title' => 'Rendang Daging', 'created_at' => '3 days ago'],
                        ['title' => 'Gado-Gado', 'created_at' => '5 days ago'],
                        ['title' => 'Nasi Padang', 'created_at' => '87 minutes ago'],
                        ['title' => 'Nasi Goreng', 'created_at' => '2 hours ago'],
                        ['title' => 'Sate Ayam', 'created_at' => '1 day ago'],
                        ['title' => 'Rendang Daging', 'created_at' => '3 days ago'],
                        ['title' => 'Gado-Gado', 'created_at' => '5 days ago'],
                    ];
                @endphp

                @foreach ($notes as $note)
                    <div class="relative mb-3 border-b-2 border-emerald-400 pb-3 hover:border-emerald-600 hover:bg-emerald-50 transition-all duration-300 notelist">
                        <div class="block w-full">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg">{{ $note['title'] }}</h3>
                                <p>{{ $loop->iteration }}</p>
                            </div>
                            <p class="text-xs opacity-60">Created at {{ $note['created_at'] }}</p>
                        </div>
                        <!-- Dropdown Menu -->
                        <div class="absolute right-7 top-0">
                            <button class="text-white hover:text-gray-700 bg-emerald-500 px-2 focus:outline-none" onclick="toggleDropdown(this)">
                                <span class="text-lg font-bold hover:text-2xl">⋮</span>
                            </button>
                            <div class="dropdown-menu hidden absolute right-0 mt-2 w-32 bg-white rounded-md shadow-lg z-10">
                                <button class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-emerald-100" onclick="editNote('{{ $note['title'] }}')">
                                    Edit
                                </button>
                                <button class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-emerald-100" onclick="deleteNote('{{ $note['title'] }}')">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Calendar Section -->
        <div class="bg-white shadow-md rounded-2xl p-3 md:w-7/12">
            <x-calender></x-calender>
        </div>
    </div>
</x-layout>

<!-- JavaScript untuk Dropdown -->
<script>
    function toggleDropdown(button) {
        const dropdown = button.nextElementSibling;
        dropdown.classList.toggle('hidden');
    }

    // Menutup dropdown ketika klik di luar
    document.addEventListener('click', function(event) {
        const dropdowns = document.getElementsByClassName('dropdown-menu');
        for (let i = 0; i < dropdowns.length; i++) {
            const dropdown = dropdowns[i];
            if (!dropdown.previousElementSibling.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        }
    });

    function editNote(title) {
        console.log('Editing note:', title);
        // Tambahkan logika edit di sini
    }

    function deleteNote(title) {
        console.log('Deleting note:', title);
        // Tambahkan logika hapus di sini
    }
</script>

<style>
    .dropdown-menu {
        min-width: 8rem;
    }
</style>