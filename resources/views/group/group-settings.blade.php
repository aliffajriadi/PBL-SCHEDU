@php
    $current_url = url()->current();

    $readonly = $role === 'student' ? 'readonly' : '';
@endphp


<x-layout role="{{ $role }}" title="Group Settings" :user="$user" :image="$userData->profile_pic !== null ? asset('storage/' . $userData->instance->folder_name . '/' . $userData->profile_pic) : 'image/Ryan-Gosling.jpg'">
    <x-nav-group type="name" page="settings" group_name="{{ $group_name }}"></x-nav-group>

    <!-- Konten Utama -->
    <section class="mt-3 space-y-6">
        <!-- Card untuk Murid (Daftar Anggota) -->
        <div class="bg-white shadow-md rounded-2xl p-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">List Member Group</h2>
            </div>
            <!-- Tabel untuk Desktop -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Name</th>
                            <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Email</th>
                            <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Join at</th>

                            @if($role === 'teacher')
                                <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if($role === 'teacher')
                            @foreach($members as $member)
                                <tr class="border-t">
                                    <td class="py-2 px-4 text-sm text-gray-700">{{ $member->user->name }}</td>
                                    <td class="py-2 px-4 text-sm text-gray-700">{{ $member->user->email }}</td>
                                    <td class="py-2 px-4 text-sm text-gray-700">{{ $member->updated_at }}</td>
                                    <td class="py-2 px-4 text-sm">
                                        <button onclick="openKickModal({{ $member->id }}, '{{ $member->user->name }}')"
                                            class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition">
                                            Kick
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            @foreach($members as $member)
                                <tr class="border-t">
                                    <td class="py-2 px-4 text-sm text-gray-700">{{ $member->user->name }}</td>
                                    <td class="py-2 px-4 text-sm text-gray-700">{{ $member->user->email }}</td>
                                    <td class="py-2 px-4 text-sm text-gray-700">{{ $member->updated_at }}</td>
                                </tr>
                            @endforeach
                        @endif
                        
                    </tbody>
                </table>
            </div>
            <!-- Card untuk Mobile -->
            <div class="md:hidden flex flex-col gap-3">

                @if($role === 'teacher')
                    @foreach($members as $member)
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                            <p class="text-sm font-medium text-gray-800">{{ $member->user->name }}</p>
                            <p class="text-sm text-gray-600">{{ $member->user->email }}</p>
                            <p class="text-sm text-gray-500">Bergabung: {{ $member->updated_at }}</p>
                            <button onclick="openKickModal({{ $member->id }}, '{{ $member->user->name }}')"
                                class="mt-2 bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition">
                                Kick
                            </button>
                        </div>
                    @endforeach
                @else
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                            <p class="text-sm font-medium text-gray-800">{{ $member->user->name }}</p>
                            <p class="text-sm text-gray-600">{{ $member->user->email }}</p>
                            <p class="text-sm text-gray-500">Joined: {{ $member->updated_at }}</p>
                        </div>
                @endif
            </div>
        </div>


        @if($role === 'teacher')
        <!-- Card untuk Approve Student -->
        <div class="bg-white shadow-md rounded-2xl p-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Join Request</h2>
            </div>
            <!-- Tabel untuk Desktop -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Name</th>
                            <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Email</th>
                            <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Request at</th>
                            <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($pending_requests as $request)
                            <tr class="border-t">
                                <td class="py-2 px-4 text-sm text-gray-700">{{ $request->user->name }}</td>
                                <td class="py-2 px-4 text-sm text-gray-700">{{ $request->user->email }}</td>
                                <td class="py-2 px-4 text-sm text-gray-700">{{ $request->created_at }}</td>
                                <td class="py-2 px-4 text-sm flex gap-2">
                                    <form action="{{ $current_url }}/approve/{{ $request->id }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="bg-emerald-400 text-white px-3 py-1 rounded-lg hover:bg-emerald-500 transition">
                                            Approve
                                        </button>
                                    </form>
                                    <button onclick="openRejectModal({{ $request->id }}, '{{ $request->user->name }}')"
                                        class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition">
                                        Reject
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Card untuk Mobile -->
            <div class="md:hidden flex flex-col gap-3">
                @foreach($pending_requests as $request)
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                        <p class="text-sm font-medium text-gray-800">{{ $request->user->name }}</p>
                        <p class="text-sm text-gray-600">{{ $request->user->email }}</p>
                        <p class="text-sm text-gray-500">Permintaan: {{ $request->created_at }}</p>
                        <div class="mt-2 flex gap-2">
                            <form action="{{ $current_url }}/approve/{{ $request->id }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="bg-emerald-400 text-white px-3 py-1 rounded-lg hover:bg-emerald-500 transition">
                                    Approve
                                </button>
                            </form>
                            <button onclick="openRejectModal({{ $request->id }}, '{{ $request->user->name }}')"
                                class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition">
                                Reject
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="bg-white shadow-md rounded-2xl p-4">

        <form method="POST" enctype="multipart/form-data" action="/group/{{ $group->group_code }}/update">
            @csrf
            @method('PATCH')

            <div class="space-y-12">

                <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base/7 font-semibold text-gray-900">Group Information</h2>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                    <div class="sm:col-span-2 ">
                    <label for="name" class="block text-sm/6 font-medium text-gray-900">Group Name</label>
                    <div class="mt-2">
                        <input type="text" name="name" id="name" value="{{ $group->name }}" autocomplete="address-level2" {{ $readonly }} class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                    </div>
                    </div>

                    <div class="sm:col-span-2">
                    <label for="instance_name" class="block text-sm/6 font-medium text-gray-900">Intance Name</label>
                    <div class="mt-2">
                        <input type="text" id="instance_name" value="{{ $group->instance->instance_name }}" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                    </div>
                    </div>
                    <br>

                    @if($role === 'teacher')

                    <div class="sm:col-span-2">
                    <label for="pic" class="block text-sm/6 font-medium text-gray-900"> Group Pic</label>
                    <div class="mt-2">
                        <input type="file" id="pic" name="pic" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                    </div>
                    </div>

                    @endif
                    

            

                <div class="sm:col-span-2">
                    <label for="group_code" class="block text-sm/6 font-medium text-gray-900">Group Code</label>
                    <div class="mt-2 relative flex items-center">
                        <input type="text" id="group_code" value="{{ $group->group_code }}" readonly
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />

                        <!-- Tombol copy -->
                        <div class="relative">
                            <button type="button" onclick="copyGroupCode()"
                                class="ml-2 text-gray-500 hover:text-indigo-600 focus:outline-none">
                                <!-- SVG Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 16h8a2 2 0 002-2V8m-4 12H6a2 2 0 01-2-2V8a2 2 0 012-2h6m2-2h6m-6 0v6" />
                                </svg>
                            </button>

                            <!-- Popover -->
                            <div id="copyPopover"
                                class="absolute -top-8 right-0 bg-gray-900 text-white text-xs rounded px-2 py-1 opacity-0 transition-opacity duration-300 pointer-events-none">
                                Copied!
                            </div>
                        </div>
                    </div>
                </div>



                </div>
                </div>

              
            </div>

            <div class="mt-6 flex items-center gap-x-6">

                <div class="relative inline-block">
                    <button type="button" onclick="create_join_link()" class="rounded-md bg-emerald-400 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-emerald-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-400">Create Join Link</button>
                    <div id="create_popover"
                        class="absolute -top-8 right-0 bg-gray-900 text-white text-xs rounded px-2 py-1 opacity-0 transition-opacity duration-300 pointer-events-none">Copied!</div>
                </div>

                @if($role === 'teacher')
                    <button type="submit" class="rounded-md bg-emerald-400 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-emerald-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-400">Update</button>
                @endif

            </div>
            </form>
        </div>

        @if($role === 'teacher')

        <!-- Custom Section dengan Tombol Hapus -->
        <div class="bg-white shadow-md rounded-2xl p-4">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Delete Preferences</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <button onclick="openDeleteConfirmModal('notes')"
    class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
    Delete All Notes
