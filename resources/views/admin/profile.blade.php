<x-layout-admin title="Edit Account Admin" role="admin" :user="$user">

    <div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

        <!-- Card Container -->
        <div class="bg-white p-8 rounded-lg shadow-md animate-slide-down">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Form Ubah Username -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Change Username</h3>
                    <div class="mb-4">
                        <label for="username" class="block text-xs font-medium text-gray-700">Username</label>
                        <input type="text" id="currentUsername" name="currentUsername"
                            value="{{ old('username', $user->username) }}" required
                            class="mt-1 w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all duration-300 text-sm"
                            placeholder="Enter new username" aria-describedby="username-error" />
                        <p id="showWarningUsername" onclick="showModalUsername()" class="text-red-400 text-xs mt-1 hidden">
                            Username cant same curernt name now</p>
                        @error('username')
                            <p id="username-error" class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-end">
                        <button type="button" onclick="showModalUsername()"
                            class="w-full sm:w-auto px-4 py-2 bg-emerald-500 text-white rounded-md hover:bg-emerald-600 transition-all duration-300 text-sm">
                            Update Username
                        </button>
                    </div>

                </div>

                <!-- Form Ubah Password -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Change Password</h3>
                    <form id="passwordForm" action="/admin/password" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="current_password" class="block text-xs font-medium text-gray-700">Current
                                Password</label>
                            <input type="password" id="current_password" name="current_password" required
                                class="mt-1 w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all duration-300 text-sm"
                                placeholder="Enter current password" aria-describedby="current_password-error" />
                            @error('current_password')
                                <p id="current_password-error" class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="password" class="block text-xs font-medium text-gray-700">New Password</label>
                            <input type="password" id="password" name="password" required
                                class="mt-1 w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all duration-300 text-sm"
                                placeholder="Enter new password" aria-describedby="password-error" />
                            @error('password')
                                <p id="password-error" class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-xs font-medium text-gray-700">Confirm
                                New Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                class="mt-1 w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all duration-300 text-sm"
                                placeholder="Confirm new password" />
                        </div>
                        <p id="errorMessage" class="text-red-400 text-xs mb-2"></p>
                        <div class="flex justify-end">
                            <button id="buttonUpdate" onclick="confirmation_password()" type="button"
                                class="w-full sm:w-auto px-4 py-2 bg-emerald-500 text-white rounded-md hover:bg-emerald-600 transition-all duration-300 text-sm">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="modalNewName"
        class="z-50 hidden fixed inset-0 animate-slide-down flex justify-center items-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white p-4 rounded space-y-3">
            <h1 class="text-lg font-semibold">Confirmation Change Username to <span id="nameChange"
                    class="text-red-400"></span></h1>
            <form action="/admin/username" method="POST">
                @csrf
                <input type="password" id="password_confirmation_current" name="password_confirmation_current" required
                    class="mt-1 mb-2 w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all duration-300 text-sm"
                    placeholder="Current Password ....." />
                <input type="text" hidden name="updateNewUsername" id="inputNewName">
                <button type="submit"
                    class="w-full sm:w-auto px-4 py-2 bg-emerald-500 text-white rounded-md hover:bg-emerald-600 transition-all duration-300 text-sm">Update</button>
                <button type="button"
                    class="w-full sm:w-auto px-4 py-2 bg-slate-300 text-black rounded-md hover:bg-emerald-600 transition-all duration-300 text-sm"
                    onclick="showModalUsername()">Cancel</button>
            </form>

        </div>
    </div>

    <!-- JavaScript for Notifikasi Modal -->
    <script>

        function confirmation_password() {
            const password = document.getElementById('password').value;
            const passwordInput = document.getElementById('password_confirmation');
            const password_confirmation = passwordInput.value;

            if (password === password_confirmation) {
                document.getElementById('passwordForm').submit();
            } else {
                document.getElementById('errorMessage').innerText = `Password does not match`;
                passwordInput.value = '';
            }
        }
        function showModalUsername() {
            const confirmName = document.getElementById('nameChange');
            const currentName = '{{ $user->username }}';
            const newName = document.getElementById('currentUsername').value;

            if (newName === currentName) {
                const warning = document.getElementById('showWarningUsername');
                warning.classList.remove('hidden');
                setTimeout(() => {
                    warning.classList.add('hidden');
                }, 7000);

                return;
            }

            confirmName.innerText = newName;
            document.getElementById('modalNewName').classList.toggle('hidden');
            document.getElementById('inputNewName').value = newName;
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