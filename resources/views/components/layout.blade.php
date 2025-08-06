@props(['role', 'title', 'user', 'image'])

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
    <nav id="mobileNavbar"
        class="flex justify-between px-6 bg-white/50 backdrop-blur-sm fixed top-0 w-full left-0 py-2 shadow-md md:hidden items-center z-40 transition-transform duration-300 transform">

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
            <img src="{{ $image }}"
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
        <x-modal.chat />

    </main>



    <script>
        function toggleChatModal() {
            const modal = document.getElementById('chat-modal');
            modal.classList.toggle('hidden');
        }

        async function sendMessage(event) {
            event.preventDefault();

            const input = document.getElementById('chat-input');
            const messages = document.getElementById('chat-messages');

            const userMessage = input.value.trim();
            if (!userMessage) return;

            // Tampilkan pesan user
            messages.innerHTML += `<div class="text-right"><span class="bg-blue-100 text-blue-900 px-3 py-1 rounded-md inline-block">${userMessage}</span></div>`;
            input.value = '';
            messages.scrollTop = messages.scrollHeight;

            // Kirim ke API
            try {
                const response = await fetch('/api/gemini', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message: userMessage })
                });

                if (response.status === 429) {
                    const warning = "You only can chat 5x per minute. Please wait and try again.";
                    messages.innerHTML += `<div><span class="text-yellow-700 bg-yellow-100 px-3 py-1 rounded-md inline-block">${warning}</span></div>`;
                    messages.scrollTop = messages.scrollHeight;
                    return; // stop di sini
                }

                const data = await response.json();

                const result = data.candidates?.[0]?.content?.parts?.[0]?.text || 'No response.';
                console.log(result);

                messages.innerHTML += `<div><span class="bg-gray-100 text-gray-900 px-3 py-1 rounded-md inline-block">${result}</span></div>`;
                messages.scrollTop = messages.scrollHeight;
            } catch (error) {
                console.error(error);
                messages.innerHTML += `<div><span class="text-red-500 text-xs">Terjadi kesalahan. Coba lagi.</span></div>`;
            }
 
        }
    </script>

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