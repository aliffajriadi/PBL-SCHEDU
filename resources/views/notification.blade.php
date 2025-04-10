<x-layout title="Notifications" role="teacher">
    <!-- Header dengan Search dan Tombol Back -->
    <div class="bg-white mb-3 flex flex-row-reverse md:flex-row justify-between p-3 shadow-md rounded-2xl items-center">
        <button onclick="location.href='/dashboard'"
            class="bg-emerald-500 text-white hover:bg-emerald-600 px-4 py-2 rounded-lg text-sm transition-all duration-300">
            ← Back to Dashboard
        </button>
        <input type="text" id="search" placeholder="Search notifications..."
            class="mt-2 sm:mt-0 w-full sm:w-1/3 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-300 transition-all"
            onkeyup="getSearch()">
    </div>

    <!-- Konten Utama -->
    <div class="flex gap-3">
        <!-- Bagian Kiri -->
        <div class="bg-white p-3 fade-in-left w-full md:w-5/12 shadow-md rounded-2xl">
            <h2 class="text-lg mb-4 font-semibold text-gray-800">Notification List</h2>
            <div class="p-3 rounded-2xl h-72 overflow-auto">
                @php
                    $notifications = [
                        ['title' => 'New Assignment Submitted', 'message' => 'A student submitted Assignment #3.', 'created_at' => '10 minutes ago'],
                        ['title' => 'Schedule Updated', 'message' => 'Math class rescheduled to 10 AM.', 'created_at' => '1 hour ago'],
                        ['title' => 'Grade Posted', 'message' => 'Grades for Quiz #2 are now available.', 'created_at' => '5 hours ago'],
                        ['title' => 'System Maintenance', 'message' => 'Platform will be down at midnight.', 'created_at' => '1 day ago'],
                        ['title' => 'New Comment', 'message' => 'A student commented on your post.', 'created_at' => '2 days ago'],
                    ];
                @endphp
                @foreach ($notifications as $notification)
                    <a href="/notifications/detail/{{ $loop->iteration }}"
                        class="block w-full border-b-2 border-emerald-400 pb-3 hover:border-emerald-600 hover:bg-emerald-50 cursor-pointer transition-all duration-300 notification-item">
                        <div class="flex justify-between items-start mt-3">
                            <div>
                                <h3 class="text-md font-semibold text-gray-800">{{ $notification['title'] }}</h3>
                                <p class="text-sm text-gray-600">{{ $notification['message'] }}</p>
                                <p class="text-xs opacity-60 mt-1">Received {{ $notification['created_at'] }}</p>
                            </div>
                            <p class="text-xs font-semibold text-emerald-500">{{ $loop->iteration }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Bagian Kanan (Preview) -->
        <div class="bg-white flex-col fade-in-right justify-center hidden md:flex items-center p-3 shadow-md rounded-2xl w-7/12 h-96">
            <img src="/image/ilustr1.jpg" alt="ilustrator" class="w-40 h-auto opacity-90">
            <p class="text-gray-600 mt-2">Click notification for preview</p>
            
        </div>
    </div>

    <!-- Script Search -->
    <script>
        function getSearch() {
            const input = document.getElementById("search").value.toLowerCase();
            const items = document.querySelectorAll(".notification-item");

            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(input) ? "block" : "none";
            });
        }
    </script>
</x-layout>


