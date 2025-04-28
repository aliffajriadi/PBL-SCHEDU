<x-layout-staff title="Dashboard" role="staff" :user="$user">


  <div class="grid md:grid-cols-3 gap-6">
      <!-- Left Column: My Account and Metrics -->
      <div class="md:col-span-2 space-y-6">
          <div class="bg-white p-4 md:p-6 rounded-xl shadow-md">
              <div class="flex justify-between mb-6 items-center">
                  <p class="text-lg md:text-2xl">My Account</p>
                  <a href="#"><img src="assets/Vector 6.svg" class="w-3 hover:w-4 transition-all duration-300" alt="accountpage" /></a>
              </div>
              <div class="bg-emerald-500 rounded-full p-2 flex text-white items-center">
                  <img src="{{asset('image/Ryan-Gosling.jpg')}}" class="w-14 h-14 rounded-full" alt="profile" />
                  <div class="ps-3">
                      <h4 class="text-base md:text-xl">{{ $user[0] }}</h4>
                      <p class="text-sm">{{ $user[1] }}</p>
                  </div>
              </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-4">
              <div class="flex items-center bg-white rounded-xl shadow-md p-4">
                  <div class="p-3 bg-emerald-100 rounded-full">
                      <img src="{{asset('assets/person.svg')}}" alt="Teacher Icon" class="w-6 h-6" />
                  </div>
                  <div class="ml-4">
                      <p class="text-sm">Total Teacher</p>
                      <p class="text-xl font-bold text-emerald-600">5</p>
                  </div>
              </div>
              
              <div class="flex items-center bg-white rounded-xl shadow-md p-4">
                  <div class="p-3 bg-yellow-100 rounded-full">
                      <img src="{{asset('assets/class.svg')}}" alt="Class Icon" class="w-6 h-6" />
                  </div>
                  <div class="ml-4">
                      <p class="text-sm">Total Class</p>
                      <p class="text-xl font-bold text-yellow-500">5</p>
                  </div>
              </div>
              
              <div class="flex items-center bg-white rounded-xl shadow-md p-4">
                  <div class="p-3 bg-blue-100 rounded-full">
                      <img src="{{asset('assets/groups.svg')}}" alt="Student Icon" class="w-6 h-6" />
                  </div>
                  <div class="ml-4">
                      <p class="text-sm">Total Students</p>
                      <p class="text-xl font-bold text-blue-500">58</p>
                  </div>
              </div>
          </div>
      </div>

      <!-- Right Column: Notifications -->
      <div class="md:col-span-1">
          <div class="bg-white p-4 md:p-6 rounded-xl shadow-md h-full flex flex-col">
              <h2 class="text-lg font-medium mb-4">Recent Notifications</h2>
              <div class="space-y-4">
                  <!-- Notification 1 -->
                  <div class="flex items-start p-3 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100">
                      <div class="p-2 bg-gray-100 rounded-full">
                          <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l9-6 9 6v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12v4m0 0h.01M12 8v2"/>
                          </svg>
                      </div>
                      <div class="ml-3">
                          <p class="text-sm text-gray-700">New account created: Apip Henriko Dachi</p>
                          <p class="text-xs text-gray-500">2 hours ago</p>
                      </div>
                  </div>
                  <!-- Notification 2 -->
                  <div class="flex items-start p-3 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100">
                      <div class="p-2 bg-gray-100 rounded-full">
                          <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l9-6 9 6v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12v4m0 0h.01M12 8v2"/>
                          </svg>
                      </div>
                      <div class="ml-3">
                          <p class="text-sm text-gray-700">Class A schedule updated</p>
                          <p class="text-xs text-gray-500">5 hours ago</p>
                      </div>
                  </div>
                  <!-- Notification 3 -->
                  <div class="flex items-start p-3 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100">
                      <div class="p-2 bg-gray-100 rounded-full">
                          <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l9-6 9 6v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12v4m0 0h.01M12 8v2"/>
                          </svg>
                      </div>
                      <div class="ml-3">
                          <p class="text-sm text-gray-700">System maintenance scheduled</p>
                          <p class="text-xs text-gray-500">1 day ago</p>
                      </div>
                  </div>
                  <!-- Notification 4 -->
                  <div class="flex items-start p-3 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100">
                      <div class="p-2 bg-gray-100 rounded-full">
                          <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l9-6 9 6v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12v4m0 0h.01M12 8v2"/>
                          </svg>
                      </div>
                      <div class="ml-3">
                          <p class="text-sm text-gray-700">System maintenance scheduled</p>
                          <p class="text-xs text-gray-500">1 day ago</p>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</x-layout>