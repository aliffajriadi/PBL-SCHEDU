<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>404 - Page Not Found</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 font-sans">

    <!-- 404 Content -->
    <section class="relative z-10 flex flex-col items-center justify-center min-h-screen text-center px-4 animate-fade-in">
        <!-- 404 Graphic -->
        <img src="{{asset('image/image4.png')}}" alt="logo" class="w-32 h-auto">
        <img 
            src="{{ asset('assets/404.svg') }}" 
            alt="404 Illustration" 
            class="w-64 md:w-96 mb-3"
        >
        
        <!-- 404 Text -->
        <h1 class="text-6xl md:text-8xl font-bold text-emerald-600 drop-shadow-lg">404</h1>
        <p class="text-xl md:text-2xl text-gray-700 mt-4 mb-8">Oops! The page you're looking for can't be found.</p>
        
        <!-- Back to Home Button -->
        <a 
            href="/" 
            class="bg-emerald-400 text-white px-6 py-2 rounded-lg hover:bg-emerald-500 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-emerald-300"
        >
            Back to Home
        </a>
    </section>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }
    </style>
</body>
</html>