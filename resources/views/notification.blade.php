@php
    $role = "teacher";
@endphp
<x-layout title="Notifications" role="{{ $role }}">
    <!-- Header with Search and Back Button -->
    <div class="bg-white mb-4 flex flex-row items-center justify-between p-4 shadow-md rounded-2xl">
        <input 
            type="text" 
            id="search" 
            placeholder="Search notifications..." 
            class="w-full sm:w-1/3 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all duration-300"
            onkeyup="getSearch()"
        />
        <button 
            onclick="location.href='/dashboard'"
            class="bg-emerald-500 text-white hover:bg-emerald-600 px-4 py-2 rounded-lg text-sm transition-all duration-300"
        >
            ← Back to Dashboard
        </button>
    </div>

    <!-- Main Content -->
    <div class="flex gap-4">
        <!-- Left Column: Notification List -->
        <div class="bg-white p-4 w-full md:w-5/12 shadow-md rounded-2xl animate-fade-in-left">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Notification List</h2>
            <!-- Filter Buttons -->
            <div class="flex gap-2 mb-4">
                <button 
                    id="filter-all" 
                    onclick="filterNotifications('all')"
                    class="bg-emerald-500 text-white px-4 py-1.5 rounded-lg hover:bg-emerald-600 transition-all duration-300 active-filter text-sm"
                >
                    All
                </button>
                <button 
                    id="filter-personal" 
                    onclick="filterNotifications('personal')"
                    class="bg-gray-200 text-gray-800 px-4 py-1.5 rounded-lg hover:bg-gray-300 transition-all duration-300 text-sm"
                >
                    Personal
                </button>
                <button 
                    id="filter-group" 
                    onclick="filterNotifications('group')"
                    class="bg-gray-200 text-gray-800 px-4 py-1.5 rounded-lg hover:bg-gray-300 transition-all duration-300 text-sm"
                >
                    Group
                </button>
            </div>
            <!-- Notification List -->
            <div class="space-y-3">
                @php
                    $notifications = [
                        ['title' => 'New Assignment Submitted', 'message' => 'A student submitted Assignment #3.', 'created_at' => '10 minutes ago', 'type' => 'personal', 'is_read' => false],
                        ['title' => 'Schedule Updated', 'message' => 'Math class rescheduled to 10 AM.', 'created_at' => '1 hour ago', 'type' => 'group', 'is_read' => false],
                        ['title' => 'Grade Posted', 'message' => 'Grades for Quiz #2 are now available.', 'created_at' => '5 hours ago', 'type' => 'group', 'is_read' => false],
                        ['title' => 'System Maintenance', 'message' => 'Platform will be down at midnight.', 'created_at' => '1 day ago', 'type' => 'personal', 'is_read' => false],
                        ['title' => 'New Comment', 'message' => 'A student commented on your post.', 'created_at' => '2 days ago', 'type' => 'personal', 'is_read' => true],
                        ['title' => 'Class Attendance', 'message' => 'Attendance for Class A updated.', 'created_at' => '3 days ago', 'type' => 'group', 'is_read' => true],
                        ['title' => 'New Resource Added', 'message' => 'New study material uploaded for Algebra.', 'created_at' => '4 days ago', 'type' => 'group', 'is_read' => true],
                        ['title' => 'Feedback Received', 'message' => 'Received feedback on your latest lecture.', 'created_at' => '5 days ago', 'type' => 'personal', 'is_read' => true],
                        ['title' => 'Event Reminder', 'message' => 'Parent-teacher meeting scheduled for Friday.', 'created_at' => '6 days ago', 'type' => 'group', 'is_read' => true],
                        ['title' => 'Profile Updated', 'message' => 'Your profile information was updated.', 'created_at' => '7 days ago', 'type' => 'personal', 'is_read' => true],
                    ];
                @endphp
                @foreach ($notifications as $notification)
                    <a 
                        href="/notifications/detail/{{ $loop->iteration }}"
                        class="block bg-white p-3 rounded-lg shadow-sm hover:bg-emerald-50 hover:shadow-md transition-all duration-300 active:scale-95 notification-item"
                        data-type="{{ $notification['type'] }}"
                    >
                        <div class="flex items-start gap-3">
                            <!-- Icon -->
                            <div class="p-2 bg-emerald-100 rounded-full flex-shrink-0">
                                @if ($notification['type'] === 'personal')
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                @endif
                            </div>
                            <!-- Content -->
                            <div class="flex-1">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-2">
                                        <h3 class="text-md font-semibold {{ $notification['is_read'] ? 'text-gray-600' : 'text-gray-800 font-bold' }}">
                                            {{ $notification['title'] }}
                                        </h3>
                                        @if (!$notification['is_read'])
                                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                        @endif
                                    </div>
                                    <span class="text-xs font-semibold text-white bg-emerald-500 rounded-full px-2 py-1">{{ $loop->iteration }}</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1 {{ $notification['is_read'] ? 'opacity-75' : '' }}">{{ $notification['message'] }}</p>
                                <p class="text-xs text-gray-500 mt-1">Received {{ $notification['created_at'] }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Right Column: Preview -->
        <div class="bg-white flex-col justify-center items-center hidden md:flex p-6 shadow-md rounded-2xl w-7/12 h-96 animate-fade-in-right">
            <div class="bg-gradient-to-br from-emerald-100 to-emerald-300 rounded-2xl p-8 text-center">
                <svg class="w-16 h-16 text-emerald-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l9-6 9 6v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12v4m0 0h.01M12 8v2"/>
                </svg>
                <p class="text-lg font-semibold text-gray-800">Select a Notification</p>
                <p class="text-sm text-gray-600 mt-2">Click a notification on the left to view details.</p>
            </div>
        </div>
    </div>

    <!-- Script for Search and Filter -->
    <script>
        function getSearch() {
            const input = document.getElementById("search").value.toLowerCase();
            const items = document.querySelectorAll(".notification-item");

            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                const isVisible = text.includes(input);
                item.style.display = isVisible ? "block" : "none";
            });
        }

        function filterNotifications(type) {
            const items = document.querySelectorAll(".notification-item");
            const allButton = document.getElementById("filter-all");
            const personalButton = document.getElementById("filter-personal");
            const groupButton = document.getElementById("filter-group");

            // Reset button styles
            allButton.classList.remove("bg-emerald-500", "text-white", "active-filter");
            personalButton.classList.remove("bg-emerald-500", "text-white", "active-filter");
            groupButton.classList.remove("bg-emerald-500", "text-white", "active-filter");
            allButton.classList.add("bg-gray-200", "text-gray-800");
            personalButton.classList.add("bg-gray-200", "text-gray-800");
            groupButton.classList.add("bg-gray-200", "text-gray-800");

            // Highlight active button
            if (type === "all") {
                allButton.classList.remove("bg-gray-200", "text-gray-800");
                allButton.classList.add("bg-emerald-500", "text-white", "active-filter");
            } else if (type === "personal") {
                personalButton.classList.remove("bg-gray-200", "text-gray-800");
                personalButton.classList.add("bg-emerald-500", "text-white", "active-filter");
            } else if (type === "group") {
                groupButton.classList.remove("bg-gray-200", "text-gray-800");
                groupButton.classList.add("bg-emerald-500", "text-white", "active-filter");
            }

            // Filter notifications
            items.forEach(item => {
                const itemType = item.getAttribute("data-type");
                item.style.display = (type === "all" || itemType === type) ? "block" : "none";
            });

            // Reapply search filter if search input is active
            getSearch();
        }
    </script>

    <!-- Custom Animation -->
    <style>
        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .animate-fade-in-left {
            animation: fadeInLeft 0.5s ease-out forwards;
        }
        .animate-fade-in-right {
            animation: fadeInRight 0.5s ease-out forwards;
        }
    </style>
</x-layout>