<x-layout title="Manage Account" role="staff">
    <!-- New Full-Width Account List Table -->
    <div class="bg-white p-6 rounded-xl shadow-md mb-6 w-full">
        <h2 class="text-lg font-semibold mb-4">Account List</h2>
        <div class="mb-4 flex gap-4">
            <form action="/search-accounts" method="GET" class="flex-1">
                <input type="text" name="search" placeholder="Search accounts..." class="w-full px-4 py-2 border rounded" />
            </form>
            <form action="/filter-accounts" method="GET">
                <select name="role" class="px-4 py-2 border rounded" onchange="this.form.submit()">
                    <option value="">All Roles</option>
                    <option value="student">Student</option>
                    <option value="teacher">Teacher</option>
                    <option value="staff">Staff</option>
                </select>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-600">
                    <tr>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Address</th>
                        <th class="px-4 py-2">Gender</th>
                        <th class="px-4 py-2">Role</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">Apip Henriko Dachi</td>
                        <td class="px-4 py-2">Batu Ajo, Sekupang perum Tiban 3</td>
                        <td class="px-4 py-2">Male</td>
                        <td class="px-4 py-2">Student</td>
                        <td class="py-2 px-4 flex gap-2">
                            <form action="/edit-account" method="POST">
                                <input type="hidden" name="name" value="Apip Henriko Dachi" />
                                <button type="submit" class="text-emerald-500 hover:text-emerald-600">
                                    <img src="assets/Group.svg" class="w-5 inline" alt="Edit">
                                </button>
                            </form>
                            <form action="/delete-account" method="POST">
                                <input type="hidden" name="name" value="Apip Henriko Dachi" />
                                <button type="submit" class="text-red-500 hover:text-red-600">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <!-- Additional rows can be added by server -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Existing Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 pb-4">
        <div>
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-lg font-semibold mb-4">Create Account</h2>
                <form class="space-y-4" action="/create-account" method="POST">
                    <input type="text" name="name" placeholder="Name" class="w-full px-4 py-2 border rounded" required />
                    <input type="email" name="email" placeholder="Email" class="w-full px-4 py-2 border rounded" required />
                    <input type="password" name="password" placeholder="Password" class="w-full px-4 py-2 border rounded" required />
                    <input type="text" name="address" placeholder="Address" class="w-full px-4 py-2 border rounded" required />
                    <div>
                        <label class="block mb-1">Birth Date</label>
                        <input type="date" name="birth_date" class="w-full px-4 py-2 border rounded" required />
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <select name="gender" class="px-4 py-2 border rounded" required>
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        <select name="role" class="px-4 py-2 border rounded" required>
                            <option value="">Select Role</option>
                            <option value="student">Student</option>
                            <option value="teacher">Teacher</option>
                            <option value="staff">Staff</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-emerald-400 text-white px-6 py-2 rounded hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        Create Account
                    </button>
                </form>
            </div>

            <div class="mt-6 bg-white p-6 border-dashed border-2 border-gray-300 rounded-xl flex flex-col items-center justify-center text-center h-40">
                <span class="material-icons text-4xl text-gray-400">upload_file</span>
                <p class="text-sm text-gray-500">Drag and Drop file <br><span class="text-emerald-600 font-medium">or</span></p>
                <button class="mt-2 px-4 py-1 border border-emerald-600 text-emerald-600 rounded hover:bg-emerald-100 focus:outline-none focus:ring-2 focus:ring-emerald-500">Browse</button>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md">
            <h2 class="text-lg font-semibold mb-4">Staff List</h2>
            <div class="mb-4 flex gap-4">
                <form action="/search-staff" method="GET" class="flex-1">
                    <input type="text" name="search" placeholder="Search staff..." class="w-full px-4 py-2 border rounded" />
                </form>
                <form action="/filter-staff" method="GET">
                    <select name="role" class="px-4 py-2 border rounded" onchange="this.form.submit()">
                        <option value="staff" selected>Staff</option>
                    </select>
                </form>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-100 text-gray-600">
                        <tr>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Address</th>
                            <th class="px-4 py-2">Gender</th>
                            <th class="px-4 py-2">Role</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">John Doe</td>
                            <td class="px-4 py-2">123 Staff Lane</td>
                            <td class="px-4 py-2">Male</td>
                            <td class="px-4 py-2">Staff</td>
                            <td class="py-2 px-4 flex gap-2">
                                <form action="/edit-account" method="POST">
                                    <input type="hidden" name="name" value="John Doe" />
                                    <button type="submit" class="text-emerald-500 hover:text-emerald-600">
                                        <img src="assets/Group.svg" class="w-5 inline" alt="Edit">
                                    </button>
                                </form>
                                <form action="/delete-account" method="POST">
                                    <input type="hidden" name="name" value="John Doe" />
                                    <button type="submit" class="text-red-500 hover:text-red-600">
                                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <!-- Additional staff rows can be added by server -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>