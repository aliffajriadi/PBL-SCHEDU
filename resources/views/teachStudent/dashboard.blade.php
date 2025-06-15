<x-layout title="Dashboard" role="teacher" :user="$user_data">
    <!-- Main container with responsive padding -->

    {{-- @dd(session()->get('notification_count')) --}}

    <!-- Top section that stacks on mobile, side-by-side on larger screens -->
    <div class="flex flex-col lg:flex-row lg:space-x-3 space-y-3 lg:space-y-0 animate-fadeIn">
        <!-- Left section - full width on mobile, 7/12 on desktop -->
        <div class="w-full lg:w-7/12 space-y-3">
            <!-- Account Card -->
            <div class="bg-white rounded-xl p-3 shadow-md hover:shadow-lg transition-all duration-300">
                <div class="flex justify-between mb-3 items-center">
                    <h2 class="text-lg md:text-xl">My Account</h2>
                    <a href="/profile"><img src="assets/Vector 6.svg"
                            class="w-3 h-auto hover:w-4 transition-all duration-300 active:w-4" alt="accountpage"></a>
                </div>

                <div
                    class="bg-emerald-500 rounded-2xl py-4 md:rounded-full md:p-2 flex flex-col sm:flex-row items-center text-white">
                    <img src="{{  $user->profile_pic !== null ? asset('storage/' . $user->instance->folder_name . '/' . $user->profile_pic) : 'image/Ryan-Gosling.jpg'}}" class="w-20 h-20 md:w-14 md:h-14 border-yellow-300 border-2 rounded-full object-cover"
                        alt="profile">
                    <div class="ps-2 text-center sm:text-left mt-2 sm:mt-0">
                        <h4 class="text-lg md:text-xl"> {{ $user->name }} </h4>
                        <p class="text-xs md:text-sm">{{ $user->instance->instance_name }}</p>
                    </div>
                </div>

                <p class="text-emerald-700 mt-3 mb-2 text-sm md:text-base">Start creating now!</p>
                <div class="flex flex-wrap gap-2">
                    <div
                        class="flex py-1 px-3 md:px-4 rounded-full border text-sm transition-all duration-300 border-emerald-600 hover:bg-emerald-300 active:bg-emerald-300">
                        <img src="assets/bx-task 2.svg" alt="task" class="w-3 md:w-4 h-auto">
                        <a href="/note" class="text-emerald-600 ml-1">Notes</a>
                    </div>
                    <div
                        class="flex py-1 px-3 md:px-4 rounded-full border text-sm transition-all duration-300 border-emerald-600 hover:bg-emerald-300 active:bg-emerald-300">
                        <img src="assets/bx-task 2.svg" alt="task" class="w-3 md:w-4 h-auto">
                        <a href="/task" class="text-emerald-600 ml-1">Task</a>
                    </div>
                    <div
                        class="flex py-1 px-3 md:px-4 rounded-full items-center border text-sm transition-all duration-300 border-emerald-600 focus:bg-emerald-300 active:bg-emerald-300 hover:bg-emerald-300">
                        <img src="assets/bx-task 2.svg" alt="task" class="w-3 md:w-4 h-auto">
                        <a href="/schedule" class="text-emerald-600 ml-1">Schedule</a>
                    </div>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="bg-emerald-500 p-3 rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                <div class="flex justify-between mb-3 items-center text-white">
                    <h2 class="text-lg md:text-xl">My Task Progress</h2>
                    <a href="/task"><img src="assets/Vector 6.svg"
                            class="w-3 h-auto hover:w-4 transition-all duration-300 active:w-4" alt="accountpage"></a>
                </div>

                <div class="relative w-full bg-gray-200 rounded-full h-5 md:h-6">
                    <div id="progress-bar"
                        class="bg-yellow-300 rounded-full h-5 md:h-6 flex items-center justify-center text-xs md:text-sm text-emerald-600 transition-all duration-500 ease-in-out"
                        style="width: 0%;">
                        <span id="progress-text">0%</span>
                    </div>
                </div>
                <p class="text-white mt-1 text-xs md:text-sm" id="task-info">Done from 0 Task</p>
            </div>
        </div>

        <!-- Right section - full width on mobile, 5/12 on desktop -->
        <div
            class="w-full lg:w-5/12 bg-emerald-500 p-3 md:p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
            <div class="flex items-center text-white mb-3">
                <svg class="w-5 h-5 md:w-6 md:h-6 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0a3 3 0 11-6 0">
                    </path>
                </svg>
                <h2 class="text-lg md:text-xl">Notification</h2>
            </div>


            <div class="space-y-2 md:space-y-3">
                <!-- Notifikasi -->
                @foreach ($notifications as $notif)
                    <div class="bg-white p-2 md:p-3 rounded-lg shadow-md">
                        <p class="text-gray-500 text-xs md:text-sm">{{ $notif->created_at }}</p>
                        <p class="text-emerald-800 text-sm font-medium"> {{ $notif->notification->group_id === null ? '[Personal]' : '[Group]'}} {{ Str::limit($notif->notification->title, 30) }}</p>
                    </div>  
                @endforeach

            </div>
            <p class="text-xs md:text-sm mt-2 md:mt-3 text-white">You Have {{ session('notification_count') }} Notification not readed</p>
        </div>
    </div>

    <!-- Schedule section - full width -->
    <div class="bg-white rounded-xl p-3 mt-3 mb-3 shadow-md hover:shadow-lg transition-all duration-300">
        <div class="flex justify-between mb-3 items-center">
            <h2 class="text-lg md:text-xl">My Schedule</h2>
            <a href="/schedule"><img src="assets/Vector 6.svg"
                    class="w-3 h-auto hover:w-4 transition-all duration-300 active:w-4" alt="accountpage"></a>
        </div>
       
        <x-calender></x-calender>
    </div>

    <div class="bg-white rounded-xl p-3 mb-3 shadow-md hover:shadow-lg transition-all duration-300">
        
    </div>


    <script>


        document.addEventListener('DOMContentLoaded', function () {
            set_calendar(@json($schedules) )
        });

        function updateProgress(doneTasks, totalTasks) {
            const progressBar = document.getElementById("progress-bar");
            const progressText = document.getElementById("progress-text");
            const taskInfo = document.getElementById("task-info");

            let percent = (doneTasks / totalTasks) * 100;

            if (isNaN(percent) || totalTasks === 0) {
                progressText.textContent = "No Task";
                progressText.classList = "font-semibold";
                progressBar.style.width = "15%"; // Set minimal lebar agar tidak hilang
                progressBar.style.minWidth = "50px"; // Pastikan tetap terlihat
                progressBar.style.backgroundColor = "#d1d5db"; // Warna abu-abu untuk kosong
                taskInfo.textContent = `You have no tasks, let's create one!`;
            } else {
                progressBar.style.width = percent + "%";
                progressBar.style.minWidth = "50px"; // Tetap ada lebar minimal
                progressText.textContent = percent.toFixed(0) + "%";
                taskInfo.textContent = `${doneTasks} Done from ${totalTasks} Task`;
            }
        }

        // Panggil fungsi saat halaman selesai dimuat
        window.onload = function() {
            updateProgress({{ $f_task_count }}, {{ $uf_task_count + $f_task_count }}); // Ubah disini untuk data nya nanti
        };
    </script>
</x-layout>
