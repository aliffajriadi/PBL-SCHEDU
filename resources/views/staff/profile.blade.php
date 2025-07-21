<x-layout-staff title="Instance Profile" role="staff" :user="$user">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-700">Profile</h3>
            <button type="button" onclick="showModalEdit()"
                class="bg-emerald-500 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Profile
            </button>
        </div>

        <!-- Content -->
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Profile Photo Section -->
                <div class="lg:col-span-1">
                    <div class="text-center">
                        <div class="relative inline-block mb-4">

                            @if ($user->logo_instance)
                                <img id="profilePhoto" src="{{ asset('storage/' . $user->logo_instance) }}"
                                    alt="Profile photo of {{ $user->instance_name }}"
                                    class="w-48 h-48 rounded-full object-cover border-4 border-gray-100 shadow-lg transition-transform duration-300 hover:scale-105">
                            @else
                                <div id="profilePhoto"
                                    class="w-48 h-48 rounded-full border-4 border-gray-100 shadow-lg bg-emerald-500 flex items-center justify-center text-white text-6xl font-bold">
                                    {{ strtoupper(substr($user->instance_name, 0, 1) ?? 'U') }}
                                </div>
                            @endif


                        </div>
                        <h4 class="text-xl font-semibold text-gray-600 mb-1">{{ $user->instance_name }}</h4>
                        <p class="text-gray-500 text-sm uppercase tracking-wide">Instance</p>
                    </div>
                </div>

                <!-- Profile Information Section -->
                <div class="lg:col-span-2">
                    <div class="mb-6">
                        <h5 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-4">Instance Information
                        </h5>
                    </div>

                    <dl class="grid grid-cols-1 gap-6">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                            <dd class="text-sm text-gray-900 sm:col-span-2">{{ $user->instance_name }}</dd>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="text-sm text-gray-900 sm:col-span-2">{{ $user->email }}</dd>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-sm font-medium text-gray-500">Phone Number</dt>
                            <dd class="text-sm text-gray-900 sm:col-span-2">{{ $user->phone_no ?? '-' }}</dd>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-sm font-medium text-gray-500">Address</dt>
                            <dd class="text-sm text-gray-900 sm:col-span-2">{{ $user->address ?? '-' }}</dd>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-sm font-medium text-gray-500">Joined</dt>
                            <dd class="text-sm text-gray-900 sm:col-span-2">{{ $user->created_at->format('F j, Y') }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm" id="editProfileModal">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full slide-down max-h-[90vh] overflow-hidden">
                <!-- Edit Profile Form -->
                <form action="/staff/profile/update" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Modal Header -->
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h5 class="text-lg font-semibold text-gray-600">Edit Profile</h5>
                        <button type="button" onclick="hideModalEdit()"
                            class="text-gray-400 hover:text-gray-600 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6 max-h-[70vh] overflow-y-auto">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <!-- Photo Upload Section -->
                            <div class="lg:col-span-1">
                                <div class="text-center">
                                    <div class="mb-4">
                                        <img id="photoPreview"
                                            src="{{ $user->logo_instance ? asset('storage/' . $user->logo_instance) : 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7' }}"
                                            alt="Profile photo of {{ $user->instance_name }}"
                                            class="w-36 h-36 rounded-full object-cover border-4 border-gray-100 shadow-lg transition-transform duration-300 hover:scale-105 mx-auto {{ $user->logo_instance ? '' : 'bg-emerald-500 initial-display' }}"
                                            data-initial="{{ strtoupper(substr($user->instance_name, 0, 1) ?? 'U') }}">
                                    </div>
                                    <div class="space-y-2">
                                        <label for="logo_instance"
                                            class="block text-sm font-medium text-gray-700">Profile Photo</label>
                                        <input type="file"
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            id="logo_instance" name="logo_instance"
                                            accept="image/jpeg,image/png,image/gif">
                                        <p class="text-xs text-gray-500">Format: JPG, PNG, GIF. Max size: 2MB</p>
                                        @error('logo_instance')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Form Fields Section -->
                            <div class="lg:col-span-2 space-y-6">
                                <!-- Instance Name -->
                                <div>
                                    <label for="instance_name" class="block text-sm font-medium text-gray-700 mb-1">
                                        Instance Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('instance_name') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                        id="instance_name" name="instance_name"
                                        value="{{ old('instance_name', $user->instance_name) }}" required>
                                    @error('instance_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('email') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                        id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone
                                        Number</label>
                                    <input type="tel"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('phone') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                        id="phone" name="phone" value="{{ old('phone', $user->phone_no) }}"
                                        placeholder="Example: +1234567890">
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Address -->
                                <div>
                                    <label for="address"
                                        class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                    <textarea
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('address') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                        id="address" name="address" rows="3"
                                        placeholder="Enter your full address">{{ old('address', $user->address) }}</textarea>
                                    @error('address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div
                        class="px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center space-y-3 sm:space-y-0 sm:space-x-3">
                        <button type="button" onclick="showModalPassword()"
                            class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors sm:order-1 order-2 w-full sm:w-auto text-center">
                            Change Password
                        </button>
                        <div class="flex justify-end space-x-3 w-full sm:w-auto order-1 sm:order-2">
                            <button type="button" onclick="hideModalEdit()"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors w-full sm:w-auto">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors flex items-center w-full sm:w-auto">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                Save Profile
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm" id="changePasswordModal">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full slide-down max-h-[90vh] overflow-hidden">
                <form action="/staff/profile/password" id="formPassword" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Modal Header -->
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h5 class="text-lg font-semibold text-gray-600">Change Password</h5>
                        <button type="button" onclick="hideModalPassword()"
                            class="text-gray-400 hover:text-gray-600 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6 space-y-6">
                        <!-- Current Password -->
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current
                                Password <span class="text-red-500">*</span></label>
                            <input type="password"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('current_password') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                id="current_password" name="current_password" required>
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div>
                            <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">New Password
                                <span class="text-red-500">*</span></label>
                            <input type="password"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('new_password') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                id="new_password" name="new_password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$"
                                title="Password must be at least 8 characters, include uppercase, lowercase, number, and special character.">
                            @error('new_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm New Password -->
                        <div>
                            <label for="new_password_confirmation"
                                class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password <span
                                    class="text-red-500">*</span></label>
                            <input type="password"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                id="new_password_confirmation" name="new_password_confirmation" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$"
                                title="Password must be at least 8 characters, include uppercase, lowercase, number, and special character.">
                            @error('new_password_confirmation')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <p id="notifWrongPassword" class="text-sm text-red-600"></p>
                    </div>

                    <!-- Modal Footer -->
                    <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                        <button type="button" onclick="hideModalPassword()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors">
                            Cancel
                        </button>
                        <button type="button" onclick="formPassword()"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- CSS for Initial Display -->
    <style>
        img.initial-display {
            position: relative;
            background-color: #10b981;
            /* Tailwind's emerald-500 */
        }

        img.initial-display::before {
            content: attr(data-initial);
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 3rem;
            /* Default for edit modal */
            font-weight: 600;
            color: white;
            font-family: inherit;
            z-index: 10;
            /* Ensure text is above image */
        }

        img.w-48.initial-display::before {
            font-size: 4rem;
            /* Larger font for profile display */
        }
    </style>

    <!-- JavaScript for Image Preview and Modal Handling -->
    <script>
        function formPassword() {
            const newPass = document.getElementById('new_password').value;
            const newPassConfirmId = document.getElementById('new_password_confirmation');
            const newPassConfirm = newPassConfirmId.value;
            const form = document.getElementById('formPassword');
            if (newPass === newPassConfirm) {
                form.submit();
            } else {
                document.getElementById('notifWrongPassword').innerText = 'Password Not Match';
                newPassConfirmId.value = '';
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const photoInput = document.getElementById('logo_instance');
            const photoPreview = document.getElementById('photoPreview');

            if (photoInput && photoPreview) {
                photoInput.addEventListener('change', function (e) {
                    const file = e.target.files[0];

                    if (file) {
                        // Check file size (2MB = 2097152 bytes)
                        if (file.size > 2097152) {
                            alert('File size exceeds limit. Maximum allowed is 2MB.');
                            photoInput.value = '';
                            return;
                        }

                        // Check file type
                        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                        if (!allowedTypes.includes(file.type)) {
                            alert('Unsupported file format. Please use JPG, PNG, or GIF.');
                            photoInput.value = '';
                            return;
                        }

                        const reader = new FileReader();
                        reader.onload = function (e) {
                            photoPreview.src = e.target.result;
                            photoPreview.alt = 'New profile photo preview';
                            photoPreview.classList.remove('initial-display'); // Remove initial styling
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        });

        function showModalEdit() {
            const modal = document.getElementById('editProfileModal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        function hideModalEdit() {
            const modal = document.getElementById('editProfileModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto'; // Restore background scrolling
        }

        function showModalPassword() {
            const profileModal = document.getElementById('editProfileModal');
            const passwordModal = document.getElementById('changePasswordModal');
            profileModal.classList.add('hidden');
            passwordModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        function hideModalPassword() {
            const modal = document.getElementById('changePasswordModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto'; // Restore background scrolling
        }

        // Close modals when clicking outside
        document.getElementById('editProfileModal').addEventListener('click', function (e) {
            if (e.target === this) {
                hideModalEdit();
            }
        });

        document.getElementById('changePasswordModal').addEventListener('click', function (e) {
            if (e.target === this) {
                hideModalPassword();
            }
        });

        // Close modals with Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                hideModalEdit();
                hideModalPassword();
            }
        });
    </script>
</x-layout-staff>