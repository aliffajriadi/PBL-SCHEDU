<x-layout title="Profile" role="student" :user="$user_data" :image="$userData->profile_pic !== null ? asset('storage/' . $userData->instance->folder_name . '/' . $userData->profile_pic) : 'image/Ryan-Gosling.jpg'">

    {{-- @dd($user) --}}

    <!-- start here! -->
    <main class="flex-1 flex md:mt-0 flex-col text-emerald-800 w-full">
        <div class="max-w-3xl w-full md:max-w-full">
            <div class="bg-white p-6 rounded-xl shadow-md flex flex-col sm:flex-row items-center gap-4 w-full">
                <img src="{{  $user->profile_pic != null ? asset('storage/' . $user->instance->folder_name . '/' . $user->profile_pic) : 'image/Ryan-Gosling.jpg'}}" class="w-16 h-16 rounded-full object-cover border-2 border-emerald-500" alt="Profile Picture">
                <div class="flex-1 text-center sm:text-left">
                    <h2 class="text-lg font-semibold">{{ $user->name ?? 'Ryan Gosling' }}</h2>
                    <p class="text-gray-500">{{ $user->is_teacher ? 'teacher' : 'student' }}</p>
                </div>
                <button onclick="toggle_edit_profile()" class="bg-green-500 text-white flex gap-2 px-4 py-2 rounded-lg hover:bg-green-600"><img src="assets/edit.svg" alt="icon edit"> <span>Edit profile</span></button>
            </div>

            <div class="bg-white p-6 mt-4 rounded-xl shadow-md w-full">
                <h3 class="text-lg mb-4">Personal Information</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-700 w-full">
                    {{-- <div>
                        <p class="font-semibold opacity-70">Reg No.</p>
                        <p>33124001007</p>
                    </div> --}}
                    <div>
                        <p class="font-semibold opacity-70">Name</p>
                        <p>{{ $user->name }}</p>
                    </div>
                    <div>
                        <p class="font-semibold opacity-70">School</p>
                        <p>{{ $user->instance->instance_name }}</p>
                    </div>
                    <div>
                        <p class="font-semibold opacity-70">Gender</p>
                        <p>{{ $user->gender === 'M' ? 'Male' : 'Female' }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="font-semibold opacity-70">Address</p>
                        <p>Batam, Batam Centre, Polytechnic State, GU 702</p>
                    </div>
                    <div>
                        <p class="font-semibold opacity-70">Birth Date</p>
                        <p>{{ $user->birth_date }}</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm" id="editProfileModal">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full slide-down max-h-[90vh] overflow-hidden">
                <!-- Edit Profile Form -->
                <form action="/profile/update" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <!-- Modal Header -->
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h5 class="text-lg font-semibold text-gray-600">Edit Profile</h5>
                        <button type="button" onclick="toggle_edit_profile()"
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
                                            src="{{ $user->profile_pic ? asset('storage/' . $user->instance->folder_name . '/' . $user->profile_pic) : 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7' }}"
                                            alt="Profile photo of {{ $user->name }}"
                                            class="w-36 h-36 rounded-full object-cover border-4 border-gray-100 shadow-lg transition-transform duration-300 hover:scale-105 mx-auto {{ $user->profile_pic ? '' : 'bg-emerald-500 initial-display' }}"
                                            data-initial="{{ strtoupper(substr($user->name, 0, 1) ?? 'U') }}">
                                    </div>
                                    <div class="space-y-2">
                                        <label for="profile_pic"
                                            class="block text-sm font-medium text-gray-700">Profile Photo</label>
                                        <input type="file"
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            id="profile_pic" name="profile_pic"
                                            accept="image/jpeg,image/png,image/gif">
                                        <p class="text-xs text-gray-500">Format: JPG, PNG, GIF. Max size: 2MB</p>
                                        @error('profile_pic')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Form Fields Section -->
                            <div class="lg:col-span-2 space-y-6">
                                <!-- Instance Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                        Instance Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('name') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                        id="name" name="name"
                                        value="{{ old('name', $user->name) }}" disabled required>
                                    @error('name')
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
    
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div
                        class="px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center space-y-3 sm:space-y-0 sm:space-x-3">
                        <button type="button" onclick="toggle_edit_password()"
                            class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors sm:order-1 order-2 w-full sm:w-auto text-center">
                            Change Password
                        </button>
                        <div class="flex justify-end space-x-3 w-full sm:w-auto order-1 sm:order-2">
                            <button type="button" onclick="toggle_edit_profile()"
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
                <form action="/profile/change_password" id="formPassword" method="POST">
                    @csrf
                    @method('PATCH')

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
                            <label for="old_password" class="block text-sm font-medium text-gray-700 mb-1">Current
                                Password <span class="text-red-500">*</span></label>
                            <input type="password"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('old_password') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                id="old_password" name="old_password" required>
                            @error('old_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password
                                <span class="text-red-500">*</span></label>
                            <input type="password"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('password') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                id="password" name="password" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$"
                                    title="Password must be at least 8 characters, include uppercase, lowercase, number, and special character.">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm New Password -->
                        <div>
                            <label for="password_confirmation"
                                class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password <span
                                    class="text-red-500">*</span></label>
                            <input type="password"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                id="password_confirmation" name="password_confirmation" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$"
                                    title="Password must be at least 8 characters, include uppercase, lowercase, number, and special character.">
                            @error('password_confirmation')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <p id="notifWrongPassword" class="text-sm text-red-600"></p>
                    </div>

                    <!-- Modal Footer -->
                    <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                        <button type="button" onclick="toggle_edit_password()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
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

    <x-success></x-success>

    <script>
        function toggle_edit_profile()
        {
            document.getElementById('editProfileModal').classList.toggle('hidden');
            document.getElementById('changePasswordModal').classList.add('hidden');
        }

        function toggle_edit_password()
        {
            document.getElementById('changePasswordModal').classList.toggle('hidden');
            document.getElementById('editProfileModal').classList.add('hidden');
        }

        @if(session('success'))
            open_success('{{ session('success') }}')
        @elseif(session('error'))
            open_fail('{{ session('error') }}')
        @endif
    </script>


    <!-- End  -->
</x-layout>
