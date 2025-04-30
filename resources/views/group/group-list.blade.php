<x-layout title="Group" role={{$role}} :user="$user">
    <!-- Header Section -->
    <div class="bg-white p-4 mb-4 flex flex-col sm:flex-row justify-between items-center shadow-md rounded-2xl">
        @if ($role == 'student')
         <button id="joinGroupBtn" class="bg-emerald-500 text-white hover:bg-emerald-600 px-4 py-2 rounded-lg text-sm transition-all duration-300">
            Join Group
        </button>
        @else
        <button id="addGroupBtn" class="bg-emerald-500 text-white hover:bg-emerald-600 px-4 py-2 rounded-lg text-sm transition-all duration-300">
            Add New Group
        </button>
        @endif
        
        <input 
            type="text" 
            placeholder="Search groups..." 
            class="mt-2 sm:mt-0 w-full sm:w-1/3 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-300 transition-all"
            onkeyup="searchGroups()"
        >
    </div>

    <!-- Group List Section -->
    <div id="group-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 pb-9">
        @php
            $groups = [
                ['name' => 'Kelas Bahasa Indonesia', 'teacher' => 'Hermanto S.pd, M.pd', 'notes' => 12, 'schedules' => 5, 'tasks' => 3, 'progress' => 0, 'pict_grub' => 'image/image2.jpg'],
                ['name' => 'Kelas Matematika', 'teacher' => 'Siti Aminah S.pd', 'notes' => 8, 'schedules' => 4, 'tasks' => 6, 'progress' => 80, 'pict_grub' => 'image/image22.png'],
                ['name' => 'Kelas IPA', 'teacher' => 'Budi Santoso S.pd', 'notes' => 15, 'schedules' => 3, 'tasks' => 2, 'progress' => 30, 'pict_grub' => 'image/image2.jpg'],
                ['name' => 'Kelas Bahasa Inggris', 'teacher' => 'Rina Wulandari S.pd', 'notes' => 10, 'schedules' => 6, 'tasks' => 4, 'progress' => 50, 'pict_grub' => 'image/image2.jpg'],
                ['name' => 'Kelas Sejarah', 'teacher' => 'Ahmad Yani S.pd', 'notes' => 7, 'schedules' => 2, 'tasks' => 5, 'progress' => 70, 'pict_grub' => 'image/image2.jpg'],
                ['name' => 'Kelas Seni Budaya', 'teacher' => 'Dewi Lestari S.pd', 'notes' => 5, 'schedules' => 3, 'tasks' => 1, 'progress' => 20, 'pict_grub' => 'image/image2.jpg'],
            ];
        @endphp
        @foreach ($groups as $group)
            <div class="bg-white fade-in-left cursor-pointer shadow-md rounded-2xl overflow-hidden group transform transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
                <div class="h-40 bg-gray-100 overflow-hidden">
                    <img src="{{ asset($group['pict_grub']) }}" alt="{{ $group['name'] }} image" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                </div>
                <div class="p-4 bg-emerald-400 infogrub transition-colors duration-300 group-hover:bg-emerald-500">
                    <h3 class="text-lg font-semibold text-gray-800 transition-colors duration-300 group-hover:text-white">{{ $group['name'] }}</h3>
                    <p class="text-sm text-gray-500 transition-colors duration-300 group-hover:text-gray-200">{{ $group['teacher'] }}</p>
                    <div class="mt-2 grid grid-cols-3 gap-2 text-xs text-gray-700 transition-colors duration-300 group-hover:text-gray-100">
                        <div class="flex items-center gap-1">
                            <img src="{{ asset('assets/bx-notepad 2.svg') }}" alt="Notes icon" class="w-4 h-4">
                            <span>{{ $group['notes'] }} Notes</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <img src="{{ asset('assets/calender-white.svg') }}" alt="Schedules icon" class="w-4 h-4">
                            <span>{{ $group['schedules'] }} Sched</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <img src="{{ asset('assets/bx-task (1) 2.svg') }}" alt="Tasks icon" class="w-4 h-4">
                            <span>{{ $group['tasks'] }} Tasks</span>
                        </div>
                    </div>
                    @if ($role != 'teacher')
                    <div class="mt-2">
                        <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                            <div class="bg-yellow-300 h-2 rounded-full transition-all duration-300 group-hover:bg-yellow-400" style="width: {{ $group['progress'] }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1 transition-colors duration-300 group-hover:text-gray-200">{{ $group['progress'] }}% Complete</p>
                    </div>
                    @else
                    <div class="flex items-center gap-2 mt-2">
                        <img src="{{ asset('assets/bx-group (1) 3.svg') }}" alt="Student" class="w-4 h-4">
                        <p class="text-sm group-hover:text-white transition-all duration-300">27 Student</p>
                    </div>
                    @endif
                    
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal untuk Add New Group -->
    <div id="addGroupModal" class="fixed inset-0 bg-gray-800/50 flex backdrop-blur-sm justify-center items-center z-50 hidden">
        <div class="p-6 bg-white rounded-2xl shadow-md w-full max-w-md">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Add New Group</h2>
            <form method="POST" action="/group/api" id="addGroupForm" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Group Name</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        placeholder="Enter group name..." 
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-300 transition-all"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label for="groupPicture" class="block text-sm font-medium text-gray-700 mb-2">Group Profile Picture</label>
                    <div class="flex items-center gap-4">
                        <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center">
                            <img id="previewImage" src="#" alt="Preview" class="w-full h-full object-cover hidden">
                            <span id="noImageText" class="text-gray-400 text-sm">No Image</span>
                        </div>
                        <input 
                            type="file" 
                            id="groupPicture" 
                            name="pic" 
                            accept="image/*" 
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-500 file:text-white hover:file:bg-emerald-600 transition-all duration-300"
                            onchange="previewGroupImage(event)"
                        >
                    </div>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal()" class="bg-gray-300 text-gray-700 hover:bg-gray-400 px-4 py-2 rounded-lg text-sm transition-all duration-300">Cancel</button>
                    <button type="submit"  class="bg-emerald-500 text-white hover:bg-emerald-600 px-4 py-2 rounded-lg text-sm transition-all duration-300">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal untuk Join Group (Student) -->
    <div id="joinGroupModal" class="fixed inset-0 bg-gray-800/50 backdrop-blur-sm flex justify-center items-center z-50 hidden">
        <div class="p-6 bg-white rounded-2xl shadow-md w-full max-w-md">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Join a Group</h2>
            <form id="joinGroupForm" method="POST" action="/group/join_group">
                @csrf
                <div class="mb-4">
                    <input 
                        type="text" 
                        id="groupSearch"
                        name="group_code" 
                        placeholder="Filter Search groups..." 
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-300 transition-all"
                        onkeyup="filterGroups()"
                    >
                </div>
                <!-- Input Pencarian Grup -->
                
                <!-- Dropdown Grup -->
                <div class="mb-4">
                    <label for="groupSelect" class="block text-sm font-medium text-gray-700 mb-2">Select Group</label>
                    <select 
                        id="groupSelect" 
                        name="groupSelect" 
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-300 transition-all"
                        {{-- required --}}
                    >
                        <option value="" disabled selected>Select a group...</option>
                        @foreach ($groups as $group)
                            <option value="{{ $loop->index + 1 }}">{{ $group['name'] }} - {{ $group['teacher'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeJoinModal()" class="bg-gray-300 text-gray-700 hover:bg-gray-400 px-4 py-2 rounded-lg text-sm transition-all duration-300">Cancel</button>
                    <button type="submit" class="bg-emerald-500 text-white hover:bg-emerald-600 px-4 py-2 rounded-lg text-sm transition-all duration-300">Join</button>
                </div>
            </form>
        </div>
    </div>

</x-layout>

<script>

    a();

    function show_data(groups)
    {   
        const parent = document.getElementById('group-list');
        
        parent.innerHTML = '';
        groups.datas.forEach((group) => {
            console.log(`{{asset('storage/app/public/${group.instance.folder_name}/groups/${group.group_code}/${group.pic}')}}`);
            
            parent.innerHTML += `
            <a href="/group/${group.group_code}">

                        <div class="bg-white fade-in-left cursor-pointer shadow-md rounded-2xl overflow-hidden group transform transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
                <div class="h-40 bg-gray-100 overflow-hidden">
                    <img src="{{ asset('storage/${group.instance.folder_name}/groups/${group.group_code}/${group.pic}') }}" alt="${group.name} image" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                </div>
                <div class="p-4 bg-emerald-400 infogrub transition-colors duration-300 group-hover:bg-emerald-500">
                    <h3 class="text-lg font-semibold text-gray-800 transition-colors duration-300 group-hover:text-white">${group.name}</h3>
                    <p class="text-sm text-gray-500 transition-colors duration-300 group-hover:text-gray-200">nama pembuat</p>
                    <div class="mt-2 grid grid-cols-3 gap-2 text-xs text-gray-700 transition-colors duration-300 group-hover:text-gray-100">
                        <div class="flex items-center gap-1">
                            <img src="{{ asset('assets/bx-notepad 2.svg') }}" alt="Notes icon" class="w-4 h-4">
                            <span>COUNT() Notes</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <img src="{{ asset('assets/calender-white.svg') }}" alt="Schedules icon" class="w-4 h-4">
                            <span>COUNT() Sched</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <img src="{{ asset('assets/bx-task (1) 2.svg') }}" alt="Tasks icon" class="w-4 h-4">
                            <span>COUNT() Tasks</span>
                        </div>
                    </div>
                    @if ($role != 'teacher')
                    <div class="mt-2">
                        <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                            <div class="bg-yellow-300 h-2 rounded-full transition-all duration-300 group-hover:bg-yellow-400" style="width: {{ $group['progress'] }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1 transition-colors duration-300 group-hover:text-gray-200">{{ $group['progress'] }}% Complete</p>
                    </div>
                    @else
                    <div class="flex items-center gap-2 mt-2">
                        <img src="{{ asset('assets/bx-group (1) 3.svg') }}" alt="Student" class="w-4 h-4">
                        <p class="text-sm group-hover:text-white transition-all duration-300">COUNT Student</p>
                    </div>
                    @endif
                </div>
            </div>
            </a>
            `;
        });
    }

    function a()
    {
        get_data('/group/api', show_data);
    }

    const userRole = "{{ $role }}"; // Menyematkan nilai $role ke variabel JavaScript
    console.log("User Role:", userRole); // Debug nilai role

    function searchGroups() {
        const input = document.querySelector('input[type="text"]').value.toLowerCase();
        document.querySelectorAll('.group').forEach(group => {
            const name = group.querySelector('.infogrub').textContent.toLowerCase();
            group.style.display = name.includes(input) ? 'block' : 'none';
        });
    }

    function openModal() {
        document.getElementById('addGroupModal').classList.remove('hidden');
        document.getElementById('addGroupModal').classList.add('slide-down');
    }
    function closeModal() {
        document.getElementById('addGroupModal').classList.add('hidden');
        // resetForm();
    }
    function previewGroupImage(event) {
        const file = event.target.files[0];
        const previewImage = document.getElementById('previewImage');
        const noImageText = document.getElementById('noImageText');
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.classList.remove('hidden');
                noImageText.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }
    }
    function resetForm() {
        // document.getElementById('addGroupForm').reset();
        // document.getElementById('previewImage').classList.add('hidden');
        // document.getElementById('noImageText').classList.remove('hidden');
    }
    document.getElementById('addGroupForm').addEventListener('submit', function(e) {
        // e.preventDefault();
        const groupName = document.getElementById('name').value;
        const groupPicture = document.getElementById('groupPicture').files[0];
        console.log('Group Name:', groupName);
        console.log('Group Picture:', groupPicture);
        closeModal();
    });
    
    const addGroupBtn = document.getElementById('addGroupBtn');
    if (addGroupBtn) {
        addGroupBtn.addEventListener('click', openModal);
    }

    function openJoinModal() {
        console.log("Opening Join Group Modal");
        document.getElementById('joinGroupModal').classList.remove('hidden');
        document.getElementById('joinGroupModal').classList.add('slide-down');
        document.getElementById('groupSearch').value = ''; // Reset input pencarian
        filterGroups(); // Reset filter saat modal dibuka
    }
    function closeJoinModal() {
        document.getElementById('joinGroupModal').classList.add('hidden');
        resetJoinForm();
    }
    function resetJoinForm() {
        // document.getElementById('joinGroupForm').reset();
        // document.getElementById('groupSearch').value = ''; // Reset input pencarian
        filterGroups(); // Reset filter saat form direset
    }
    // document.getElementById('joinGroupForm').addEventListener('submit', function(e) {
    //     // e.preventDefault();
    //     const selectedGroup = document.getElementById('groupSelect').value;
    //     console.log('Joining Group ID:', selectedGroup);
    //     closeJoinModal();
    // });

    // Fungsi untuk memfilter grup di modal
    function filterGroups() {
        const input = document.getElementById('groupSearch').value.toLowerCase();
        const select = document.getElementById('groupSelect');
        const options = select.getElementsByTagName('option');

        for (let i = 1; i < options.length; i++) { // Mulai dari 1 untuk skip opsi "Select a group..."
            const text = options[i].textContent.toLowerCase();
            options[i].style.display = text.includes(input) ? '' : 'none';
        }
    }

    const joinGroupBtn = document.getElementById('joinGroupBtn');
    if (joinGroupBtn) {
        console.log("Join Group Button found, attaching event listener");
        joinGroupBtn.addEventListener('click', openJoinModal);
    } else {
        console.log("Join Group Button not found");
    }

    function insert_data()
    {
        const form = document.getElementById('addGroupForm');
        const formData = new FormData(form);

        for (let [key, value] of formData.entries()) {
           console.log(`${key}: ${value}`);
        }
        api_store('/group/api', formData, true);
    }

</script>
