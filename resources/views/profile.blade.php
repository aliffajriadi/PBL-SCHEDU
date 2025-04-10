<x-layout title="Profile" role="student">

    <!-- start here! -->
    <main class="flex-1 flex md:mt-0 flex-col text-emerald-800 w-full">
        <div class="max-w-3xl w-full md:max-w-full">
            <div class="bg-white p-6 rounded-xl shadow-md flex flex-col sm:flex-row items-center gap-4 w-full">
                <img src="image/Ryan-Gosling.jpg" class="w-16 h-16 rounded-full object-cover border-2 border-emerald-500" alt="Profile Picture">
                <div class="flex-1 text-center sm:text-left">
                    <h2 class="text-lg font-semibold">Ryan Gosling</h2>
                    <p class="text-gray-500">Student</p>
                </div>
                <button class="bg-green-500 text-white flex gap-2 px-4 py-2 rounded-lg hover:bg-green-600"><img src="assets/edit.svg" alt="icon edit"> <span>Edit profile</span></button>
            </div>

            <div class="bg-white p-6 mt-4 rounded-xl shadow-md w-full">
                <h3 class="text-lg mb-4">Personal Information</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-700 w-full">
                    <div>
                        <p class="font-semibold opacity-70">Reg No.</p>
                        <p>33124001007</p>
                    </div>
                    <div>
                        <p class="font-semibold opacity-70">School</p>
                        <p>SMPN 7 Batam</p>
                    </div>
                    <div>
                        <p class="font-semibold opacity-70">Name</p>
                        <p>Ryan Gosling Jr.</p>
                    </div>
                    <div>
                        <p class="font-semibold opacity-70">Gender</p>
                        <p>Male</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="font-semibold opacity-70">Address</p>
                        <p>Batam, Batam Centre, Polytechnic State, GU 702</p>
                    </div>
                    <div>
                        <p class="font-semibold opacity-70">Birth Date</p>
                        <p>04 Mei 1998</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- End  -->
</x-layout>
