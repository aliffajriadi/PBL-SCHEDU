@props(['role', 'title', 'user'])

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{$title}}</title>
    @vite('resources/css/app.css')
    <link rel="icon" class="" href="{{asset('/image/logoP.png')}}" type="image/png" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <script src="/js/fetch.js"></script>
    
    <x-layoutComponent.layoutCss />
</head>

<body class="bg-emerald-50 md:flex h-screen">
    <!-- Sidebar for desktop -->
    <x-layoutComponent.SidebarDesktop :role="$role" />

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
            <img src="{{ asset('image/Ryan-Gosling.jpg')}}"
                class="w-12 border-2 border-green-500 h-12 rounded-full shadow-md transition-all duration-300 hover:border-emerald-600 cursor-pointer"
                alt="profile" onclick="dropdown('dropdownMenu')" id="dropdownButton" />
        </div>
    </nav>

    <!-- Mobile menu - Fixed position from top of screen -->
    <x-layoutComponent.Mobilebar :role="$role" />



    <!-- Main Content -->
    <main class="flex-1 flex mt-16 md:mt-0 flex-col md:ml-64 px-6 pt-8 text-emerald-800">
        <!-- up content -->
        <x-layoutComponent.UpContent :role="$role" :title="$title" :user="$user" />

        {{-- dinamis content --}}
        {{$slot}}

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
