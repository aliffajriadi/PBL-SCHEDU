<x-layout title="Group" role={{$role}} :user="$user" :image="$userData->profile_pic !== null ? asset('storage/' . $userData->instance->folder_name . '/' . $userData->profile_pic) : 'image/Ryan-Gosling.jpg'">
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
            id="search"
            placeholder="Search groups..." 
            class="mt-2 sm:mt-0 w-full sm:w-1/3 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-300 transition-all"
            oninput="search()"
        >
    </div>

    <!-- Group List Section -->
    <div id="group-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 pb-9">
     
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

    <x-pagination></x-pagination>

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
                        placeholder="Enter Group Code..." 
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-300 transition-all"
                        onkeyup="filterGroups()"
                    >
                </div>
                <!-- Input Pencarian Grup -->
                
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeJoinModal()" class="bg-gray-300 text-gray-700 hover:bg-gray-400 px-4 py-2 rounded-lg text-sm transition-all duration-300">Cancel</button>
                    <button type="submit" class="bg-emerald-500 text-white hover:bg-emerald-600 px-4 py-2 rounded-lg text-sm transition-all duration-300">Join</button>
                </div>
            </form>
        </div>
    </div>

    <x-success></x-success>

</x-layout>


<script>

    const debounce_search = debounce(a, 500);

    a();

    function search()
    {
        debounce_search();
        
    }

    function show_data(groups)
    {   
        const parent = document.getElementById('group-list');
        const folder_name = '{{ $folder_name }}';
        let group;
        let note_count;
        let task_count;
        let schedule_count;
        let member_count;
        let group_pic;

        if(groups.datas.last_page <= 1) document.getElementById('pagination').classList.add('hidden'); 
        else document.getElementById('pagination').classList.remove('hidden');  

        max_page = groups.datas.last_page;

        parent.innerHTML = '';
        groups.datas.data.forEach((group) => {
            
            console.log(`{{asset('storage/app/public/${folder_name}/groups/${group.group_code}/${group.pic}')}}`);
            
            note_count = group.note_count;
            task_count = group.task_count;
            schedule_count = group.schedule_count;
            member_count = group.member_count;
            
            console.log(group.pic)

            group_pic = group.pic === null ? `{{ asset('image/image2.jpg') }}` : `{{ asset('storage/${folder_name}/groups/${group.group_code}/${group.pic}') }}`;

            parent.innerHTML += `
            <a href="/group/${group.group_code}">

                        <div class="bg-white fade-in-left cursor-pointer shadow-md rounded-2xl overflow-hidden group transform transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
                <div class="h-40 bg-gray-100 overflow-hidden">
                    <img src="${group_pic}" alt="${group.name} image" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                </div>
                <div class="p-4 bg-emerald-400 infogrub transition-colors duration-300 group-hover:bg-emerald-500">
                    <h3 class="text-lg font-semibold text-gray-800 transition-colors duration-300 group-hover:text-white">${group.name}</h3>
                    <p class="text-sm text-gray-500 transition-colors duration-300 group-hover:text-gray-200">${group.user.name}</p>
                    <div class="mt-2 grid grid-cols-3 gap-2 text-xs text-gray-700 transition-colors duration-300 group-hover:text-gray-100">
                        <div class="flex items-center gap-1">
                            <img src="{{ asset('assets/bx-notepad 2.svg') }}" alt="Notes icon" class="w-4 h-4">
                            <span>${note_count} ${ note_count < 2 ? 'Note' : 'Notes' } </span>
                        </div>
                        <div class="flex items-center gap-1">
                            <img src="{{ asset('assets/calender-white.svg') }}" alt="Schedules icon" class="w-4 h-4">
                            <span>${schedule_count} ${ schedule_count< 2 ? 'Schedule' : 'Schedules' }</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <img src="{{ asset('assets/bx-task (1) 2.svg') }}" alt="Tasks icon" class="w-4 h-4">
                            <span>${task_count} ${task_count < 2 ? 'Task' : 'Tasks'}</span>
                        </div>
                    </div>
                    @if ($role != 'teacher')
                    <div class="mt-2">
                        <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                            <div class="bg-yellow-300 h-2 rounded-full transition-all duration-300 group-hover:bg-yellow-400" style="width: 100%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1 transition-colors duration-300 group-hover:text-gray-200">100% Complete</p>
                    </div>
                    @else
                    <div class="flex items-center gap-2 mt-2">
                        <img src="{{ asset('assets/bx-group (1) 3.svg') }}" alt="Student" class="w-4 h-4">
                        <p class="text-sm group-hover:text-white transition-all duration-300">${member_count} ${member_count < 2 ? 'Participant' : 'Participants'}</p>
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
        const keyword = document.getElementById('search').value;

        get_data(`/group/api?keyword=${keyword}&page=${current_page}`, show_data);
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
        api_store('/group/api', formData);
    }

</script>
