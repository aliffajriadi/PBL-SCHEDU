<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title }}</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <style>
        * {
            font-family: "Poppins", sans-serif;
        }

        /* Scrollbar for sidebar */
        aside::-webkit-scrollbar {
            width: 8px;
        }

        aside::-webkit-scrollbar-track {
            background: #d1fae5;
            border-radius: 1px;
        }

        aside::-webkit-scrollbar-thumb {
            background: #119d6f;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        aside::-webkit-scrollbar-thumb:hover {
            background: #059669;
        }

        /* Menu transition animations */
        #menuMobile {
            transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
            transform: translateX(-100%);
            opacity: 0;
            top: 0;
            /* Ensure it starts from the very top */
            left: 0;
            height: 100%;
        }

        #menuMobile.active {
            transform: translateX(0);
            opacity: 1;
        }

        /* Menu item hover effect */
        .menu-item {
            transition: all 0.2s ease;
        }

        .menu-item:hover {
            transform: translateX(5px);
        }

        /* Hamburger menu animation */
        .hamburger-line {
            transition: all 0.3s ease;
        }

        .menu-open .line-1 {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .menu-open .line-2 {
            opacity: 0;
        }

        .menu-open .line-3 {
            transform: rotate(-45deg) translate(5px, -5px);
        }
    </style>
</head>

<body class="bg-emerald-50 md:flex h-screen">
    <!-- Sidebar for desktop -->
    <aside class="w-64 bg-emerald-500 text-white flex-col p-4 fixed h-screen overflow-y-auto hidden md:flex">
        <div class="flex justify-center bg-emerald-500 mb-2">
            <img src="./image/logowhite.png" alt="logo" class="w-36 h-auto" />
        </div>

        <!-- MENU -->
        <p class="text-sm py-2 text-emerald-100 font-medium">MENU</p>
        <div>
            <div class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item">
                <img src="assets/Home.svg" class="w-5 h-auto" />
                <a href="/dashboard" class="font-semibold">Dashboard</a>
            </div>
            <div class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item">
                <img src="assets/bx-notepad 2.svg" class="w-5 h-auto" />
                <a href="/notes" class="font-semibold">Notes</a>
            </div>
            <div class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item">
                <img src="assets/bx-task (1) 2.svg" class="w-5 h-auto" />
                <a href="#" class="font-semibold">Task</a>
            </div>
            <div class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item">
                <img src="assets/calender-white.svg" class="w-5 h-auto" />
                <a href="#" class="font-semibold">Schedule</a>
            </div>
            <div class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item">
                <img src="assets/notifications.svg" class="w-5 h-auto" />
                <a href="#" class="font-semibold">Notification</a>
            </div>
        </div>

        <!-- GROUP -->
        <p class="text-sm py-2 mt-4 text-emerald-100 font-medium">GROUP</p>
        <div>
            <div class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item">
                <img src="assets/bx-group (1) 3.svg" class="w-5 h-auto" />
                <a href="#" class="font-semibold">Group</a>
            </div>
            <div class="ps-5">
                <div class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item">
                    <img src="assets/bx-notepad 2.svg" class="w-5 h-auto" />
                    <a href="#" class="font-semibold">Group Notes</a>
                </div>
                <div class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item">
                    <img src="assets/bx-task (1) 2.svg" class="w-5 h-auto" />
                    <a href="#" class="font-semibold">Group Task</a>
                </div>
                <div class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item">
                    <img src="assets/calender-white.svg" class="w-5 h-auto" />
                    <a href="#" class="font-semibold">Group Schedule</a>
                </div>
            </div>
        </div>

        <!-- SETTING -->
        <p class="text-sm py-2 mt-4 text-emerald-100 font-medium">SETTING</p>
        <div>
            <div class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item">
                <img src="assets/profile-user-avatar-man-person-svgrepo-com 1.svg" class="w-5 h-auto" />
                <a href="#" class="font-semibold">Edit Profile</a>
            </div>
            <div class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item">
                <img src="assets/Log out.svg" class="w-5 h-auto" />
                <a href="#" class="font-semibold">Logout</a>
            </div>
        </div>
    </aside>

    <!-- MOBILE NAVBAR -->
    <nav
        class="flex justify-between px-6 bg-white fixed top-0 w-full left-0 py-2 shadow-md md:hidden items-center z-40">
        <div>
            <button class="focus:outline-none" id="menuToggle" onclick="toggleMenu()">
                <div class="flex flex-col justify-between h-6 w-8 transform transition-all duration-500">
                    <span class="block h-1 w-8 bg-emerald-500 rounded hamburger-line line-1"></span>
                    <span class="block h-1 w-8 bg-emerald-500 rounded hamburger-line line-2"></span>
                    <span class="block h-1 w-8 bg-emerald-500 rounded hamburger-line line-3"></span>
                </div>
            </button>
        </div>
        <div>
            <img src="image/image4.png" class="w-32 h-auto" alt="schedu" />
        </div>
        <div>
            <img src="image/Ryan-gosling.jpg"
                class="w-12 border-2 border-green-500 h-12 rounded-full shadow-md transition-all duration-300 hover:border-emerald-600 cursor-pointer"
                alt="profile" onclick="dropdown('dropdownMenu')" id="dropdownButton" />
        </div>
    </nav>

    <!-- Mobile menu - Fixed position from top of screen -->
    <aside id="menuMobile"
        class="w-4/5 max-w-xs bg-emerald-500 text-white flex-col p-5 fixed z-50 md:hidden overflow-y-auto">
        <div class="flex justify-between items-center mb-6 pt-3">
            <img src="/image/logowhite.png" alt="logo" class="w-28 h-auto" />
            <button class="text-white" onclick="toggleMenu()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- MENU -->
        <p class="text-sm py-2 text-emerald-100 font-medium">MENU</p>
        <div>
            <div class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                <img src="assets/Home.svg" class="w-5 h-auto" />
                <a href="#" class="font-semibold">Dashboard</a>
            </div>
            <div class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                <img src="assets/bx-notepad 2.svg" class="w-5 h-auto" />
                <a href="#" class="font-semibold">Notes</a>
            </div>
            <div class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                <img src="assets/bx-task (1) 2.svg" class="w-5 h-auto" />
                <a href="#" class="font-semibold">Task</a>
            </div>
            <div class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                <img src="assets/calender-white.svg" class="w-5 h-auto" />
                <a href="#" class="font-semibold">Schedule</a>
            </div>
            <div class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                <img src="assets/notifications.svg" class="w-5 h-auto" />
                <a href="#" class="font-semibold">Notification</a>
            </div>
        </div>

        <!-- GROUP -->
        <p class="text-sm py-2 mt-4 text-emerald-100 font-medium">GROUP</p>
        <div>
            <div class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                <img src="assets/bx-group (1) 3.svg" class="w-5 h-auto" />
                <a href="#" class="font-semibold">Group</a>
            </div>
            <div class="ps-5">
                <div class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                    <img src="assets/bx-notepad 2.svg" class="w-5 h-auto" />
                    <a href="#" class="font-semibold">Group Notes</a>
                </div>
                <div class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                    <img src="assets/bx-task (1) 2.svg" class="w-5 h-auto" />
                    <a href="#" class="font-semibold">Group Task</a>
                </div>
                <div class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                    <img src="assets/calender-white.svg" class="w-5 h-auto" />
                    <a href="#" class="font-semibold">Group Schedule</a>
                </div>
            </div>
        </div>

        <!-- SETTING -->
        <p class="text-sm py-2 mt-4 text-emerald-100 font-medium">SETTING</p>
        <div>
            <div class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                <img src="assets/profile-user-avatar-man-person-svgrepo-com 1.svg" class="w-5 h-auto" />
                <a href="#" class="font-semibold">Edit Profile</a>
            </div>
            <div class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                <img src="assets/Log out.svg" class="w-5 h-auto" />
                <a href="#" class="font-semibold">Logout</a>
            </div>
        </div>
    </aside>




    <!-- Main Content -->
    <main class="flex-1 flex mt-16 md:mt-0 flex-col md:ml-64 px-6 pt-8 text-emerald-800">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl md:text-2xl font-semibold text-emerald-800">
                {{ $title }}
            </h1>
            <img src="image/Ryan-gosling.jpg" id="dropdownButton" onclick="dropdown('dropdownMenu')"
                class="w-12 hidden md:block h-12 cursor-pointer hover:w-14 hover:h-14 transition-all duration-700 rounded-full border-2 border-green-600" alt="profile" />
        </div>
        <div id="dropdownMenu"
            class="hidden origin-top-right right-0 md:mt-12 h-auto me-6 w-56 rounded-md text-sm text-emerald-900 text-center shadow-xl bg-white ring-1 ring-black ring-opacity-5 focus:outline-none p-2 z-30 fixed md:absolute">
            <p class="text-md font-semibold">Ryan Gosling</p>
            <p style="font-size: smaller">ryangosling@gmail.com</p>
            <p>Student</p>
            <hr class="my-2">
            <div class="flex-col flex text-start px-2 space-y-2">
                <a class="flex gap-x-1 hover:bg-emerald-300 cursor-pointer rounded-lg py-1 px-3">
                    <img src="assets/profile-green.svg" alt="avatar" class="w-5 h-auto">
                    <p class="text-sm font-semibold text-emerald-800 transition-all duration-500 hover:text-emerald-600">Profile</p>
                </a>
                <a class="flex gap-x-1 hover:bg-red-300 rounded-lg cursor-pointer py-1 px-3">
                    <img src="assets/Log out (1).svg" alt="avatar" class="w-5 h-auto">
                    <p class="text-sm font-semibold text-red-600 transition-all duration-500 hover:text-red-600 ">Logout</p>
                </a>
            </div>
        </div>

        {{ $slot }}

    </main>

    <script>
        function toggleMenu() {
            const menuMobile = document.getElementById("menuMobile");
            const menuToggle = document.getElementById("menuToggle");
            const menuOverlay = document.getElementById("menuOverlay");

            menuToggle.classList.toggle("menu-open");
            menuMobile.classList.toggle("active");

            // Toggle overlay visibility
            if (menuOverlay.classList.contains("hidden")) {
                menuOverlay.classList.remove("hidden");
                setTimeout(() => {
                    menuOverlay.style.opacity = 1;
                }, 10);
            } else {
                menuOverlay.style.opacity = 0;
                setTimeout(() => {
                    menuOverlay.classList.add("hidden");
                }, 300);
            }
        }

        function dropdown(dropID) {
            document.getElementById(dropID).classList.toggle('hidden');
            document.getElementById('dropdownButton').classList.toggle('w-14');
            document.getElementById('dropdownButton').classList.toggle('h-14');
            document.getElementById('dropdownButton').classList.toggle('border-red-400');

        }
    </script>

</body>

</html>
