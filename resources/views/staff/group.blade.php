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
                    <th class="py-3 px-4 border-b">Total Student</th>
                    <th class="py-3 px-4 border-b">Created At</th>
                    <th class="py-3 px-4 border-b">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 divide-y">
                @foreach ($groupList as $group)

                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4 border-b">{{ $loop->iteration }}</td>
                        <td class="py-3 px-4 border-b">sd</td>
                        <td class="py-3 px-4 border-b"></td>
                        <td class="py-3 px-4 border-b"></td>
                        <td class="py-3 px-4 border-b">2025-01-15</td>
                        <td class="py-3 px-4 border-b flex gap-2">

                            <form action="/delete-group" method="POST">
                                <input type="hidden" name="group_id" value="1" />
                                <button type="submit" class="text-red-500 hover:text-red-600">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach


            </tbody>
        </table>
    </div>
</x-layout>