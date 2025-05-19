<x-layout-staff title="Manage Account" role="staff" :user="$users">
    <!-- Account List Table -->
    <div class="bg-white p-4 md:p-6 rounded-xl shadow-md mb-6 w-full">
        <h2 class="text-lg font-semibold mb-4">Account List</h2>

        <!-- Filter -->
        <div class="mb-4 flex flex-col sm:flex-row gap-3">
            <form action="/staff/account" method="GET" class="flex-1">
                <input type="text" name="search" placeholder="Search accounts..."
                    class="w-full px-4 py-2 border rounded" value="{{ $search ?? '' }}" />
            </form>
            <form action="/staff/account" method="GET">
                <select name="role" class="w-full sm:w-auto px-4 py-2 border rounded" onchange="this.form.submit()">
                    <option value="">All Roles</option>
                    <option value="student">Student</option>
                    <option value="teacher">Teacher</option>
                </select>
            </form>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto -mx-4 sm:mx-0">
            <div class="min-w-full align-middle hidden md:inline-block">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-100 text-gray-600">
                        <tr>
                            <th class="px-3 py-2">No</th>
                            <th class="px-3 py-2">Name</th>
                            <th class="px-3 py-2 hidden md:table-cell">Email</th>
                            <th class="px-3 py-2 hidden sm:table-cell">Gender</th>
                            <th class="px-3 py-2">Role</th>
                            <th class="px-3 py-2 hidden lg:table-cell">Birth Date</th>
                            <th class="px-3 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @if (count($usersInInstance) == 0)
                            <tr>
                                <td colspan="7" class="px-3 py-6 text-center text-gray-500 italic">
                                    No users found in this instance.
                                </td>
                            </tr>
                        @endif

                        @foreach ($usersInInstance as $userInstance)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2">{{ $userInstance->name }}</td>
                                <td class="px-3 py-2 hidden md:table-cell">{{ $userInstance->email }}</td>
                                <td class="px-3 py-2 hidden sm:table-cell">
                                    {{ $userInstance->gender === 'M' ? 'Male' : 'Female' }}</td>
                                <td class="px-3 py-2">{{ $userInstance->is_teacher === 1 ? 'Teacher' : 'Student' }}</td>
                                <td class="px-3 py-2 hidden lg:table-cell">{{ $userInstance->birth_date }}</td>
                                <td class="py-2 px-3 flex gap-2">
                                    <button
                                        onclick="openUpdateModal('{{ $userInstance->uuid }}', '{{ $userInstance->name }}', '{{ $userInstance->email }}', '{{ $userInstance->birth_date }}', '{{ $userInstance->gender }}', '{{ $userInstance->is_teacher === 1 ? '1' : '0' }}')"
                                        class="text-emerald-500 hover:text-emerald-600" aria-label="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.232 5.232l3.536 3.536M9 11l6-6 3 3-6 6H9v-3z" />
                                        </svg>
                                    </button>
                                    <button
                                        onclick="openDeleteModal('{{ $userInstance->uuid }}', '{{ $userInstance->name }}')"
                                        class="text-red-500 hover:text-red-600" aria-label="Delete">
                                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile View Cards (Display on small screens) -->
            <div class="sm:hidden mt-4 px-3 space-y-3">
                @foreach ($usersInInstance as $userInstance)
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="flex justify-between items-center">
                            <span class="font-medium">{{ Str::limit($userInstance->name, 20) }}</span>
                            <span
                                class="bg-gray-200 px-2 py-1 rounded text-xs">{{ $userInstance->is_teacher === 1 ? 'Teacher' : 'Student' }}</span>
                        </div>
                        <div class="text-sm text-gray-600 mt-1">{{ $userInstance->email }}</div>
                        <div class="flex justify-between mt-2">
                            <div class="text-xs text-gray-500">
                                {{ $userInstance->gender === 'M' ? 'Male' : 'Female' }} | {{ $userInstance->birth_date }}
                            </div>
                            <div class="flex gap-2">
                                <button
                                    onclick="openUpdateModal('{{ $userInstance->uuid }}', '{{ $userInstance->name }}', '{{ $userInstance->email }}', '{{ $userInstance->birth_date }}', '{{ $userInstance->gender }}', '{{ $userInstance->is_teacher === 1 ? '1' : '0' }}')"
                                    class="text-emerald-500 hover:text-emerald-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.232 5.232l3.536 3.536M9 11l6-6 3 3-6 6H9v-3z" />
                                    </svg>
                                </button>
                                <button onclick="openDeleteModal('{{ $userInstance->uuid }}', '{{ $userInstance->name }}')"
                                    class="text-red-500 hover:text-red-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $usersInInstance->links() }}
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center hidden z-50 p-4">
        <div class="bg-white p-4 sm:p-6 rounded-xl shadow-md slide-down w-full max-w-md">
            <h2 class="text-lg font-semibold mb-4">Confirm Deletion</h2>
            <p class="mb-4">Are you sure you want to delete <span id="deleteUserName"
                    class="font-medium text-red-400"></span>'s
                account? This action cannot be undone.</p>
            <form id="deleteForm" action="" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex flex-col sm:flex-row sm:justify-end gap-3 mt-6">
                    <button type="button" onclick="closeDeleteModal()"
                        class="w-full sm:w-auto px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 order-2 sm:order-1">Cancel</button>
                    <button type="submit"
                        class="w-full sm:w-auto px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 order-1 sm:order-2">Delete</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Update User Modal -->
    <div id="updateModal"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center hidden z-50 p-4 overflow-y-auto">
        <div class="bg-white p-4 sm:p-6 slide-down rounded-xl shadow-md w-full max-w-4xl slide-up my-8">
            <h2 class="text-lg font-semibold mb-6 text-center">Update User & Password</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Form Update User -->
                <form id="updateForm" action="" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <h3 class="text-md font-semibold mb-2">User Information</h3>
                    <input type="text" name="name" id="updateName" placeholder="Name"
                        class="w-full px-4 py-2 border rounded" required />
                    <input type="email" name="email" id="updateEmail" placeholder="Email"
                        class="w-full px-4 py-2 border rounded" required />
                    <div>
                        <label class="block mb-1">Birth Date</label>
                        <input type="date" name="birth_date" id="updateBirthDate"
                            class="w-full px-4 py-2 border rounded" required />
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <select name="gender" id="updateGender" class="px-4 py-2 border rounded" required>
                            <option value="">Select Gender</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select>

                        <select name="is_teacher" id="updateRole" class="px-4 py-2 border rounded" required>
                            <option value="">Select Role</option>
                            <option value="0">Student</option>
                            <option value="1">Teacher</option>
                        </select>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="w-full sm:w-auto px-4 py-2 bg-emerald-400 text-white rounded hover:bg-emerald-500">Update
                            Info</button>
                    </div>
                </form>

                <!-- Form Update Password -->
                <form id="updatePasswordForm" action="" method="POST"
                    class="space-y-4 pt-6 md:pt-0 border-t md:border-t-0 md:border-l md:pl-6">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="uuidUser" id="UUIDforPassword">
                    <h3 class="text-md font-semibold mb-2">Change Password</h3>
                    <input type="password" name="current_password_instance" id="currentPassword"
                        placeholder="Current Password Instance" class="w-full px-4 py-2 border rounded" required />
                    <input type="password" name="new_password" id="newPassword" placeholder="New Password"
                        class="w-full px-4 py-2 border rounded" required />
                    <input type="password" name="new_password_confirmation" id="confirmPassword"
                        placeholder="Confirm New Password" class="w-full px-4 py-2 border rounded" required />
                    <p id="passwordError" class="text-red-500 text-sm hidden">Passwords do not match</p>
                    <div class="flex justify-end">
                        <button type="button" onclick="formUpdatePassword()"
                            class="w-full sm:w-auto px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Update
                            Password</button>
                    </div>
                </form>
            </div>

            <!-- Close Button -->
            <div class="flex justify-center sm:justify-end mt-6">
                <button type="button" onclick="closeUpdateModal()"
                    class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</button>
            </div>
        </div>
    </div>

    <div class="bg-white p-4 md:p-6 rounded-xl shadow-md">
        <h2 class="text-lg font-semibold mb-4">Create Account</h2>

        @if (session('success'))
            <p id="statusSuccess" class="font-semibold text-white bg-emerald-400 my-2 p-2 rounded">
                {{ session('success') }}
            </p>
            <script>
                setTimeout(() => {
                    const status = document.getElementById('statusSuccess');
                    if (status) {
                        status.style.display = 'none';
                    }
                }, 8000);
            </script>
        @elseif (session('error'))
            <p id="statusError" class="font-semibold text-white bg-red-500 my-2 p-2 rounded">
                {{ session('error') }}
            </p>
            <script>
                setTimeout(() => {
                    const status = document.getElementById('statusError');
                    if (status) {
                        status.style.display = 'none';
                    }
                }, 8000);
            </script>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Form Create Account (2/3 width) -->
            <form action="/staff/user" method="POST" class="space-y-4 lg:col-span-2">
                @csrf
                <input type="text" name="name" placeholder="Name" class="w-full px-4 py-2 border rounded" required />
                <input type="email" name="email" placeholder="Email" class="w-full px-4 py-2 border rounded" required />
                <input type="password" name="password" placeholder="Password" class="w-full px-4 py-2 border rounded"
                    required />
                <div>
                    <label class="block mb-1">Birth Date</label>
                    <input type="date" name="birth_date" class="w-full px-4 py-2 border rounded" required />
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <select name="gender" class="px-4 py-2 border rounded" required>
                        <option value="">Select Gender</option>
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                    </select>
                    <select name="is_teacher" class="px-4 py-2 border rounded" required>
                        <option value="">Select Role</option>
                        <option value="student">Student</option>
                        <option value="teacher">Teacher</option>
                    </select>
                </div>
                <button type="submit"
                    class="w-full sm:w-auto bg-emerald-400 text-white px-6 py-2 rounded hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    Create Account
                </button>
            </form>

            <!-- Upload Box (1/3 width) -->
            <div
                class="border-dashed border-2 border-gray-300 rounded-xl flex flex-col items-center justify-center text-center p-4 min-h-48">
                <span class="material-icons text-4xl text-gray-400">upload_file</span>
                <p class="text-sm text-gray-500 my-2">Drag and Drop file <br><span
                        class="text-emerald-600 font-medium">or</span></p>
                <button
                    class="mt-2 px-4 py-1 border border-emerald-600 text-emerald-600 rounded hover:bg-emerald-100 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    Browse
                </button>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModal(uuid, name) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            const userName = document.getElementById('deleteUserName');
            form.action = `/staff/user/${uuid}`;
            userName.textContent = name;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function openUpdateModal(uuid, name, email, birth_date, gender, role) {
            const modal = document.getElementById('updateModal');
            const form = document.getElementById('updateForm');
            const passwordForm = document.getElementById('updatePasswordForm');
            form.action = `/staff/user/${uuid}`;
            passwordForm.action = `/staff/userpassword`;
            document.getElementById('updateName').value = name;
            document.getElementById('updateEmail').value = email;
            document.getElementById('updateBirthDate').value = birth_date;
            document.getElementById('updateGender').value = gender;
            document.getElementById('updateRole').value = role;
            document.getElementById('UUIDforPassword').value = uuid;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeUpdateModal() {
            const modal = document.getElementById('updateModal');
            const errorMessage = document.getElementById('passwordError');
            errorMessage.classList.add('hidden');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function formUpdatePassword() {
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const errorMessage = document.getElementById('passwordError');
            const form = document.getElementById('updatePasswordForm');

            if (!form.reportValidity()) {
                return;
            }
            if (newPassword === confirmPassword) {
                errorMessage.classList.add('hidden');
                form.submit();
            } else {
                errorMessage.textContent = 'Passwords do not match';
                errorMessage.classList.remove('hidden');
            }
        }

        // Close modals when clicking outside
        window.addEventListener('click', function (event) {
            const deleteModal = document.getElementById('deleteModal');
            const updateModal = document.getElementById('updateModal');

            if (event.target === deleteModal) {
                closeDeleteModal();
            }
            if (event.target === updateModal) {
                closeUpdateModal();
            }
        });
    </script>
</x-layout-staff>