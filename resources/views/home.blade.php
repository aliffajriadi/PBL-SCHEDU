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
            transition: background-color 0.3s ease;
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

        .slide-down {
            animation: slideDown 0.5s ease-in-out;
        }

        .fade-in-right {
            animation: fadeInRight 2s ease-out forwards;
        }

        .fade-out-right {
            animation: fadeOutRight 1.5s ease-out forwards;
        }

        .fade-in-left {
            animation: fadeInLeft 1.5s ease-out forwards;
        }

        .fade-out-left {
            animation: fadeOutLeft 0.5s ease-out forwards;
        }


        .navbar-white {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        details[open] .animate-smooth {
            animation: slideDown 0.3s ease-in-out;
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

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Menghilangkan marker default dan menambahkan gaya kustom */
        summary::-webkit-details-marker {
            display: none;
        }

        summary::after {
            content: '\25BC';
            /* Simbol panah ke bawah */
            float: right;
            font-size: 1rem;
            transition: transform 0.3s ease;
        }

        details[open] summary::after {
            transform: rotate(180deg);
            /* Panah berputar saat dibuka */
        }
    </style>
</head>

<body class="bg-[url('/public/image/image1.png')] bg-no-repeat">
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
                        <!-- Ikon Hamburger -->
                        <svg id="icon-menu" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>

                        <!-- Ikon X (Close) -->
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
                    <a href="login.html"
                        class="flex items-center text-white hover:text-green-600 bg-green-500 rounded-[20px] px-4 py-1 transition duration-300">
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
    <!-- Mobile menu (hidden by default) F-->
    <div id="mobile-menu"
        class="md:hidden hidden space-y-2 p-4 mt-16 font-semibold bg-green-500 bg-opacity-90 rounded-lg flex w-auto flex-col shadow-lg mt-2 z-50 fixed text-center right-0 me-8">
        <a href="#home" class="text-slate-50 hover:underline py-2">Home</a>
        <a href="#about" class="text-slate-50 hover:underline py-2">About Us</a>
        <a href="#features" class="text-slate-50 hover:underline py-2">Feature</a>
        <a href="#report" class="text-slate-50 hover:underline py-2">Report</a>
        <a href="login.html"
            class="flex items-center text-white bg-green-500 hover:text-green-600 rounded-[20px] px-4 py-2 my-1 transition duration-300">
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
        <h1 class="text-5xl sm:text-6xl slide-down lg:text-6xl font-bold text-black">
            Your Daily <span class="text-green-500">Plans</span>,<br />
            All In <span class="text-yellow-300">One</span> Place
        </h1>
        <h2 class="text-lg fade-in-right font-semibold sm:text-2xl mt-4 text-green-500">
            Manage your tasks, events, and notes without the clutter.
        </h2>
        <a href="#"
            class="mt-6 inline-block fade-in-left bg-green-500 text-white px-6 py-2 rounded-[20px] hover:bg-green-600 transition duration-300">Get
            Started</a>
    </main>
    
    <!-- About section -->
    <section id="about"
        class="bg-white fade-in-left py-24 px-8 md:p-32 flex flex-col lg:flex-row items-center gap-16 min-h-screen">
        <div class="flex-1 fade-in-left text-left">
            <h1 class="text-3xl md:text-5xl font-bold text-green-500 mb-6">
                About Us
            </h1>
            <div class="md:hidden flex-1 py-3 flex justify-center">
                <img src="./image/image2.jpg" alt="SchedU Dashboard"
                    class="w-full max-w-md object-contain rounded-lg" />
            </div>
            <p class="text-lg md:text-xl text-black">
                Selamat datang di SchedU, platform yang dirancang khusus untuk
                membantu mahasiswa dalam mengelola jadwal perkuliahan, tugas, dan
                kolaborasi akademik secara efektif.
            </p>
            <p class="text-lg md:text-xl text-black mt-4">
                Kami memahami betapa pentingnya manajemen waktu dalam kehidupan
                perkuliahan, itulah sebabnya kami menyediakan fitur pengingat otomatis
                untuk jadwal kuliah, deadline tugas, serta sistem kolaborasi yang
                memudahkan komunikasi dalam kerja kelompok.
            </p>
        </div>
        <div class="flex-1 flex justify-center hidden md:block">
            <img src="./image/image2.jpg" alt="SchedU Dashboard" class="w-full max-w-md object-contain rounded-lg">
        </div>
    </section>

    <!-- Features section -->
    <section id="features"
        class="relative bg-green-600 min-h-screen p-8 md:p-16 lg:p-32 flex flex-col justify-center items-center gap-6">
        <div class="text-center w-full mb-10">
            <h1 class="text-3xl md:text-4xl font-bold text-white tracking-wide">Features</h1>
        </div>
        <div class="w-full max-w-4xl space-y-4">
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
    <section id="report" class="py-16 px-8 min-h-screen bg-gray-100">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl font-bold text-green-500 mb-12">Report</h1>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:pt-20">
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
                    <h2 class="text-5xl font-bold text-yellow-400 counter" data-target="27">
                        0
                    </h2>
                    <p class="text-lg font-semibold text-gray-700 mt-2">Instansi</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
                    <h2 class="text-5xl font-bold text-green-400 counter" data-target="177">
                        0
                    </h2>
                    <p class="text-lg font-semibold text-gray-700 mt-2">Teacher</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
                    <h2 class="text-5xl font-bold text-slate-800 counter" data-target="900">
                        0
                    </h2>
                    <p class="text-lg font-semibold text-gray-700 mt-2">Student</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-green-600 text-white py-8 px-6">
        <div class="container mx-auto flex flex-col md:flex-row justify-between items-center space-y-6 md:space-y-0">
            <!-- Logo dan Tagline -->
            <div class="text-center md:text-left">
                <img src="image/logowhite.png" alt="SchedU Logo" class="w-36 h-auto mx-auto md:mx-0 mb-2" />
                <p class="text-sm opacity-80">Your Daily Plans, All In One Place</p>
            </div>

            <!-- Quick Links & Contact -->
            <div class="flex flex-wrap justify-center md:justify-end space-x-8 text-center md:text-left">
                <!-- Quick Links -->
                <div>
                    <h3 class="font-bold mb-2 text-lg">Quick Links</h3>
                    <ul class="space-y-1">
                        <li><a href="#home" class="hover:underline">Home</a></li>
                        <li><a href="#about" class="hover:underline">About Us</a></li>
                        <li><a href="#features" class="hover:underline">Features</a></li>
                        <li><a href="#report" class="hover:underline">Report</a></li>
                    </ul>
                </div>
                <!-- Contact Info -->
                <div class="mt-4 md:mt-0">
                    <h3 class="font-bold mb-2 text-lg">Contact</h3>
                    <p class="text-sm opacity-80">contact@schedu.com</p>
                    <p class="text-sm opacity-80">+62 123 456 7890</p>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-white mt-6 pt-4 text-center text-sm opacity-80">
            &copy; 2025 SchedU. All rights reserved.
        </div>
    </footer>
</body>

<script>
    function toggleMenu() {
        let menu = document.getElementById("mobile-menu");
        let iconMenu = document.getElementById("icon-menu");
        let iconClose = document.getElementById("icon-close");
        menu.classList.toggle("hidden"); // Tampilkan/sembunyikan menu
        menu.classList.toggle("slide-down"); // Tampilkan/sembunyikan menu
        iconMenu.classList.toggle("hidden"); // Ganti ikon hamburger
        iconClose.classList.toggle("hidden"); // Ganti ikon X (close)
    }

    // Add scroll event listener to change navbar background
    window.addEventListener("scroll", function() {
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
    document.addEventListener("DOMContentLoaded", function() {
        if (window.scrollY > 50) {
            document.getElementById("navbar").classList.add("navbar-white");
        }
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const counters = document.querySelectorAll(".counter");
        const speed = 200; // Kecepatan animasi (angka lebih kecil = lebih cepat)

        const startCount = (counter) => {
            const target = +counter.getAttribute("data-target");
            const increment = target / speed;

            let count = 0;
            const updateCount = () => {
                if (count < target) {
                    count += increment;
                    counter.innerText = Math.ceil(count);
                    requestAnimationFrame(updateCount);
                } else {
                    counter.innerText = target;
                }
            };
            updateCount();
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    startCount(entry.target);
                    observer.unobserve(entry.target); // Mencegah animasi berulang
                }
            });
        });

        counters.forEach((counter) => observer.observe(counter));
    });
</script>
<script>
    document.querySelectorAll("nav a").forEach((anchor) => {
        anchor.addEventListener("click", function(e) {
            e.preventDefault();
            const targetId = this.getAttribute("href").substring(1);
            document.getElementById(targetId).scrollIntoView({
                behavior: "smooth",
            });
        });
    });
</script>

</html>

