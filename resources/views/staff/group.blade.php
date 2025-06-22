<x-layout title="Manage Group" role="staff" :user="$user">
    <div class="bg-white p-6 rounded-2xl shadow-md overflow-x-auto w-full">
        <h2 class="text-lg font-medium mb-4">Group List</h2>

        <!-- Search Form -->
        <div class="mb-4">
            <form action="/search-groups" method="GET" class="flex-1">
                <input type="text" name="search" placeholder="Search groups by name..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-400" />
            </form>
        </div>

        <!-- Group Table -->
        <table class="w-full text-sm text-left border-separate border-spacing-0">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="py-3 px-4 border-b">No</th>
                    <th class="py-3 px-4 border-b">Name Group</th>
                    <th class="py-3 px-4 border-b">Teacher</th>
                    <th class="py-3 px-4 border-b">Group Code</th>
                    <th class="py-3 px-4 border-b">Created At</th>
                    <th class="py-3 px-4 border-b">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 divide-y">
                @forelse ($groupList as $group)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4 border-b">{{ $loop->iteration }}</td>
                        <td class="py-3 px-4 border-b">{{ $group->name }}</td>
                        <td class="py-3 px-4 border-b">{{ $group->user->name }}</td>
                        <td class="py-3 px-4 border-b">{{ $group->group_code }}</td>
                        <td class="py-3 px-4 border-b">{{ $group->created_at->diffForHumans() }}</td>
                        <td class="py-3 px-4 border-b flex gap-2">
                            <button type="submit" onclick="openDeleteModal('{{ $group->id }}', '{{ $group->name }}')"
                                class="text-red-500 hover:text-red-600">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-4 px-4 text-center text-gray-500">
                            Group no have created.
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
    {{-- CONFIRMATION DELETE --}}
    <div id="deleteModal"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center hidden z-50 p-4">
        <div class="bg-white p-4 sm:p-6 rounded-xl shadow-md slide-down w-full max-w-md">
            <h2 class="text-lg font-semibold mb-4">Confirm Deletion</h2>
            <p class="mb-4">Are you sure you want to delete <span id="deleteUserName"
                    class="font-medium text-red-400"></span>'s
                Group? This Group cannot be undone.</p>
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

    <script>
        function openDeleteModal(uuid, name) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            const userName = document.getElementById('deleteUserName');
            form.action = `/staff/group/destroy/${uuid}`;
            userName.textContent = name;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>
    <x-modal.toast />
</x-layout>