<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
    <title>Login</title>
    <style>
      * {
        font-family: "Poppins", sans-serif;
      }
    </style>
  </head>
  <body class="bg-green-600 min-h-screen overflow-hidden bg-[url('/public/image/image1.png')] bg-cover">
    <div class="mt-16 ps-7 mb-10 md:hidden">
      <h2 class="text-white text-4xl font-semibold">
        Hello!
      </h2>
      <p class="text-md text-white">Welcome, Lets Sign to <br> Your Account</p>
    </div>

    <img src="/assets/calendar.png" class="w-24 h-auto z-30 md:hidden border-none outline-none absolute right-6 top-40" alt="calendar">
    <section class="flex h-screen">
      <div class="flex flex-col text-center items-center w-full rounded-t-4xl md:rounded-t-none
      md:justify-center h-screen bg-emerald-50
      ">
        <h2 class="font-semibold text-green-600 pt-12 text-3xl pb-6">
          Login
        </h2>
        <form id="form-login" action="/login" method="POST" class="md:w-full md:px-44">
          @csrf
          <div class="flex flex-col space-y-4">
            <div class="flex flex-col text-start">
              <label for="email" class="text-green-600 ps-2">Email</label>
              <input
                type="text"
                placeholder="Type here ..."
                class="border-2 border-green-600 p-2 rounded-2xl"
                id="email"
                name="email" 
                type="string"
                required/>
            </div>
            <div class="flex flex-col text-start">
              <label for="password" class="text-green-600 ps-2">Password</label>
              <input
                type="password"
                placeholder="Keep it secret! ..."
                class="border-2 border-green-600 p-2 rounded-2xl"
                id="password"
                name="password"
                type="password"
                required/>
            </div>

            <div class="flex flex-col text-start">
              <label for="password" class="text-green-600 ps-2">Login as :</label>
              <div class="flex items-center gap-x-3">
                <input id="login_participant" name="login_as" type="radio" checked class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 before:rounded-full before:bg-white not-checked:before:hidden checked:border-emerald-600 checked:bg-emerald-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:before:bg-gray-400 forced-colors:appearance-auto forced-colors:before:hidden" />
                <label for="login_participant" class="block text-sm/6 font-medium text-gray-900">Teacher/Student</label>
              </div>
              <div class="flex items-center gap-x-3">
                <input id="login_organizer" name="login_as" type="radio" class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 before:rounded-full before:bg-white not-checked:before:hidden checked:border-emerald-600 checked:bg-emerald-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:before:bg-gray-400 forced-colors:appearance-auto forced-colors:before:hidden" />
                <label for="login_organizer" class="block text-sm/6 font-medium text-gray-900">Instance Organizer</label>
              </div>
            </div>

            <button type="submit" class="bg-green-600 mt-3 text-white p-2 rounded-2xl">
              Sign in
            </button>
          </div>
        </form>
        
        <img src="image/image4.png" class="w-32 mt-12 h-auto z-30 md:fixed md:mt-0 md:top-0 md:left-0" alt="calender">
      </div>
      <div
        class="bg-green-600 w-9/12 h-screen bg-[url('/public/image/image1.png')] bg-cover flex-col text-center justify-center items-center gap-y-10 hidden md:flex"
      >
        <h2 class="text-slate-50 font-semibold text-3xl">Lorem ipsum dolor sit amet.

        </h2>
        <p class="text-slate-50 px-24">
          Lorem ipsum dolor sit, amet consectetur adipisicing elit. Praesentium sit error odio tenetur amet quas ad?
        </p>
        <a href="/"
          class="border-2 border-slate-50 text-white rounded-3xl px-2 py-1 hover:bg-yellow-400 hover:text-green-600"
        >
          Back to Home
        </a>
      </div>
    </section>
  </body>

      <x-success></x-success>

  <script>

    const form = document.getElementById('form-login');
    form.addEventListener('submit', function (e) {
            
      e.preventDefault()

      if (document.getElementById('login_participant').checked) {
        form.action = '/login';
      }else if(document.getElementById('login_organizer').checked){
        form.action = '/staff/login';
      }

      form.submit();
    })

    @if(session('error'))
      open_fail("{{session('error')}}");
    @endif



  </script>

</html>

