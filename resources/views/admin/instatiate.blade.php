<x-layout-admin title="Manage Institutions" role="admin">
    <!-- Main Content -->
    <div class="bg-white p-6 rounded-2xl shadow-md w-full">
        <!-- Header with Search and Add Button -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-4">
            <h2 class="text-lg font-semibold text-gray-800">Institution List</h2>
            <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                <form action="/institutions" method="GET" class="flex-1">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Search by institution name..." 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all duration-300 text-sm"/>
                </form>
                <button 
                    onclick="showModal()" 
                    class="bg-emerald-500 text-white px-4 py-2 rounded-lg hover:bg-emerald-600 transition-all duration-300 text-sm"
                >
                    + Add Institution
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-separate border-spacing-0">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="py-3 px-4 border-b">No</th>
                        <th class="py-3 px-4 border-b">Name Instate</th>
                        <th class="py-3 px-4 border-b">Total Staff</th>
                        <th class="py-3 px-4 border-b">Total Teacher</th>
                        <th class="py-3 px-4 border-b">Total Student</th>
                        <th class="py-3 px-4 border-b">Total All</th>
                        <th class="py-3 px-4 border-b">Created At</th>
                        <th class="py-3 px-4 border-b">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 divide-y">
                    @php
                        $institutions = [
                            ['id' => 1, 'name' => 'SMPN 3 Batam', 'staff' => 10, 'teachers' => 20, 'students' => 300, 'created_at' => '2025-01-10'],
                            ['id' => 2, 'name' => 'SMAN 1 Batam', 'staff' => 15, 'teachers' => 25, 'students' => 400, 'created_at' => '2025-02-15'],
                            ['id' => 3, 'name' => 'SDN Tiban', 'staff' => 8, 'teachers' => 15, 'students' => 200, 'created_at' => '2025-03-01'],
                            ['id' => 4, 'name' => 'SMA Cipta Garden', 'staff' => 12, 'teachers' => 22, 'students' => 350, 'created_at' => '2025-04-05'],
                            ['id' => 5, 'name' => 'SMP Batu Ajo', 'staff' => 9, 'teachers' => 18, 'students' => 250, 'created_at' => '2025-04-10'],
                        ];
                    @endphp
                    @foreach ($institutions as $index => $institution)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4 border-b">{{ $index + 1 }}</td>
                            <td class="py-3 px-4 border-b">{{ $institution['name'] }}</td>
                            <td class="py-3 px-4 border-b">{{ $institution['staff'] }}</td>
                            <td class="py-3 px-4 border-b">{{ $institution['teachers'] }}</td>
                            <td class="py-3 px-4 border-b">{{ $institution['students'] }}</td>
                            <td class="py-3 px-4 border-b">{{ $institution['staff'] + $institution['teachers'] + $institution['students'] }}</td>
                            <td class="py-3 px-4 border-b">{{ $institution['created_at'] }}</td>
                            <td class="py-3 px-4 border-b flex gap-2">
                                <button 
                                    onclick="showEditModal('{{ $institution['id'] }}', '{{ $institution['name'] }}')"
                                    class="text-emerald-500 hover:text-emerald-600"
                                >
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15.828a2 2 0 01-2.828 0l-1.414-1.414a2 2 0 010-2.828L14.586 4.586a2 2 0 012.828 0z"/>
                                    </svg>
                                </button>
                                <button 
                                    onclick="showDeleteModal('{{ $institution['id'] }}', '{{ $institution['name'] }}')"
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

    <!-- Modal for Adding Institution -->
    <div id="addInstitutionModal" class="fixed inset-0 bg-white/50 backdrop-blur-sm slide-down flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Add New Institution</h3>
            <form action="/institutions/store" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Institution Name</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        required 
                        class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all duration-300" 
                        placeholder="Enter institution name..."
                    />
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

    <!-- Modal for Editing Institution -->
    <div id="editInstitutionModal" class="fixed inset-0 bg-white/50 backdrop-blur-sm slide-down flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Edit Institution</h3>
            <form action="/institutions/update" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_institution_id" name="institution_id" />
                <div class="mb-4">
                    <label for="edit_name" class="block text-sm font-medium text-gray-700">Institution Name</label>
                    <input 
                        type="text" 
                        id="edit_name" 
                        name="name" 
                        required 
                        class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all duration-300" 
                        placeholder="Enter institution name..."
                    />
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
    <div id="deleteInstitutionModal" class="fixed inset-0 bg-white/50 backdrop-blur-sm slide-down flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Confirm Delete</h3>
            <p class="text-sm text-gray-600 mb-4">Are you sure you want to delete <span id="delete_institution_name" class="font-semibold"></span>?</p>
            <form action="/institutions/delete" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" id="delete_institution_id" name="institution_id" />
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
            document.getElementById('addInstitutionModal').classList.remove('hidden');
        }

        function showEditModal(id, name) {
            hideAllModals();
            document.getElementById('edit_institution_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('editInstitutionModal').classList.remove('hidden');
        }

        function showDeleteModal(id, name) {
            hideAllModals();
            document.getElementById('delete_institution_id').value = id;
            document.getElementById('delete_institution_name').textContent = name;
            document.getElementById('deleteInstitutionModal').classList.remove('hidden');
        }

        function hideAllModals() {
            document.getElementById('addInstitutionModal').classList.add('hidden');
            document.getElementById('editInstitutionModal').classList.add('hidden');
            document.getElementById('deleteInstitutionModal').classList.add('hidden');
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