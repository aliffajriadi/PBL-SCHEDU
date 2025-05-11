<x-layout-admin title="Dashboard Admin" role="admin">
    <div class="bg-white p-4 md:p-6 mb-6 rounded-xl">
        <div class="flex justify-between mb-3 items-center">
            <p class="text-lg md:text-2xl font-bold">My Account</p>
            <a href="#"><img src="{{ asset('assets/Vector 6.svg') }}" class="w-3 hover:w-4 transition-all duration-300"
                    alt="accountpage"></a>
        </div>
        <div class="bg-emerald-500 rounded-full p-2 flex text-white items-center">
            <img src="{{ asset('image/Ryan-Gosling.jpg') }}" class="w-14 h-auto rounded-full" alt="profile">
            <div class="ps-2">
                <h4 class="text-base md:text-xl">Pipip</h4>
                <p class="text-sm">admin</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:flex lg:space-x-6 mb-6">
        <div class="bg-white p-4 rounded-xl shadow-md text-center">
            <p class="text-sm text-gray-600">Total Teacher</p>
            <p class="text-2xl font-bold text-emerald-600">5</p>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-md text-center">
            <p class="text-sm text-gray-600">Total Class</p>
            <p class="text-2xl font-bold text-emerald-600">5</p>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-md text-center">
            <p class="text-sm text-gray-600">Total Students</p>
            <p class="text-2xl font-bold text-emerald-600">58</p>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-md text-center">
            <p class="text-sm text-gray-600">Total Staff</p>
            <p class="text-2xl font-bold text-emerald-600">5</p>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-md text-center col-span-2 sm:col-span-1">
            <p class="text-sm text-gray-600">Total Instance</p>
            <p class="text-2xl font-bold text-emerald-600">9</p>
        </div>
    </div>

    <div class="bg-white p-4 md:p-6 rounded-xl shadow-md">
        <h2 class="text-lg font-semibold mb-4">Active Group</h2>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[600px] text-left border-collapse">
                <thead>
                    <tr class="text-sm text-black">
                        <th class="p-2">Name</th>
                        <th class="p-2">Address</th>
                        <th class="p-2">Class</th>
                        <th class="p-2">Gender</th>
                        <th class="p-2">Role</th>
                        <th class="p-2">Action</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-black">
                    <tr class="odd:bg-gray-100">
                        <td class="p-2">Class A</td>
                        <td class="p-2">Batu Ajo, Sekupang perum tiban 3</td>
                        <td class="p-2">Class A</td>
                        <td class="p-2">Male</td>
                        <td class="p-2">Student</td>
                        <td class="p-2">
                            <div class="flex items-center gap-2">
                                <img src="assets/pencil.svg" class="w-5 h-auto bg-emerald-500 rounded p-1" />
                            </div>
                        </td>
                    </tr>
                    <tr class="odd:bg-gray-100">
                        <td class="p-2">Class B</td>
                        <td class="p-2">Tiban, Sekupang, Perumahan Cipta Garden</td>
                        <td class="p-2">Class B</td>
                        <td class="p-2">Male</td>
                        <td class="p-2">Student</td>
                        <td class="p-2">
                            <div class="flex items-center gap-2">
                                <img src="assets/pencil.svg" class="w-5 h-auto bg-emerald-500 rounded p-1" />
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-layout-admin>