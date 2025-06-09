<x-layout-admin title="Manage Staff" role="admin">
    <!-- Main Content -->
    <div class="bg-white p-6 rounded-2xl shadow-md w-full">
        <!-- Header with Search and Add Button -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-4">
            <h2 class="text-lg font-semibold text-gray-800">Staff List</h2>
            <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                <form action="/staff" method="GET" class="flex-1">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Search by name, email, or institution..." 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all duration-300 text-sm"
                    />
                </form>
                <button 
                    onclick="showModal()" 
                    class="bg-emerald-500 text-white px-4 py-2 rounded-lg hover:bg-emerald-600 transition-all duration-300 text-sm"
                >
                    + Add Staff
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-separate border-spacing-0">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="py-3 px-4 border-b">No</th>
                        <th class="py-3 px-4 border-b">Name</th>
                        <th class="py-3 px-4 border-b">Email</th>
                        <th class="py-3 px-4 border-b">Asal Instansi</th>
                        <th class="py-3 px-4 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 divide-y">
                    @php
                        $institutions = [
                            1 => 'SMPN 3 Batam',
                            2 => 'SMAN 1 Batam',
                            3 => 'SDN Tiban',
                            4 => 'SMA Cipta Garden',
                            5 => 'SMP Batu Ajo',
                        ];
                        $staff = [
                            ['id' => 1, 'name' => 'John Doe', 'email' => 'john.doe@example.com', 'institution_id' => 1],
                            ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane.smith@example.com', 'institution_id' => 2],
                            ['id' => 3, 'name' => 'Michael Tan', 'email' => 'michael.tan@example.com', 'institution_id' => 3],
                            ['id' => 4, 'name' => 'Sarah Lee', 'email' => 'sarah.lee@example.com', 'institution_id' => 4],
                            ['id' => 5, 'name' => 'David Wong', 'email' => 'david.wong@example.com', 'institution_id' => 5],
                        ];
                    @endphp
                    @foreach ($staff as $index => $admin)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4 border-b">{{ $index + 1 }}</td>
                            <td class="py-3 px-4 border-b">{{ $admin['name'] }}</td>
                            <td class="py-3 px-4 border-b">{{ $admin['email'] }}</td>
                            <td class="py-3 px-4 border-b">{{ $institutions[$admin['institution_id']] }}</td>
                            <td class="py-3 px-4 border-b flex gap-2">
                                <button 
                                    onclick="showEditModal('{{ $admin['id'] }}', '{{ $admin['name'] }}', '{{ $admin['email'] }}', '{{ $admin['institution_id'] }}')"
                                    class="text-emerald-500 hover:text-emerald-600"
                                >
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15.828a2 2 0 01-2.828 0l-1.414-1.414a2 2 0 010-2.828L14.586 4.586a2 2 0 012.828 0z"/>
                                    </svg>
                                </button>
                                <button 
                                    onclick="showDeleteModal('{{ $admin['id'] }}', '{{ $admin['name'] }}')"
                                    class="text-red-500 hover:text-red-600"
                                >
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Adding Staff -->
    <div id="addStaffModal" class="fixed inset-0 bg-white/50 backdrop-blur-sm slide-down flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Add New Staff</h3>
            <form action="/staff/store" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        required 
                        class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all duration-300" 
                        placeholder="Enter name..."
                    />
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required 
                        class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all duration-300" 
                        placeholder="Enter email..."
                    />
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required 
                        class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all duration-300" 
                        placeholder="Enter password..."
                    />
                </div>
                <div class="mb-4">
                    <label for="institution_id" class="block text-sm font-medium text-gray-700">Asal Instansi</label>
                    <select 
                        id="institution_id" 
                        name="institution_id" 
                        required 
                        class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all duration-300"
                    >

                    
                        @foreach ($institutions as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach


                    </select>
                </div>
                <div class="flex justify-end gap-2">
                    <button 
                        type="button" 
                        onclick="hideAllModals()" 
                        class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition-all duration-300 text-sm"
                    >
                        Cancel
                    </button>
                    <button 
                        type="submit" 
                        class="bg-emerald-500 text-white px-4 py-2 rounded-lg hover:bg-emerald-600 transition-all duration-300 text-sm"
                    >
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Editing Staff -->
    <div id="editStaffModal" class="fixed inset-0 bg-white/50 backdrop-blur-sm slide-down flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Edit Staff</h3>
            <form action="/staff/update" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_staff_id" name="staff_id" />
                <div class="mb-4">
                    <label for="edit_name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input 
                        type="text" 
                        id="edit_name" 
                        name="name" 
                        required 
                        class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all duration-300" 
                        placeholder="Enter name..."
                    />
                </div>
                <div class="mb-4">
                    <label for="edit_email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input 
                        type="email" 
                        id="edit_email" 
                        name="email" 
                        required 
                        class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all duration-300" 
                        placeholder="Enter email..."
                    />
                </div>
                <div class="mb-4">
                    <label for="edit_password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input 
                        type="password" 
                        id="edit_password" 
                        name="password" 
                        class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all duration-300" 
                        placeholder="Enter new password (optional)..."
                    />
                </div>
                <div class="mb-4">
                    <label for="edit_institution_id" class="block text-sm font-medium text-gray-700">Asal Instansi</label>
                    <select 
                        id="edit_institution_id" 
                        name="institution_id" 
                        required 
                        class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all duration-300"
                    >
                        @foreach ($institutions as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end gap-2">
                    <button 
                        type="button" 
                        onclick="hideAllModals()" 
                        class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition-all duration-300 text-sm"
                    >
                        Cancel
                    </button>
                    <button 
                        type="submit" 
                        class="bg-emerald-500 text-white px-4 py-2 rounded-lg hover:bg-emerald-600 transition-all duration-300 text-sm"
                    >
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Delete Confirmation -->
    <div id="deleteStaffModal" class="fixed inset-0 bg-white/50 backdrop-blur-sm slide-down flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Confirm Delete</h3>
            <p class="text-sm text-gray-600 mb-4">Are you sure you want to delete <span id="delete_staff_name" class="font-semibold"></span>?</p>
            <form action="/staff/delete" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" id="delete_staff_id" name="staff_id" />
                <div class="flex justify-end gap-2">
                    <button 
                        type="button" 
                        onclick="hideAllModals()" 
                        class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition-all duration-300 text-sm"
                    >
                        Cancel
                    </button>
                    <button 
                        type="submit" 
                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-all duration-300 text-sm"
                    >
                        Delete
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript for Modals -->
    <script>
        function showModal() {
            hideAllModals();
            document.getElementById('addStaffModal').classList.remove('hidden');
        }

        function showEditModal(id, name, email, institution_id) {
            hideAllModals();
            document.getElementById('edit_staff_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_institution_id').value = institution_id;
            document.getElementById('editStaffModal').classList.remove('hidden');
        }

        function showDeleteModal(id, name) {
            hideAllModals();
            document.getElementById('delete_staff_id').value = id;
            document.getElementById('delete_staff_name').textContent = name;
            document.getElementById('deleteStaffModal').classList.remove('hidden');
        }

        function hideAllModals() {
            document.getElementById('addStaffModal').classList.add('hidden');
            document.getElementById('editStaffModal').classList.add('hidden');
            document.getElementById('deleteStaffModal').classList.add('hidden');
        }
    </script>

    <!-- Custom Animation -->
    <style>
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .slide-down {
            animation: slideDown 0.3s ease-out forwards;
        }
    </style>
</x-layout-admin>