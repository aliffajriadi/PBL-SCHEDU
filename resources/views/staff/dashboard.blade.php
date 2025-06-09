<x-layout-staff title="Dashboard Staff" role="staff" :user="$user">


    <div class="grid md:grid-cols-3 gap-6">
        <!-- Left Column: My Account and Metrics -->
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white p-3 md:p-3 rounded-xl shadow-md">
                <div class="flex justify-between mb-2 items-center">
                    <p class="text-lg md:text-2xl font-semibold text-slate-600">Welcome!</p>
                </div>
                <div class="rounded-full p-2 flex text-white items-center">
                    @if ($user->logo_instance != null)
                        <img src="{{ asset('storage/' . $user->logo_instance) }}" class="rounded-full w-12 h-12" alt="profile">
                    @else
                        <div
                            class="bg-emerald-500 text-white rounded-full w-12 h-12 flex items-center justify-center text-xl font-semibold">
                            {{ strtoupper(substr($user->instance_name, 0, 1)) }}
                        </div>
                    @endif


                    <div class="ps-3 text-slate-600">
                        <h4 class="text-base font-semibold md:font-normal md:text-xl">{{$user->instance_name}}</h4>
                        <p class="text-sm">{{ $user->email }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-4">
                <div class="flex items-center bg-white rounded-xl shadow-md p-4">
                    <div class="p-3 bg-emerald-100 rounded-full">
                        <img src="{{asset('assets/person.svg')}}" alt="Teacher Icon" class="w-6 h-6" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm">Total Teacher</p>
                        <p class="text-xl font-bold text-emerald-600">{{$dataCount['teacher']}}</p>
                    </div>
                </div>

                <div class="flex items-center bg-white rounded-xl shadow-md p-4">
                    <div class="p-3 bg-yellow-100 rounded-full">
                        <img src="{{asset('assets/class.svg')}}" alt="Class Icon" class="w-6 h-6" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm">Total Group Class</p>
                        <p class="text-xl font-bold text-yellow-500">{{$dataCount['group']}}</p>
                    </div>
                </div>

                <div class="flex items-center bg-white rounded-xl shadow-md p-4">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <img src="{{asset('assets/groups.svg')}}" alt="Student Icon" class="w-6 h-6" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm">Total Students</p>
                        <p class="text-xl font-bold text-blue-500">{{$dataCount['student']}}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Notifications -->
        <div class="md:col-span-1">
            <div class="bg-white p-4 md:p-6 rounded-xl shadow-md h-full flex flex-col">
                <h2 class="text-lg font-medium mb-4">Recent Notifications</h2>
                <div class="space-y-4">
                    <!-- Notification -->
                    @if (count($notifications) == 0)
                        <div class="flex flex-col items-center justify-center py-8 text-center">
                            <div class="bg-gray-100 p-4 rounded-full mb-4">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-gray-500 font-medium">No notifications yet</p>
                            <p class="text-gray-400 text-sm mt-1">You're all caught up!</p>
                        </div>
                    @endif
                    @foreach ($notifications as $notif)
                        <div class="flex items-start p-3 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100">
                            <div class="p-2 bg-gray-100 rounded-full">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l9-6 9 6v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 12v4m0 0h.01M12 8v2" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-700">{{$notif->title}}</p>
                                <p class="text-sm text-gray-700">{{$notif->content}}</p>
                                <p class="text-xs text-gray-500">{{$notif->created_at}}</p>
                            </div>
                        </div>
                    @endforeach
                    @if (count($notifications) > 0)
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <a href="#"
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center justify-center">
                                View All Notifications
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Group-Teacher Table Section -->
    <div class="mt-6 pb-10">
        <div class="bg-white p-3 md:p-6 rounded-xl shadow-md">
            <div class="flex justify-between mb-4 items-center">
                <p class="text-lg md:text-xl text-gray-800">Groups list</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                                No</th>
                            <th
                                class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                                Group</th>
                            <th
                                class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                                Teacher</th>
                            <th
                                class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                                Created</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        @foreach ($groups as $group)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-900">{{ $loop->iteration }}</td>
                                <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-900">{{ $group->name }}</td>
                                <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-900">{{ $group->user?->name }}</td>
                                <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-900">{{ $group->created_at }}</td>
                            </tr>
                        @endforeach
                        
                    </tbody>
                </table>
                @if (count($groups) == 0)
                    <div class="flex flex-col items-center justify-center py-8 text-center">
                        <div class="bg-gray-100 p-4 rounded-full mb-4">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                        </div>
                        <p class="text-gray-500 font-medium">No groups available</p>
                        <p class="text-gray-400 text-sm mt-1">Groups will appear here once created</p>
                    </div>
                @endif

            </div>
        </div>
    </div>
    </x-layout>