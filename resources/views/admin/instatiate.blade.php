<x-layout-admin title="Manage Institutions" role="admin" :user="$user">
    <!-- Main Content -->
    <div class="bg-white p-6 rounded-2xl shadow-md w-full">
        <!-- Header with Search and Add Button -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
            <h2 class="text-lg font-semibold text-gray-800">Institution List</h2>
            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                <form action="" method="GET" class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by institution name..."
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all duration-300 text-sm" />
                </form>
                <button onclick="showModal()"
                    class="bg-emerald-500 text-white px-4 py-2 rounded-lg hover:bg-emerald-600 transition-all duration-300 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Institution
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead class="bg-emerald-50 text-gray-700">
                    <tr>
                        <th class="py-3 px-4 border-b border-gray-200 font-semibold">No</th>
                        <th class="py-3 px-4 border-b border-gray-200 font-semibold">Institution Name</th>
                        <th class="py-3 px-4 border-b border-gray-200 font-semibold">Email</th>
                        <th class="py-3 px-4 border-b border-gray-200 font-semibold">Address</th>
                        <th class="py-3 px-4 border-b border-gray-200 font-semibold">Phone No</th>
                        <th class="py-3 px-4 border-b border-gray-200 font-semibold">Created At</th>
                        <th class="py-3 px-4 border-b border-gray-200 font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 divide-y">
                    @forelse ($institutions as $index => $institution)
                        <tr class="hover:bg-emerald-50 transition-colors">
                            <td class="py-3 px-4 border-b">
                                {{ $index + 1 + ($institutions->currentPage() - 1) * $institutions->perPage() }}
                            </td>
                            <td class="py-3 px-4 border-b">{{ $institution->instance_name }}</td>
                            <td class="py-3 px-4 border-b">{{ Str::limit($institution->email, 15) }}</td>
                            <td class="py-3 px-4 border-b">{{ Str::limit($institution->address, 15) }}</td>
                            <td class="py-3 px-4 border-b">{{ Str::limit($institution->phone_no, 15) }}</td>
                            <td class="py-3 px-4 border-b">{{ $institution->created_at->format('Y-m-d') }}</td>
                            <td class="py-3 px-4 border-b flex gap-2">
                                <button
                                    onclick="showEditModal('{{ $institution->uuid }}', '{{ $institution->instance_name }}', '{{ $institution->email }}', '{{ $institution->address }}', '{{ $institution->phone_no }}')"
                                    class="text-emerald-500 hover:text-emerald-600" title="Edit institution">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15.828a2 2 0 01-2.828 0l-1.414-1.414a2 2 0 010-2.828L14.586 4.586a2 2 0 012.828 0z" />
                                    </svg>
                                </button>
                                <button
                                    onclick="showDeleteModal('{{ $institution->uuid }}', '{{ $institution->instance_name }}')"
                                    class="text-red-500 hover:text-red-600" title="Delete institution">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-3 px-4 text-center text-gray-500">No institutions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="mt-4 flex justify-end">
                {{ $institutions->appends(['search' => request('search')])->links() }}
            </div>
        </div>
    </div>

    <!-- Modal for Adding Institution -->
    <div id="addInstitutionModal" class="fixed inset-0 bg-gray-900/50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-2xl animate-slide-down">
            <h3 class="text-xl font-semibold text-gray-800 mb-6">Add New Institution</h3>
            <form action="{{ route('store-instantiate') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Kolom Kiri -->
                    <div>
                        <div class="mb-4">
                            <label for="email" class="block text-xs font-medium text-gray-700">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="mt-1 w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all duration-300 text-sm"
                                placeholder="Enter institution email" aria-describedby="email-error" />
                            @error('email')
                                <p id="email-error" class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="instance_name" class="block text-xs font-medium text-gray-700">Institution
                                Name</label>
                            <input type="text" id="instance_name" name="instance_name"
                                value="{{ old('instance_name') }}" required
                                class="mt-1 w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all duration-300 text-sm"
                                placeholder="Enter institution name" aria-describedby="instance_name-error" />
                            @error('instance_name')
                                <p id="instance_name-error" class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="phone_no" class="block text-xs font-medium text-gray-700">Phone No</label>
                            <input type="tel" id="phone_no" name="phone_no" value="{{ old('phone_no') }}" required
                                class="mt-1 w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all duration-300 text-sm"
                                placeholder="Enter phone number" aria-describedby="phone_no-error" />
                            @error('phone_no')
                                <p id="phone_no-error" class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <!-- Kolom Kanan -->
                    <div>
                        <div class="mb-4">
                            <label for="address" class="block text-xs font-medium text-gray-700">Address</label>
                            <input type="text" id="address" name="address" value="{{ old('address') }}" required
                                class="mt-1 w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all duration-300 text-sm"
                                placeholder="Enter institution address" aria-describedby="address-error" />
                            @error('address')
                                <p id="address-error" class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="password" class="block text-xs font-medium text-gray-700">Password</label>
                            <input type="password" id="password" name="password" required
                                class="mt-1 w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all duration-300 text-sm"
                                placeholder="Enter institution password" aria-describedby="password-error" />
                            @error('password')
                                <p id="password-error" class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- Tombol -->
                <div class="flex justify-end gap-2 mt-6">
                    <button type="button" onclick="hideAllModals()"
                        class="w-full sm:w-auto px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-all duration-300 text-sm">
                        Cancel
                    </button>
                    <button type="submit"
                        class="w-full sm:w-auto px-4 py-2 bg-emerald-500 text-white rounded-md hover:bg-emerald-600 transition-all duration-300 text-sm">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-down {
            animation: slideDown 0.3s ease-out forwards;
        }
    </style>

    <!-- Modal for Editing Institution -->
    <div id="editInstitutionModal" class="fixed inset-0 bg-gray-900/50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md animate-slide-down">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Edit Institution</h3>
            <form action="" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" id="edit_institution_id" name="institution_id" />
                <div class="mb-4">
                    <label for="edit_email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="edit_email" name="email" required
                        class="mt-1 w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all duration-300"
                        placeholder="Enter institution email" />
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="edit_instance_name" class="block text-sm font-medium text-gray-700">Institution
                        Name</label>
                    party <input type="text" id="edit_instance_name" name="instance_name" required
                        class="mt-1 w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all duration-300"
                        placeholder="Enter institution name" />
                    @error('instance_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="edit_phone_no" class="block text-sm font-medium text-gray-700">Phone No</label>
                    <input type="tel" id="edit_phone_no" name="phone_no" required
                        class="mt-1 w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all duration-300"
                        placeholder="Enter phone number" />
                    @error('phone_no')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="edit_address" class="block text-sm font-medium text-gray-700">Address</label>
                    <input type="text" id="edit_address" name="address" required
                        class="mt-1 w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all duration-300"
                        placeholder="Enter institution address" />
                    @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="hideAllModals()"
                        class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition-all duration-300 text-sm">
                        Cancel
                    </button>
                    <button type="submit"
                        class="bg-emerald-500 text-white px-4 py-2 rounded-lg hover:bg-emerald-600 transition-all duration-300 text-sm">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Deleting Institution -->
    <div id="deleteInstitutionModal" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md animate-slide-down">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Delete Institution</h3>
            <p class="text-sm text-gray-600 mb-6">
                Are you sure you want to delete <span id="deleteInstitutionName"
                    class="font-semibold text-red-500"></span>?
                This action cannot be undone.
            </p>
            <form id="deleteInstitutionForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="hideAllModals()"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 text-sm">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 text-sm">
                        Yes, Delete
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

        function showEditModal(id, name, email, address, phone_no) {
            hideAllModals();
            document.getElementById('edit_institution_id').value = id;
            document.getElementById('edit_instance_name').value = name;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_address').value = address;
            document.getElementById('edit_phone_no').value = phone_no;
            document.getElementById('editInstitutionModal').classList.remove('hidden');
        }

        function showDeleteModal(id, name) {
            const form = document.getElementById('deleteInstitutionForm');
            const nameSpan = document.getElementById('deleteInstitutionName');

            form.action = `/admin/staffs/${id}`; // sesuaikan dengan rute destroy di routes/web.php
            nameSpan.textContent = name;

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
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-down {
            animation: slideDown 0.3s ease-out forwards;
        }
    </style>
</x-layout-admin>