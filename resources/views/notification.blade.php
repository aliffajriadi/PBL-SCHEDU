<x-layout title="Notifications" role="{{ $role }}" :user="$user">
    <!-- Header with Search and Back Button -->
    <div class="bg-white mb-4 flex flex-row items-center justify-between p-4 shadow-md rounded-2xl">
        <input 
            type="text" 
            id="search" 
            placeholder="Search notifications..." 
            class="w-full sm:w-1/3 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all duration-300"
            oninput="debounce_search()"
        />
        <button 
            onclick="location.href='/dashboard'"
            class="bg-emerald-500 text-white hover:bg-emerald-600 px-4 py-2 rounded-lg text-sm transition-all duration-300"
        >
            ← Back to Dashboard
        </button>
    </div>

    <!-- Main Content -->
    <div class="flex gap-4">
        <!-- Left Column: Notification List -->
        <div class="bg-white p-4 w-full md:w-5/12 shadow-md rounded-2xl animate-fade-in-left">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Notification List</h2>
            <!-- Filter Buttons -->

            @if($role !== 'staff')

                <div class="flex gap-2 mb-4">
                    <button 
                        id="filter-all" 
                        onclick="filterNotifications('all')"
                        class="bg-emerald-500 text-white px-4 py-1.5 rounded-lg hover:bg-emerald-600 transition-all duration-300 active-filter text-sm"
                    >
                        All
                    </button>
                    <button 
                        id="filter-personal" 
                        onclick="filterNotifications('personal')"
                        class="bg-gray-200 text-gray-800 px-4 py-1.5 rounded-lg hover:bg-gray-300 transition-all duration-300 text-sm"
                    >
                        Personal
                    </button>
                    <button 
                        id="filter-group" 
                        onclick="filterNotifications('group')"
                        class="bg-gray-200 text-gray-800 px-4 py-1.5 rounded-lg hover:bg-gray-300 transition-all duration-300 text-sm"
                    >
                        Group
                    </button>
                </div>

            @endif

            <!-- Notification List -->
            <div id="notif-list" class="space-y-3">

                    
            </div>


            <x-pagination></x-pagination>
        </div>

        <!-- Right Column: Preview -->
        <div id="content-open" class="hidden bg-emerald-400 p-3 w-full md:w-7/12 shadow-md rounded-2xl h-96">
            <div class="flex justify-between items-center text-white">
                <div>
                    <h2 id="content-title" class="text-lg md:text-xl font-semibold text-white"></h2>
                    <p id="content-date" class="text-xs text-gray-100">Created at 27 November 2024</p>
                </div>
                <div class="flex flex-col md:flex-row gap-2">
                    <button
                        class="text-sm flex py-1 items-center gap-1 cursor-pointer bg-amber-500 px-2 rounded-lg hover:opacity-75 transition-all duration-300">
                        <img src="{{ asset('assets/edit.svg') }}" class="w-4 h-auto">
                        <p class="text-xs md:text-md">Close</p>
                    </button>

                    <button id="content-delete" 
                        class="text-sm py-1 flex items-center gap-1 cursor-pointer bg-red-500 px-2 rounded-lg hover:opacity-75 transition-all duration-300">
                        <img src="{{ asset('assets/edit.svg') }}" class="w-4 h-auto">
                        <p class="text-xs md:text-md">Delete</p>
                    </button>
                </div>
            </div>
            <div class="bg-emerald-50 p-3 mt-3 rounded-2xl h-72 overflow-auto">
                <p id="content-content" class="text-sm"></p>
            </div>
        </div>

        <div id="content-close" class="bg-white flex-col justify-center items-center md:flex p-6 shadow-md rounded-2xl w-7/12 h-96 animate-fade-in-right">
            <div class=" bg-gradient-to-br from-emerald-100 to-emerald-300 rounded-2xl p-8 text-center">
                <svg class="w-16 h-16 text-emerald-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l9-6 9 6v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12v4m0 0h.01M12 8v2"/>
                </svg>
                <p class="text-lg font-semibold text-gray-800">Select a Notification</p>
                <p class="text-sm text-gray-600 mt-2">Click a notification on the left to view details.</p>
            </div>
        </div>
    </div>

    <!-- Script for Search and Filter -->
    <script>

        let search_type = '';
        const debounce_search = debounce(search, 500);
        const svg_img_personal = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>`;
        const svg_img_group = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>`;


        function debounce_refresh()
        {
            current_page = 1;
            debounce_search();
        }


        function getSearch() {
            const input = document.getElementById("search").value.toLowerCase();
            const items = document.querySelectorAll(".notification-item");

            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                const isVisible = text.includes(input);
                item.style.display = isVisible ? "block" : "none";
            });
        }

        @if($role !== 'staff')

        function delete_data(id)
        {
            api_destroy('/notification/api', id).then(response => {
                document.getElementById('content-open').classList.add('hidden');
                document.getElementById('content-close').style.display = 'block';
                search()
            });
        }

        function set_content(notification)
        {
            notif = notification.data.notification;

            // console.log(notification.status)

            notif_count = notification.notif_count;
            if(notif_count === 0){
                document.getElementById('notification-badge').classList.add('hidden');
                document.getElementById('side-notif-badge').classList.add('hidden');
            }else{
                document.getElementById('notification-badge').innerHTML = notif_count;
                document.getElementById('side-notif-badge').innerHTML = notif_count;
            }

            document.getElementById('content-title').innerHTML = notif.title;
            document.getElementById('content-date').innerHTML = notif.created_at;
            document.getElementById('content-content').innerHTML = notif.content;
        }

        function open_content(id)
        {
            const dot = document.getElementById(`dot${id}`);

            if(dot){
                dot.remove();
            }

            get_data(`/notification/api`, set_content, id);  
            document.getElementById('content-open').classList.remove('hidden');
            document.getElementById('content-close').style.display = 'none';
            document.getElementById('content-delete').onclick = () => {
                delete_data(id)
            }
        }

        function show_list(notifications)
        {
            const parent = document.getElementById('notif-list');
            parent.innerHTML = '';
            let notif;
            let type;
            let is_read;

            if(notifications.datas.from === null) document.getElementById('pagination').classList.add('hidden'); 
            else document.getElementById('pagination').classList.remove('hidden');  

            let datas = notifications.datas;
            max_page = datas.last_page;

            datas.data.forEach((notification, index) => {

                notif = notification.notification;
                type = notif.group_id ? 'group' : 'personal';

                is_read = notification.is_read
                parent.innerHTML += `
                    <a 
                        onclick="open_content(${notification.notif_id})"
                        class="block bg-white p-3 rounded-lg shadow-sm hover:bg-emerald-50 hover:shadow-md transition-all duration-300 active:scale-95 notification-item"
                        data-type="${type}"
                    >
                        <div class="flex items-start gap-3">
                            <!-- Icon -->
                            <div class="p-2 bg-emerald-100 rounded-full flex-shrink-0">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    ${type === 'group' ? svg_img_group : svg_img_personal}
                                </svg>
                            </div>
                            <!-- Content -->
                            <div class="flex-1">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-2">
                                        <h3 class="text-md font-semibold ${ is_read === true ? 'text-gray-600' : 'text-gray-1000 font-bold' }">
                                            ${notif.title}
                                        </h3>
                                        ${ !is_read ? '<span id="dot' + notification.notif_id + '" class="w-2 h-2 bg-red-500 rounded-full"></span>' : '' }
                                    </div>
                                    <span class="text-xs font-semibold text-white bg-emerald-500 rounded-full px-2 py-1">${index+ 1}</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1 ${ is_read === 0 ? 'opacity-75' : '' }">${ notif.content }</p>
                                <p class="text-xs text-gray-500 mt-1">Received ${ notification.created_at }</p>
                            </div>
                        </div>
                    </a>
                `;
            });
        }

        function search()
        {   
            const query = `keyword=${document.getElementById('search').value}&type=${search_type}`; 
            get_data(`/notification/api?${query}&page=${current_page}`, show_list);
            
        }
        
        search();

        function filterNotifications(type) {
            const items = document.querySelectorAll(".notification-item");
            const allButton = document.getElementById("filter-all");
            const personalButton = document.getElementById("filter-personal");
            const groupButton = document.getElementById("filter-group");

            // Reset button styles
            allButton.classList.remove("bg-emerald-500", "text-white", "active-filter");
            personalButton.classList.remove("bg-emerald-500", "text-white", "active-filter");
            groupButton.classList.remove("bg-emerald-500", "text-white", "active-filter");
            allButton.classList.add("bg-gray-200", "text-gray-800");
            personalButton.classList.add("bg-gray-200", "text-gray-800");
            groupButton.classList.add("bg-gray-200", "text-gray-800");

            // Highlight active button
            if (type === "all") {
                search_type = '';
                allButton.classList.remove("bg-gray-200", "text-gray-800");
                allButton.classList.add("bg-emerald-500", "text-white", "active-filter");
                search();
            } else if (type === "personal") {
                search_type = 'personal';
                personalButton.classList.remove("bg-gray-200", "text-gray-800");
                personalButton.classList.add("bg-emerald-500", "text-white", "active-filter");
                search();
            } else if (type === "group") {
                search_type = 'group';
                groupButton.classList.remove("bg-gray-200", "text-gray-800");
                groupButton.classList.add("bg-emerald-500", "text-white", "active-filter");
                search();
                
            }

            // Filter notifications
            items.forEach(item => {
                const itemType = item.getAttribute("data-type");
                item.style.display = (type === "all" || itemType === type) ? "block" : "none";
            });

            // Reapply search filter if search input is active
            getSearch();
        }
        @else
            function show_list(notifications)
            {
                const parent = document.getElementById('notif-list');
                parent.innerHTML = '';
                let notif;
                let is_read;

                if(notifications.datas.from === null) document.getElementById('pagination').classList.add('hidden'); 
                else document.getElementById('pagination').classList.remove('hidden');  

                let datas = notifications.datas;

                datas.forEach((notification) => {

                    is_read = notification.is_read
                    parent.innerHTML += `
                        <a 
                            onclick="open_content(${notification.id})"
                            class="block bg-white p-3 rounded-lg shadow-sm hover:bg-emerald-50 hover:shadow-md transition-all duration-300 active:scale-95 notification-item"
                        >
                            <div class="flex items-start gap-3">
                                <!-- Icon -->
                                <div class="p-2 bg-emerald-100 rounded-full flex-shrink-0">
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        ${svg_img_group}
                                    </svg>
                                </div>
                                <!-- Content -->
                                <div class="flex-1">
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center gap-2">
                                            <h3 class="text-md font-semibold ${ notification.is_readed === true ? 'text-gray-600' : 'text-gray-1000 font-bold' }">
                                                ${notification.title}
                                            </h3>
                                            ${ !notification.is_readed ? '<span id="dot' + notification.id + '" class="w-2 h-2 bg-red-500 rounded-full"></span>' : '' }
                                        </div>
                                        <span class="text-xs font-semibold text-white bg-emerald-500 rounded-full px-2 py-1">!</span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1 ${ notification.is_readed === 0 ? 'opacity-75' : '' }">${ notification.description }</p>
                                    <p class="text-xs text-gray-500 mt-1">Received ${ notification.created_at }</p>
                                </div>
                            </div>
                        </a>
                    `;
                });
            }

            function search()
            {
                const query = `keyword=${document.getElementById('search').value}&type=${search_type}`; 
                get_data(`/staff/notifications?${query}`, show_list);
            }

            function set_content(notif)
            {
                console.log(notif);
                notif = notif.data
                document.getElementById('content-title').innerHTML = notif.title;
                document.getElementById('content-date').innerHTML = notif.created_at;
                document.getElementById('content-content').innerHTML = notif.description;
            }

            function open_content(id)
            {
                const dot = document.getElementById(`dot${id}`);

                if(dot){
                    dot.remove();
                }

                get_data(`/staff/notifications`, set_content, id);  
                document.getElementById('content-open').classList.remove('hidden');
                document.getElementById('content-close').style.display = 'none';
                document.getElementById('content-delete').onclick = () => {
                    delete_data(id)
                }
            }

            function delete_data(id)
            {
                api_destroy('/staff/notifications', id).then(response => {
                    document.getElementById('content-open').classList.add('hidden');
                    document.getElementById('content-close').style.display = 'block';
                    search();
                });
            }


        @endif

    </script>

    <!-- Custom Animation -->
    <style>
        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .animate-fade-in-left {
            animation: fadeInLeft 0.5s ease-out forwards;
        }
        .animate-fade-in-right {
            animation: fadeInRight 0.5s ease-out forwards;
        }
    </style>
</x-layout>