<x-layout-admin title="Dashboard Admin" role="admin" :user="$user">
    <!-- Bagian My Account -->
    <div class="bg-white p-4 md:p-6 mb-6 rounded-xl shadow-md">
        <div class="flex justify-between mb-3 items-center">
            <p class="text-lg md:text-2xl font-semibold text-gray-800">Welcome, </p>
        </div>
        <div class="flex items-center">
            <div class="bg-emerald-500 text-white rounded-full w-12 h-12 flex items-center justify-center text-xl font-semibold">
                {{ strtoupper(substr($user->username, 0, 1)) }}
            </div>
            <div class="ps-3">
                <h4 class="text-base md:text-xl  text-gray-800">{{ $user->username }}</h4>
                <p class="text-sm text-gray-500">Admin</p>
            </div>
        </div>
    </div>

    <!-- Bagian Statistik -->
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-6">
        <div class="bg-white p-4 rounded-xl shadow-md flex items-center gap-3">
            <div class="bg-emerald-100 p-2 rounded-full">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a2 2 0 00-2-2h-3m-2-2H7a2 2 0 01-2-2V5a2 2 0 012-2h10a2 2 0 012 2v7m-7 4v4m0-4H9m6 0h6"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-600">Total Teacher</p>
                <p class="text-xl font-bold text-emerald-600">{{ $dataCount['teacher'] }}</p>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-md flex items-center gap-3">
            <div class="bg-emerald-100 p-2 rounded-full">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 006 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3-.512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-600">Total Group</p>
                <p class="text-xl font-bold text-emerald-600">{{ $dataCount['group'] }}</p>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-md flex items-center gap-3">
            <div class="bg-emerald-100 p-2 rounded-full">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-600">Total Students</p>
                <p class="text-xl font-bold text-emerald-600">{{ $dataCount['student'] }}</p>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-md flex items-center gap-3">
            <div class="bg-emerald-100 p-2 rounded-full">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-600">Total Instantiate</p>
                <p class="text-xl font-bold text-emerald-600">{{ $dataCount['instantiate'] }}</p>
            </div>
        </div>
    </div>

    <!-- Bagian Instantiate List -->
    <div class="bg-white p-4 md:p-6 rounded-xl shadow-md">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Instantiate List</h2>
            <a href="{{route('instantiate_manage')}}" class="bg-emerald-500 text-white px-3 py-1 rounded text-sm hover:bg-emerald-600 transition">Manage</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[600px] text-left border-collapse">
                <thead>
                    <tr class="text-sm text-gray-700 bg-emerald-50">
                        <th class="p-3 font-semibold border-b border-gray-200">No</th>
                        <th class="p-3 font-semibold border-b border-gray-200">Instantiate</th>
                        <th class="p-3 font-semibold border-b border-gray-200">Email</th>
                        <th class="p-3 font-semibold border-b border-gray-200">Phone No</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600">
                    @foreach ($getStaff as $staff)
                    <tr class="hover:bg-emerald-50 transition-colors">
                        <td class="p-3 border-b border-gray-100">{{ $loop->iteration }}</td>
                        <td class="p-3 border-b border-gray-100">{{ $staff->instance_name }}</td>
                        <td class="p-3 border-b border-gray-100">{{ $staff->email }}</td>
                        <td class="p-3 border-b border-gray-100">{{ $staff->phone_no }}</td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layout-admin>