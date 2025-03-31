<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title }}</title>
    @vite('resources/css/app.css')
    <link rel="icon" class="" href="/image/logoP.png" type="image/png" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <style>
        * {
            font-family: "Poppins", sans-serif;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }


        .fade-in-right {
            animation: fadeInRight 1s ease-out forwards;
        }
        .fade-in-left {
            animation: fadeInLeft 1s ease-out forwards;
        }

        .slide-down {
            animation: slideDown 0.5s ease-in-out;
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
            <img src="{{ asset('image/logowhite.png') }}" alt="logo" class="w-36 h-auto" />
        </div>

        <!-- MENU -->
        <p class="text-sm py-2 text-emerald-100 font-medium">MENU</p>
        <div>
            <a href="/dashboard"
                class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item">
                <img src="{{ asset('assets/Home.svg') }}" class="w-5 h-auto" />
                <p class="font-semibold">Dashboard</p>
            </a>

            @if ($role == 'teacher' or $role == 'student')
                <a href="/notes"
                    class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item">
                    <img src="{{ asset('assets/bx-notepad 2.svg') }}" class="w-5 h-auto" />
                    <p class="font-semibold">Notes</p>
                </a>
                <a href="/task"
                    class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item">
                    <img src="{{ asset('assets/bx-task (1) 2.svg') }}" class="w-5 h-auto" />
                    <p class="font-semibold">Task</p>
                </a>
                <a href="#"
                    class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item">
                    <img src="{{ asset('assets/calender-white.svg') }}" class="w-5 h-auto" />
                    <p class="font-semibold">Schedule</p>
                </a>
            @endif

            <a href="#"
                class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('assets/notifications.svg') }}" class="w-5 h-auto" />
                    <p class="font-semibold">Notification</p>
                </div>
                <p class="text-xs text-emerald-50 bg-red-500 rounded-full px-2 py-1">3</p>

            </a>

        </div>
        @if (in_array($role, ['student', 'teacher']))
            <!-- GROUP -->
            <p class="text-sm py-2 mt-4 text-emerald-100 font-medium">GROUP</p>
            <div>
                <a href="#"
                    class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item">
                    <img src="{{ asset('assets/bx-group (1) 3.svg') }}" class="w-5 h-auto" />
                    <p class="font-semibold">Group</p>
                </a>
                <div class="ps-5">
                    <a href="#"
                        class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item">
                        <img src="{{ asset('assets/Home.svg') }}" class="w-5 h-auto" />
                        <p class="font-semibold">Group Dashboard</p>
                    </a>
                    <a href="#"
                        class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item">
                        <img src="{{ asset('assets/bx-notepad 2.svg') }}" class="w-5 h-auto" />
                        <p class="font-semibold">Group Notes</p>
                    </a>
                    <a href="#"
                        class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item">
                        <img src="{{ asset('assets/bx-task (1) 2.svg') }}" class="w-5 h-auto" />
                        <p class="font-semibold">Group Task</p>
                    </a>
                    <a href="#"
                        class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item">
                        <img src="{{ asset('assets/calender-white.svg') }}" class="w-5 h-auto" />
                        <p class="font-semibold">Group Schedule</p>
                    </a>
                    @if ($role == 'teacher')
                        <a href="#"
                            class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item">
                            <img src="{{ asset('assets/setting.svg') }}" class="w-5 h-auto" />
                            <p class="font-semibold">Group Settings</p>
                        </a>
                    @endif

                </div>

            </div>
        @endif



        <!-- MANAGE ACCOUNT BY STAFF -->
        @if ($role == 'staff')
            <p class="text-sm py-2 mt-4 text-emerald-100 font-medium">MANAGE</p>
            <div>
                <a href="#"
                    class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item">
                    <img src="{{ asset('assets/bx-group (1) 3.svg') }}" class="w-5 h-auto" />
                    <p class="font-semibold">Manage Account</p>
                </a>
                <a href="#"
                    class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item">
                    <img src="{{ asset('assets/bx-group (1) 3.svg') }}" class="w-5 h-auto" />
                    <p class="font-semibold">Manage Group</p>
                </a>

            </div>
        @endif


        <!-- SETTING -->
        <p class="text-sm py-2 mt-4 text-emerald-100 font-medium">SETTING</p>
        <div>
            <a href="#"
                class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item">
                <img src="{{ asset('assets/profile.svg') }}" class="w-5 h-auto" />
                <p class="font-semibold">Edit Profile</p>
            </a>
            <a href="#"
                class="flex items-center gap-2 p-2 hover:bg-green-400 rounded-xl cursor-pointer menu-item">
                <img src="{{ asset('assets/Log out.svg') }}" class="w-5 h-auto" />
                <p class="font-semibold">Logout</p>
            </a>

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
            <img src="{{ asset('image/image4.png') }}" class="w-32 h-auto" alt="schedu" />
        </div>
        <div>
            <img src="{{ asset('image/Ryan-gosling.jpg') }}"
                class="w-12 border-2 border-green-500 h-12 rounded-full shadow-md transition-all duration-300 hover:border-emerald-600 cursor-pointer"
                alt="profile" onclick="dropdown('dropdownMenu')" id="dropdownButton" />
        </div>
    </nav>

    <!-- Mobile menu - Fixed position from top of screen -->
    <aside id="menuMobile"
        class="w-4/5 max-w-xs bg-emerald-500 text-white flex-col p-5 fixed z-50 md:hidden overflow-y-auto">
        <div class="flex justify-between items-center mb-6 pt-3">
            <img src="{{ asset('image/logowhite.png') }}" alt="logo" class="w-28 h-auto" />
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
            <a href="#"
                class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                <img src="{{ asset('assets/Home.svg') }}" class="w-5 h-auto" />
                <p class="font-semibold">Dashboard</p>
            </a>

            @if ($role == 'student' or $role == 'teacher')
                <a href="#"
                    class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                    <img src="{{ asset('assets/bx-notepad 2.svg') }}" class="w-5 h-auto" />
                    <p class="font-semibold">Notes</p>
                </a>
                <a href="#"
                    class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                    <img src="{{ asset('assets/bx-task (1) 2.svg') }}" class="w-5 h-auto" />
                    <p class="font-semibold">Task</p>
                </a>
                <a href="#"
                    class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                    <img src="{{ asset('assets/calender-white.svg') }}" class="w-5 h-auto" />
                    <p class="font-semibold">Schedule</p>
                </a>
            @endif

            <a href="#"
                class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('assets/notifications.svg') }}" class="w-5 h-auto" />
                    <p class="font-semibold">Notification</p>
                </div>
                <p class="text-xs text-emerald-50 bg-red-500 rounded-full px-2 py-1">3</p>
            </a>

            @if ($role == 'student' or $role == 'teacher')
                <!-- GROUP -->
                <p class="text-sm py-2 mt-4 text-emerald-100 font-medium">GROUP</p>
                <div>
                    <a href="#"
                        class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                        <img src="{{ asset('assets/bx-group (1) 3.svg') }}" class="w-5 h-auto" />
                        <p class="font-semibold">Group</p>
                    </a>

                    <div class="ps-5">
                        <a href="#"
                            class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                            <img src="{{ asset('assets/Home.svg') }}" class="w-5 h-auto" />
                            <p class="font-semibold">Group Dashboard</p>
                        </a>
                        <a href="#"
                            class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                            <img src="{{ asset('assets/bx-notepad 2.svg') }}" class="w-5 h-auto" />
                            <p class="font-semibold">Group Notes</p>
                        </a>

                        <a href="#"
                            class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                            <img src="{{ asset('assets/bx-task (1) 2.svg') }}" class="w-5 h-auto" />
                            <p class="font-semibold">Group Task</p>
                        </a>

                        <a href="#"
                            class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                            <img src="{{ asset('assets/calender-white.svg') }}" class="w-5 h-auto" />
                            <p class="font-semibold">Group Schedule</p>
                        </a>
                        @if ($role == 'teacher')
                            <a href="#"
                                class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                                <img src="{{ asset('assets/setting.svg') }}" class="w-5 h-auto" />
                                <p class="font-semibold">Group Settings</p>
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            <!-- MANAGE ACCOUNT BY STAFF -->
            @if ($role == 'staff')
                <p class="text-sm py-2 mt-4 text-emerald-100 font-medium">MANAGE</p>
                <div>
                    <a href="#"
                        class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                        <img src="{{ asset('assets/bx-group (1) 3.svg') }}" class="w-5 h-auto" />
                        <p class="font-semibold">Manage Account</p>
                    </a>
                    <a href="#"
                        class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                        <img src="{{ asset('assets/bx-group (1) 3.svg') }}" class="w-5 h-auto" />
                        <p class="font-semibold">Manage Group</p>
                    </a>
                </div>
            @endif

            <!-- SETTING -->
            <p class="text-sm py-2 mt-4 text-emerald-100 font-medium">SETTING</p>
            <div>
                <a href="#"
                    class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                    <img src="{{ asset('assets/profile.svg') }}" class="w-5 h-auto" />
                    <p class="font-semibold">Edit Profile</p>
                </a>

                <a href="#"
                    class="flex items-center gap-2 p-2 hover:bg-green-400 active:bg-green-400 rounded-xl cursor-pointer menu-item">
                    <img src="{{ asset('assets/Log out.svg') }}" class="w-5 h-auto" />
                    <p class="font-semibold">Logout</p>
                </a>
            </div>

    </aside>




    <!-- Main Content -->
    <main class="flex-1 flex mt-16 md:mt-0 flex-col md:ml-64 px-6 pt-8 text-emerald-800">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl md:text-2xl font-semibold text-emerald-800">
                {{ $title }}
            </h1>
            <img src="{{ asset('image/Ryan-Gosling.jpg') }}" id="dropdownButton" onclick="dropdown('dropdownMenu')"
                class="w-12 hidden md:block h-12 cursor-pointer hover:w-14 hover:h-14 transition-all duration-700 rounded-full border-2 border-green-600"
                alt="profile" />
        </div>
        <div id="dropdownMenu"
            class="hidden slide-down origin-top-right right-0 md:mt-12 h-auto me-6 w-56 rounded-md text-sm text-emerald-900 text-center shadow-xl bg-white ring-1 ring-black ring-opacity-5 focus:outline-none p-2 z-30 fixed md:absolute">
            <p class="text-md font-semibold">Ryan Gosling</p>
            <p style="font-size: smaller">ryangosling@gmail.com</p>
            <p>{{ ucfirst($role) }}</p>
            <hr class="my-2">
            <div class="flex-col flex text-start px-2 space-y-2">
                <a class="flex gap-x-1 hover:bg-emerald-300 cursor-pointer rounded-lg py-1 px-3">
                    <img src="{{ asset('assets/profile-green.svg') }}" alt="avatar" class="w-5 h-auto">
                    <p
                        class="text-sm font-semibold text-emerald-800 transition-all duration-500 hover:text-emerald-600">
                        Profile</p>
                </a>
                <a class="flex gap-x-1 hover:bg-red-300 rounded-lg cursor-pointer py-1 px-3">
                    <img src="{{ asset('assets/Log out (1).svg') }}" alt="avatar" class="w-5 h-auto">
                    <p class="text-sm font-semibold text-red-600 transition-all duration-500 hover:text-red-600 ">
                        Logout</p>
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