</button>
<button onclick="openDeleteConfirmModal('tasks')"
    class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
    Delete All Tasks
</button>
<button onclick="openDeleteConfirmModal('schedules')"
    class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
    Delete All Schedules
</button>
<button onclick="openDeleteConfirmModal('members')"
    class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
    Remove All Members
</button>
<button onclick="openDeleteConfirmModal('pending')"
    class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
    Delete All Join Requests
</button>
<button onclick="openDeleteConfirmModal('group')"
    class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
    Delete This Group
</button>

            </div>
        </div>
        @endif
    </section>

    @if($role === 'teacher')
    <!-- Modal Konfirmasi Kick -->
    <div id="kick-modal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Confirm Member Removal</h3>
            <p class="text-gray-600 mb-6">
                Are you sure you want to remove "<span id="kick-student-name"></span>" from the group?
                This action cannot be undone.
            </p>
            <form id="kick-student-form" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-4">
                    <button type="button" onclick="closeKickModal()"
                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                        Remove
                    </button>
                </div>
            </form>
        </div>
    </div>
    

    <!-- Modal Konfirmasi Reject -->
    <div id="reject-modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Confirm Join Request Rejection</h3>
            <p class="text-gray-600 mb-6">
                Are you sure you want to reject the join request from "<span id="reject-student-name"></span>"?
                This action cannot be undone.
            </p>
            <form id="reject-student-form" action="" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-4">
                    <button type="button" onclick="closeRejectModal()"
                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                        Reject
                    </button>
                </div>
            </form>
        </div>
    </div>
    

    <!-- Modal Konfirmasi Penghapusan Massal -->
    <div id="delete-confirm-modal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4" id="delete-confirm-title"></h3>
            <p class="text-gray-600 mb-6" id="delete-confirm-message"></p>
            <form id="delete-confirm-form" action="" method="POST">
                @csrf
                @method('DELETE')

                    <div class="sm:col-span-2">
         
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('password') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                            id="password" name="password" required placeholder="isi password untuk mengkonfirmasi">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                    </div>

                    <br>

                <div class="flex justify-between gap-4">
                
                    <button type="button" onclick="closeDeleteConfirmModal()"
                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                        Delete
                    </button>
                </div>
            </form>
        </div>
    </div>

    @endif

    <x-success></x-success>

    <!-- JavaScript untuk Modal -->
    <script>
        const path = window.location.pathname;

        document.addEventListener('DOMContentLoaded', function () {
            // Fungsi Modal Kick
            window.openKickModal = function(id, name) {
                const modal = document.getElementById('kick-modal');
                const nameSpan = document.getElementById('kick-student-name');
                const form = document.getElementById('kick-student-form');
                nameSpan.textContent = name;
                form.action = `{{ $current_url }}/out/${id}`;
                
                modal.classList.remove('hidden');
            };

            window.closeKickModal = function() {
                const modal = document.getElementById('kick-modal');
                modal.classList.add('hidden');
            };

            // Fungsi Modal Reject
            window.openRejectModal = function(id, name) {
                const modal = document.getElementById('reject-modal');
                const nameSpan = document.getElementById('reject-student-name');
                const form = document.getElementById('reject-student-form');
                nameSpan.textContent = name;
                form.action = `{{ $current_url }}/out/${id}`;
                modal.classList.remove('hidden');
            };

            window.closeRejectModal = function() {
                const modal = document.getElementById('reject-modal');
                modal.classList.add('hidden');
            };

            // Fungsi Modal Konfirmasi Penghapusan Massal
            window.openDeleteConfirmModal = function(type) {
                const modal = document.getElementById('delete-confirm-modal');
                const title = document.getElementById('delete-confirm-title');
                const message = document.getElementById('delete-confirm-message');
                const form = document.getElementById('delete-confirm-form');

                let titleText = '';
                let messageText = '';
                let actionUrl = '';

                switch(type) {
                    
    case 'notes':
        titleText = 'Delete All Notes';
        messageText = 'Are you sure you want to delete all notes? This action cannot be undone.';
        actionUrl = '{{ $current_url }}/delete_all/notes';
        break;
    case 'tasks':
        titleText = 'Delete All Tasks';
        messageText = 'Are you sure you want to delete all tasks? This action cannot be undone.';
        actionUrl = '{{ $current_url }}/delete_all/tasks';
        break;
    case 'schedules':
        titleText = 'Delete All Schedules';
        messageText = 'Are you sure you want to delete all schedules? This action cannot be undone.';
        actionUrl = '{{ $current_url }}/delete_all/schedules';
        break;
    case 'members':
        titleText = 'Remove All Members';
        messageText = 'Are you sure you want to remove all members from the group? This action cannot be undone.';
        actionUrl = '{{ $current_url }}/delete_all/members';
        break;
    case 'pending':
        titleText = 'Delete All Join Requests';
        messageText = 'Are you sure you want to delete all pending join requests? This action cannot be undone.';
        actionUrl = '{{ $current_url }}/delete_all/pending';
        break;
    case 'group':
        titleText = 'Delete Group';
        messageText = 'Are you sure you want to delete this group? All related data will be permanently removed and this action cannot be undone.';
        actionUrl = '{{ $current_url }}/delete';
        break;


                }

                title.textContent = titleText;
                message.textContent = messageText;
                form.action = actionUrl;
                modal.classList.remove('hidden');
            };

            window.closeDeleteConfirmModal = function() {
                const modal = document.getElementById('delete-confirm-modal');
                modal.classList.add('hidden');
            };
        });

        function copyGroupCode() {
        
            const input = document.getElementById('group_code');
            const popover = document.getElementById('copyPopover');

            const hostname = window.location.hostname;
            const port = window.location.port;

            navigator.clipboard.writeText(input.value)
                .then(() => {
                    // Tampilkan popover
                    popover.classList.remove('opacity-0');
                    popover.classList.add('opacity-100');

                    // Sembunyikan popover setelah 2 detik
                    setTimeout(() => {
                        popover.classList.remove('opacity-100');
                        popover.classList.add('opacity-0');
                    }, 2000);
                })
                .catch(() => {
                    alert('Gagal menyalin');
                });
        }

        function create_join_link() {
            console.log('a');

        
            const input = document.getElementById('group_code');
            const popover = document.getElementById('create_popover');

            const hostname = window.location.host;
            const port = window.location.port;

            navigator.clipboard.writeText(`${hostname}/join_group/${input.value}`)
                .then(() => {
                    // Tampilkan popover
                    popover.classList.remove('opacity-0');
                    popover.classList.add('opacity-100');

                    // Sembunyikan popover setelah 2 detik
                    setTimeout(() => {
                        popover.classList.remove('opacity-100');
                        popover.classList.add('opacity-0');
                    }, 2000);
                })
                .catch(() => {
                    alert('Gagal menyalin');
                });

            console.log('a');

        }

        @if(session('success'))
            open_success(session('success'));
        @elseif(session('error'))
            open_fail(session('error'));
        @endif

    </script>
</x-layout>