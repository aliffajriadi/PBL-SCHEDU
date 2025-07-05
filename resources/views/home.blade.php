<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />
    <title>SchedU - Your Daily Plans</title>
    <style>
        * {
            font-family: poppins, sans-serif;
        }

        .navbar-transparent {
            background-color: transparent;
            transition: background-color 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .navbar-white {
            background-color: rgba(255, 255, 255, 0.5);
            /* putih transparan */
            backdrop-filter: blur(4px);
            /* efek blur */
            -webkit-backdrop-filter: blur(4px);
            /* dukungan Safari */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            /* bayangan */
            transition: background-color 0.5s cubic-bezier(0.4, 0, 0.2, 1),
                box-shadow 0.5s ease;
        }


        /* Animation Keyframes */
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

        @keyframes fadeOutRight {
            from {
                opacity: 1;
                transform: translateX(0);
            }

            to {
                opacity: 0;
                transform: translateX(50px);
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

        @keyframes fadeOutLeft {
            from {
                opacity: 1;
                transform: translateX(0);
            }

            to {
                opacity: 0;
                transform: translateX(-50px);
            }
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

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes scaleIn {
            from {
                transform: scale(0.8);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Floating Particle Animation */
        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
            animation: float 15s infinite ease-in-out;
            pointer-events: none;
        }

        .particle-1 {
            width: 20px;
            height: 20px;
            top: 10%;
            left: 15%;
            animation-delay: 0s;
        }

        .particle-2 {
            width: 15px;
            height: 15px;
            top: 30%;
            left: 70%;
            animation-delay: 1s;
        }

        .particle-3 {
            width: 25px;
            height: 25px;
            top: 50%;
            left: 30%;
            animation-delay: 2s;
        }

        .particle-4 {
            width: 18px;
            height: 18px;
            top: 70%;
            left: 85%;
            animation-delay: 1s;
        }

        .particle-5 {
            width: 22px;
            height: 22px;
            top: 90%;
            left: 50%;
            animation-delay: 2s;
        }

        @keyframes float {
            0% {
                transform: translateY(0) translateX(0);
                opacity: 0.3;
            }

            50% {
                transform: translateY(-100px) translateX(50px);
                opacity: 0.6;
            }

            100% {
                transform: translateY(0) translateX(0);
                opacity: 0.3;
            }
        }

        /* Dropdown Animation */
        details[open] .animate-smooth {
            animation: slideDown 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        details .animate-smooth {
            display: block;
            opacity: 0;
            transform: translateY(-10px);
        }

        details[open] .animate-smooth {
            opacity: 1;
            transform: translateY(0);
        }

        summary::-webkit-details-marker {
            display: none;
        }

        summary::after {
            content: '\25BC';
            float: right;
            font-size: 1rem;
            transition: transform 0.3s ease;
        }

        details[open] summary::after {
            transform: rotate(180deg);
        }

        /* Scroll Animation */
        .animate-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }

        .animate-in.visible {
            opacity: 1;
            transform: translateY(0);
            animation: slideInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Animation Classes */
        .slide-down {
            animation: slideDown 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .fade-in-right {
            animation: fadeInRight 1.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .fade-out-right {
            animation: fadeOutRight 1.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .fade-in-left {
            animation: fadeInLeft 1.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .fade-out-left {
            animation: fadeOutLeft 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        /* Mobile Menu Animation */
        .mobile-menu {
            transform: translateX(100%);
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.5s ease;
            opacity: 0;
        }

        .mobile-menu.open {
            transform: translateX(0);
            opacity: 1;
            animation: slideInRight 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        /* Button Hover Effect */
        .btn-hover {
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .btn-hover::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s ease;
        }

        .btn-hover:hover::before {
            left: 100%;
        }

        .btn-hover:hover {
            transform: translateY(-2px);
        }

        /* Card Hover Effect */
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        /* Loading Animation */
        .loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 128, 0, 0.95);
            /* Green background matching theme */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 1;
            transition: opacity 0.8s ease-out, visibility 0.8s ease-out;
        }

        .loader.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .loader-logo {
            width: 150px;
            height: auto;
            animation: pulse 1.5s infinite ease-in-out;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.8;
            }

            50% {
                transform: scale(1.2);
                opacity: 1;
            }
        }

        .loader-particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.4);
            border-radius: 50%;
            box-shadow: 0 0 8px rgba(255, 255, 255, 0.6);
            animation: floatLoader 10s infinite ease-in-out;
        }

        .loader-particle-1 {
            width: 15px;
            height: 15px;
            top: 20%;
            left: 30%;
            animation-delay: 0s;
        }

        .loader-particle-2 {
            width: 20px;
            height: 20px;
            top: 40%;
            left: 60%;
            animation-delay: 2s;
        }

        .loader-particle-3 {
            width: 18px;
            height: 18px;
            top: 60%;
            left: 40%;
            animation-delay: 4s;
        }

        @keyframes floatLoader {
            0% {
                transform: translateY(0) translateX(0);
                opacity: 0.4;
            }

            50% {
                transform: translateY(-50px) translateX(30px);
                opacity: 0.8;
            }

            100% {
                transform: translateY(0) translateX(0);
                opacity: 0.4;
            }
        }

        /* Content Animation */
        body.loading main,
        body.loading nav,
        body.loading section,
        body.loading footer {
            opacity: 0;
            transition: opacity 0.8s ease-out;
        }

        body:not(.loading) main,
        body:not(.loading) nav,
        body:not(.loading) section,
        body:not(.loading) footer {
            opacity: 1;
        }
    </style>
</head>

<body class="bg-[url('/public/image/image1.png')] bg-no-repeat loading">
    <!-- Loader -->
    <div class="loader">
        <img src="image/image4.png" alt="SchedU Loading Logo" class="loader-logo">
        <div class="loader-particle loader-particle-1"></div>
        <div class="loader-particle loader-particle-2"></div>
        <div class="loader-particle loader-particle-3"></div>
    </div>

    <!-- Navigation -->
    <nav id="navbar" class="fixed top-0 left-0 w-full z-50 px-4 navbar-transparent">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <div class="flex text-2xl fade-in-left sm:text-4xl">
                    <a href="#" class="w-full h-auto rounded-lg hover:opacity-80 items-center">
                        <img src="image/image4.png" alt="SchedU Logo" class="w-32 h-auto items-center" />
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button id="menu-button" onclick="toggleMenu()"
                        class="text-black hover:text-green-500 focus:outline-none" aria-label="Toggle menu">
                        <svg id="icon-menu" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg id="icon-close" class="w-8 h-8 hidden" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Desktop menu -->
                <div class="hidden md:flex space-x-4 p-4 font-semibold items-center">
                    <a href="#home" class="hover:text-green-500">Home</a>
                    <a href="#about" class="hover:text-green-500">About Us</a>
                    <a href="#features" class="hover:text-green-500">Feature</a>
                    <a href="#report" class="hover:text-green-500">Report</a>
                    <a href="/login"
                        class="btn-hover flex items-center text-white hover:text-green-600 bg-green-500 rounded-[20px] px-4 py-1 transition duration-300">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            class="w-5 h-5 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25a2.25 2.25 0 00-2.25-2.25h-7.5a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 006 21h7.5a2.25 2.25 0 002.25-2.25V15M18 7.5l3 3m0 0l-3 3m3-3H9" />
                        </svg>
                        Sign In
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile menu -->
    <div id="mobile-menu"
        class="md:hidden hidden mobile-menu space-y-2 p-4 mt-16 font-semibold bg-green-500 bg-opacity-90 rounded-lg flex w-auto flex-col shadow-lg mt-2 z-50 fixed text-center right-0 me-8">
        <a href="#home" class="text-slate-50 hover:underline py-2">Home</a>
        <a href="#about" class="text-slate-50 hover:underline py-2">About Us</a>
        <a href="#features" class="text-slate-50 hover:underline py-2">Feature</a>
        <a href="#report" class="text-slate-50 hover:underline py-2">Report</a>
        <a href="/login"
            class="btn-hover flex items-center text-white bg-green-500 hover:text-green-600 rounded-[20px] px-4 py-2 my-1 transition duration-300">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 9V5.25a2.25 2.25 0 00-2.25-2.25h-7.5a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 006 21h7.5a2.25 2.25 0 002.25-2.25V15M18 7.5l3 3m0 0l-3 3m3-3H9" />
            </svg>
            Sign In
        </a>
    </div>

    <!-- Hero section -->
    <main id="home"
        class="flex flex-col items-center md:items-start justify-center h-screen p-8 md:p-16 text-center md:text-left pt-12">
        <h1 class="text-5xl sm:text-6xl slide-down lg:text-6xl font-bold text-black animate-in">
            Your Daily <span class="text-green-500">Plans</span>,<br />
            All In <span class="text-yellow-300">One</span> Place
        </h1>
        <h2 class="text-lg fade-in-right font-semibold sm:text-2xl mt-4 text-green-500 animate-in"
            style="animation-delay: 0.2s;">
            Manage your tasks, events, and notes without the clutter.
        </h2>
        <a href="/login"
            class="mt-6 inline-block fade-in-left btn-hover bg-green-500 text-white px-6 py-2 rounded-[20px] hover:bg-green-600 transition duration-300 animate-in"
            style="animation-delay: 0.4s;">Get Started</a>
    </main>

    <!-- Responsive Design Section -->
    <section
        class="h-1/2 bg-gradient-to-b from-white/50 px-8 to-white flex flex-col justify-center items-center text-center">
        <img src="{{asset('image/image4.png')}}" alt="logo-responsif-section" class="md:w-56 w-40 h-auto animate-in">
        <p class="text-xl font-semibold text-green-500 animate-in" style="animation-delay: 0.2s;">
            Enjoy an optimal browsing experience on all devices
        </p>
        <img src="{{asset('image/responsif.png')}}" alt="responsif design section foto"
            class="sm:w-96 sm:h-auto animate-in" style="animation-delay: 0.4s;">
    </section>

    <!-- About section -->
    <section id="about"
        class="bg-white fade-in-left py-24 px-8 md:p-32 flex flex-col lg:flex-row items-center gap-16 min-h-screen">
        <div class="flex-1 fade-in-left text-left">
            <h1 class="text-3xl md:text-5xl font-bold text-green-500 mb-6 animate-in">About Us</h1>
            <div class="md:hidden flex-1 py-3 flex justify-center">
                <img src="./image/image2.jpg" alt="SchedU Dashboard"
                    class="w-full max-w-md object-contain rounded-lg animate-in" style="animation-delay: 0.2s;" />
            </div>
            <p class="text-lg md:text-xl text-black animate-in" style="animation-delay: 0.4s;">
                SchedU is a web-based app that helps schools manage schedules and academic collaboration. It supports different user roles like admins, staff, teachers, and students—each with features tailored to their needs.
            </p>
            <p class="text-lg md:text-xl text-black mt-4 animate-in" style="animation-delay: 0.6s;">
                From personal tasks to group events, SchedU makes planning and communication easier in academic environments.
            </p>
        </div>
        <div class="flex-1 flex justify-center hidden md:block">
            <img src="./image/image2.jpg" alt="SchedU Dashboard"
                class="w-full max-w-md object-contain rounded-lg animate-in" style="animation-delay: 0.8s;">
        </div>
    </section>

    <!-- Features section -->
    <section id="features"
        class="relative bg-green-600 min-h-screen p-8 md:p-16 lg:p-32 flex flex-col justify-center items-center gap-6 overflow-hidden">
        <!-- Floating Background Particles -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="particle particle-1"></div>
            <div class="particle particle-2"></div>
            <div class="particle particle-3"></div>
            <div class="particle particle-4"></div>
            <div class="particle particle-5"></div>
        </div>
        <div class="text-center w-full mb-10">
            <h1 class="text-3xl md:text-4xl font-bold text-white tracking-wide animate-in">Features</h1>
        </div>
        <div class="w-full max-w-4xl space-y-4 relative z-10">
            <!-- Task Dropdown -->
            <details class="bg-white shadow-lg rounded-2xl hover:shadow-xl transition duration-300">
                <summary class="text-2xl font-bold text-green-500 py-4 px-6 cursor-pointer outline-none">
                    Task
                </summary>
                <p class="text-black text-base px-6 pb-4 animate-smooth">
                    Task is a specific job or work that needs to be completed, usually with a goal, steps, and a
                    deadline.
                </p>
            </details>

            <!-- Notes Dropdown -->
            <details class="bg-white shadow-lg rounded-2xl hover:shadow-xl transition duration-300">
                <summary class="text-2xl font-bold text-green-500 py-4 px-6 cursor-pointer outline-none">
                    Notes
                </summary>
                <p class="text-black text-base px-6 pb-4 animate-smooth">
                    Notes are short writings or records that contain important information, summaries, or ideas to help
                    remember or understand something.
                </p>
            </details>

            <!-- Notification Dropdown -->
            <details class="bg-white shadow-lg rounded-2xl hover:shadow-xl transition duration-300">
                <summary class="text-2xl font-bold text-green-500 py-4 px-6 cursor-pointer outline-none">
                    Notification
                </summary>
                <p class="text-black text-base px-6 pb-4 animate-smooth">
                    Notification is a notice or message that informs the user about specific information or events.
                </p>
            </details>

            <!-- Schedule Dropdown -->
            <details class="bg-white shadow-lg rounded-2xl hover:shadow-xl transition duration-300">
                <summary class="text-2xl font-bold text-green-500 py-4 px-6 cursor-pointer outline-none">
                    Schedule
                </summary>
                <p class="text-black text-base px-6 pb-4 animate-smooth">
                    Schedule is a time plan that organizes when specific activities or tasks are carried out.
                </p>
            </details>

            <!-- Group Dropdown -->
            <details class="bg-white shadow-lg rounded-2xl hover:shadow-xl transition duration-300">
                <summary class="text-2xl font-bold text-green-500 py-4 px-6 cursor-pointer outline-none">
                    Group
                </summary>
                <p class="text-black text-base px-6 pb-4 animate-smooth">
                    Group is a collection of individuals who share a common goal or interest, interact, and collaborate
                    to achieve that goal.
                </p>
            </details>
        </div>
    </section>

    <!-- Report section -->
    <section id="report" class="py-16 px-8 min-h-screen bg-white">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl font-bold text-green-500 mb-12 animate-in">Report</h1>
            <div class="flex justify-around flex-wrap gap-8">
                <!-- Data Cards -->
                <div class="flex flex-col justify-start items-start gap-8 md:pt-20">
                    <!-- Instansi Card -->
                    <div class="bg-white p-6 rounded-lg shadow-md card-hover hover:shadow-lg transition animate-in"
                        style="animation-delay: 0.2s;">
                        <h2 class="text-5xl font-bold text-yellow-400 counter" data-target="{{$dataCount['instansi']}}">0</h2>
                        <p class="text-lg font-semibold text-gray-700 mt-2">Instansi</p>
                    </div>

                    <!-- Teacher Card -->
                    <div class="bg-white p-6 rounded-lg shadow-md card-hover hover:shadow-lg transition animate-in"
                        style="animation-delay: 0.4s;">
                        <h2 class="text-5xl font-bold text-green-400 counter" data-target="{{$dataCount['teacher']}}">0</h2>
                        <p class="text-lg font-semibold text-gray-700 mt-2">Teacher</p>
                    </div>

                    <!-- Student Card -->
                    <div class="bg-white p-6 rounded-lg shadow-md card-hover hover:shadow-lg transition animate-in"
                        style="animation-delay: 0.6s;">
                        <h2 class="text-5xl font-bold text-slate-800 counter" data-target="{{$dataCount['student']}}">0</h2>
                        <p class="text-lg font-semibold text-gray-700 mt-2">Student</p>
                    </div>
                </div>

                <!-- Illustration Image -->
                <div class="flex justify-center items-center">
                    <img src="{{ asset('image/ilus4.jpg') }}" alt="report illustration"
                        class="w-80 h-auto animate-in scale-in" style="animation-delay: 0.8s;" />
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-green-600 text-white py-8 px-6">
        <div class="container mx-auto flex flex-col md:flex-row justify-between items-center space-y-6 md:space-y-0">
            <!-- Logo dan Tagline -->
            <div class="text-center md:text-left animate-in">
                <img src="image/logowhite.png" alt="SchedU Logo" class="w-36 h-auto mx-auto md:mx-0 mb-2" />
                <p class="text-sm opacity-80">Your Daily Plans, All In One Place</p>
            </div>

            <!-- Quick Links & Contact -->
            <div class="flex flex-wrap justify-center md:justify-end space-x-8 text-center md:text-left">
                <!-- Quick Links -->
                <div class="animate-in" style="animation-delay: 0.2s;">
                    <h3 class="font-bold mb-2 text-lg">Quick Links</h3>
                    <ul class="space-y-1">
                        <li><a href="#home" class="hover:underline">Home</a></li>
                        <li><a href="#about" class="hover:underline">About Us</a></li>
                        <li><a href="#features" class="hover:underline">Features</a></li>
                        <li><a href="#report" class="hover:underline">Report</a></li>
                    </ul>
                </div>
                <!-- Contact Info -->
                <div class="mt-4 md:mt-0 animate-in" style="animation-delay: 0.4s;">
                    <h3 class="font-bold mb-2 text-lg">Contact</h3>
                    <p class="text-sm opacity-80">contact@schedu.com</p>
                    <p class="text-sm opacity-80">+62 123 456 7890</p>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-white mt-6 pt-4 text-center text-sm opacity-80 animate-in"
            style="animation-delay: 0.6s;">
            © 2025 SchedU. All rights reserved.
        </div>
    </footer>

    <script>
        function toggleMenu() {
            let menu = document.getElementById("mobile-menu");
            let iconMenu = document.getElementById("icon-menu");
            let iconClose = document.getElementById("icon-close");
            menu.classList.toggle("hidden");
            menu.classList.toggle("mobile-menu");
            menu.classList.toggle("open");
            iconMenu.classList.toggle("hidden");
            iconClose.classList.toggle("hidden");
        }

        // Add scroll event listener to change navbar background
        window.addEventListener("scroll", function () {
            const navbar = document.getElementById("navbar");
            if (window.scrollY > 50) {
                navbar.classList.remove("navbar-transparent");
                navbar.classList.add("navbar-white");
            } else {
                navbar.classList.remove("navbar-white");
                navbar.classList.add("navbar-transparent");
            }
        });

        // Check scroll position on page load
        document.addEventListener("DOMContentLoaded", function () {
            if (window.scrollY > 50) {
                document.getElementById("navbar").classList.add("navbar-white");
            }
        });

        // Smooth Scroll for Nav Links
        document.querySelectorAll("nav a").forEach((anchor) => {
            anchor.addEventListener("click", function (e) {
                // e.preventDefault();
                const targetId = this.getAttribute("href").substring(1);
                document.getElementById(targetId).scrollIntoView({
                    behavior: "smooth",
                });
            });
        });

        // Intersection Observer for Animations
        document.addEventListener("DOMContentLoaded", () => {
            const animateElements = document.querySelectorAll(".animate-in");
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("visible");
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });

            animateElements.forEach(element => observer.observe(element));
        });

        // Counter Animation with Easing
        document.addEventListener("DOMContentLoaded", () => {
            const counters = document.querySelectorAll(".counter");
            const speed = 300;

            const startCount = (counter) => {
                const target = +counter.getAttribute("data-target");
                const increment = target / speed;
                let count = 0;

                const easeOutQuad = t => t * (2 - t); // Easing function

                const updateCount = (progress) => {
                    count = easeOutQuad(progress) * target;
                    if (count < target) {
                        counter.innerText = Math.ceil(count);
                        requestAnimationFrame(() => updateCount(progress + 1 / speed));
                    } else {
                        counter.innerText = target;
                    }
                };
                updateCount(0);
            };

            const counterObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        startCount(entry.target);
                        counterObserver.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.5
            });

            counters.forEach((counter) => counterObserver.observe(counter));
        });

        // Loading Animation
        document.addEventListener("DOMContentLoaded", () => {
            const loader = document.querySelector(".loader");
            const body = document.body;

            // Hide loader and show content after 2 seconds or when content is loaded
            setTimeout(() => {
                loader.classList.add("hidden");
                body.classList.remove("loading");
            }, 2000); // Adjust duration as needed

            // Ensure loader hides when all assets are loaded
            window.addEventListener("load", () => {
                setTimeout(() => {
                    loader.classList.add("hidden");
                    body.classList.remove("loading");
                }, 0);

            });
        });
    </script>
</body>

</html>