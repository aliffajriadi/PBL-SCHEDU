<x-layout 
    title="Notifications" 
    role="{{ $role }}" 
    :user="$user" 
    :image="$userData->profile_pic !== null ? asset('storage/' . $userData->instance->folder_name . '/' . $userData->profile_pic) : 'image/Ryan-Gosling.jpg'"
>
    {{-- Header with Search and Back Button --}}
    <div class="bg-white mb-4 flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-0 sm:justify-between p-4 shadow-md rounded-2xl">
        <input 
            type="text" 
            id="search" 
            placeholder="Search notifications..." 
            class="flex-1 sm:max-w-xs border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all duration-300"
            oninput="debounce_search()"
        />
        <button 
            onclick="location.href='/dashboard'"
            class="bg-emerald-500 text-white hover:bg-emerald-600 px-4 py-2 rounded-lg text-sm transition-all duration-300 whitespace-nowrap"
        >
            ← Back to Dashboard
        </button>
    </div>

    {{-- Main Content --}}
    <div class="flex flex-col lg:flex-row gap-4">
        {{-- Left Column: Notification List --}}
        <div class="bg-white p-4 w-full lg:w-5/12 shadow-md rounded-2xl animate-fade-in-left">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Notification List</h2>
            
            {{-- Filter Buttons --}}
            @if($role !== 'staff')
                <div class="flex flex-wrap gap-2 mb-4">
                    <button 
                        id="filter-all" 
                        onclick="filterNotifications('all')"
                        class="bg-emerald-500 text-white px-4 py-2 rounded-lg hover:bg-emerald-600 transition-all duration-300 active-filter text-sm"
                    >
                        All
                    </button>
                    <button 
                        id="filter-personal" 
                        onclick="filterNotifications('personal')"
                        class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition-all duration-300 text-sm"
                    >
                        Personal
                    </button>
                    <button 
                        id="filter-group" 
                        onclick="filterNotifications('group')"
                        class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition-all duration-300 text-sm"
                    >
                        Group
                    </button>
                </div>
            @endif

            {{-- Notification List --}}
            <div id="notif-list" class="space-y-3 max-h-96 lg:max-h-none overflow-y-auto">
                {{-- Notifications will be populated by JavaScript --}}
            </div>

            <x-pagination />
        </div>

        {{-- Right Column: Desktop Preview --}}
        <div class="hidden lg:block w-full lg:w-7/12">
            {{-- Content Open State --}}
            <div id="content-open" class="hidden bg-emerald-400 p-4 shadow-md rounded-2xl h-96">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 text-white mb-4">
                    <div class="flex-1 min-w-0">
                        <h2 id="content-title" class="text-lg xl:text-xl font-semibold text-white break-words"></h2>
                        <p id="content-date" class="text-xs text-gray-100 mt-1">Created at...</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <button
                            onclick="closePreview()"
                            class="text-sm flex py-2 px-3 items-center gap-1 cursor-pointer bg-amber-500 rounded-lg hover:opacity-75 transition-all duration-300"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            <span class="text-xs">Close</span>
                        </button>

                        @if($role !== 'staff')
                            <button 
                                id="content-delete" 
                                class="text-sm py-2 px-3 flex items-center gap-1 cursor-pointer bg-red-500 rounded-lg hover:opacity-75 transition-all duration-300"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                <span class="text-xs">Delete</span>
                            </button>
                        @endif
                    </div>
                </div>
                <div class="bg-emerald-50 p-4 rounded-2xl h-72 overflow-auto">
                    <p id="content-content" class="text-sm text-gray-800 whitespace-pre-wrap"></p>
                </div>
            </div>

            {{-- Content Close State --}}
            <div id="content-close" class="bg-white flex flex-col justify-center items-center p-6 shadow-md rounded-2xl h-96 animate-fade-in-right">
                
                    <svg class="w-16 h-16 text-emerald-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <p class="text-lg font-semibold text-gray-800 mb-2">Select a Notification</p>
                    <p class="text-sm text-gray-600">Click a notification on the left to view details.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile Modal for Notification Preview --}}
    <div id="mobile-modal" class="fixed inset-0 backdrop-blur-sm bg-black/50 z-50 hidden lg:hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl w-full max-w-md max-h-[90vh] flex flex-col">
                {{-- Modal Header --}}
                <div class="flex justify-between items-center p-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Notification Details</h3>
                    <button onclick="closeMobileModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                {{-- Modal Content --}}
                <div class="flex-1 overflow-y-auto p-4">
                    <div class="mb-4">
                        <h4 id="mobile-title" class="text-lg font-semibold text-gray-800 mb-2"></h4>
                        <p id="mobile-date" class="text-xs text-gray-500"></p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p id="mobile-content" class="text-sm text-gray-700 whitespace-pre-wrap"></p>
                    </div>
                </div>
                
                {{-- Modal Footer --}}
                @if($role !== 'staff')
                    <div class="p-4 border-t border-gray-200">
                        <button 
                        onclick="closeMobileModal()"
                            id="mobile-delete" 
                            
                            class="w-full bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 transition-all duration-300 flex items-center justify-center gap-2"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete Notificationasd
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <x-delete-modal />

    {{-- JavaScript --}}
    <script>
        let search_type = '';
        const debounce_search = debounce(search, 500);
        const svg_img_personal = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>`;
        const svg_img_group = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>`;

        function debounce_refresh() {
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
        

        function closePreview() {
            document.getElementById('content-open').classList.add('hidden');
            document.getElementById('content-close').style.display = 'block';
        }

        function openMobileModal(title, date, content, deleteCallback) {
            document.getElementById('mobile-title').innerHTML = title;
            document.getElementById('mobile-date').innerHTML = date;
            document.getElementById('mobile-content').innerHTML = content;
            
            @if($role !== 'staff')
            document.getElementById('mobile-delete').onclick = () => deleteCallback(); 

            @endif
            
            document.getElementById('mobile-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeMobileModal() {
            document.getElementById('mobile-modal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        function isMobile() {
            return window.innerWidth < 1024;
        }

        @if($role !== 'staff')
            function delete_data(id) {
                api_destroy('/notification/api', id).then(response => {
                    if (isMobile()) {
                        closeMobileModal();
                    } else {
                        closePreview();
                    }
                    search();
                    closeDeleteModal();
                });
            }

            function set_content(notification) {
                const notif = notification.data.notification;
                const notif_count = notification.notif_count;
                
                if (notif_count === 0) {
                    document.getElementById('notification-badge').classList.add('hidden');
                    document.getElementById('side-notif-badge').classList.add('hidden');
                } else {
                    document.getElementById('notification-badge').innerHTML = notif_count;
                    document.getElementById('side-notif-badge').innerHTML = notif_count;
                }

                if (isMobile()) {
    openMobileModal(
        notif.title,
        notif.created_at,
        notif.content,
        () => {
            closeMobileModal(); // Tutup modal detail
            openDeleteModal(notif.id, delete_data); // Kirim ID yang benar
        }
    );



                } else {
                    document.getElementById('content-title').innerHTML = notif.title;
                    document.getElementById('content-date').innerHTML = notif.created_at;
                    document.getElementById('content-content').innerHTML = notif.content;
                    document.getElementById('content-open').classList.remove('hidden');
                    document.getElementById('content-close').style.display = 'none';
                }
            }

            function open_content(id) {
                const dot = document.getElementById(`dot${id}`);
                if (dot) {
                    dot.remove();
                }

                get_data(`/notification/api`, set_content, id);
                
                if (!isMobile()) {
                    document.getElementById('content-delete').onclick = () => {
                        openDeleteModal(id, delete_data);
                    }
                }
            }

            function show_list(notifications) {
                const parent = document.getElementById('notif-list');
                parent.innerHTML = '';

                if (notifications.datas.last_page <= 1) {
                    document.getElementById('pagination').classList.add('hidden');
                } else {
                    document.getElementById('pagination').classList.remove('hidden');
                }

                const datas = notifications.datas;
                max_page = datas.last_page;

                datas.data.forEach((notification, index) => {
                    const notif = notification.notification;
                    const type = notif.group_id ? 'group' : 'personal';
                    const is_read = notification.is_read;

                    parent.innerHTML += `
                        <button 
                            onclick="open_content(${notification.notif_id})"
                            class="w-full text-left bg-white p-3 rounded-lg shadow-sm hover:bg-emerald-50 hover:shadow-md transition-all duration-300 active:scale-95 notification-item"
                            data-type="${type}"
                        >
                            <div class="flex items-start gap-3">
                                <div class="p-2 bg-emerald-100 rounded-full flex-shrink-0">
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        ${type === 'group' ? svg_img_group : svg_img_personal}
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start gap-2">
                                        <div class="flex items-center gap-2 flex-1 min-w-0">
                                            <h3 class="text-sm font-semibold ${is_read ? 'text-gray-600' : 'text-gray-900'} truncate">
                                                ${notif.title}
                                            </h3>
                                            ${!is_read ? `<span id="dot${notification.notif_id}" class="w-2 h-2 bg-red-500 rounded-full flex-shrink-0"></span>` : ''}
                                        </div>
                                        <span class="text-xs font-semibold text-white bg-emerald-500 rounded-full px-2 py-1 flex-shrink-0">${index + 1}</span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1 line-clamp-2">${notif.content}</p>
                                    <p class="text-xs text-gray-500 mt-1">Received ${notification.created_at}</p>
                                </div>
                            </div>
                        </button>
                    `;
                });
            }

            function search() {
                const query = `keyword=${document.getElementById('search').value}&type=${search_type}`;
                get_data(`/notification/api?${query}&page=${current_page}`, show_list);
            }

            function filterNotifications(type) {
                const allButton = document.getElementById("filter-all");
                const personalButton = document.getElementById("filter-personal");
                const groupButton = document.getElementById("filter-group");

                // Reset button styles
                [allButton, personalButton, groupButton].forEach(btn => {
                    btn.classList.remove("bg-emerald-500", "text-white", "active-filter");
                    btn.classList.add("bg-gray-200", "text-gray-800");
                });

                // Set active button and search type
                if (type === "all") {
                    search_type = '';
                    allButton.classList.remove("bg-gray-200", "text-gray-800");
                    allButton.classList.add("bg-emerald-500", "text-white", "active-filter");
                } else if (type === "personal") {
                    search_type = 'personal';
                    personalButton.classList.remove("bg-gray-200", "text-gray-800");
                    personalButton.classList.add("bg-emerald-500", "text-white", "active-filter");
                } else if (type === "group") {
                    search_type = 'group';
                    groupButton.classList.remove("bg-gray-200", "text-gray-800");
                    groupButton.classList.add("bg-emerald-500", "text-white", "active-filter");
                }

                search();
            }

        @else
            {{-- Staff specific functions --}}
            function show_list(notifications) {
                const parent = document.getElementById('notif-list');
                parent.innerHTML = '';

                if (notifications.datas.last_page <= 1) {
                    document.getElementById('pagination').classList.add('hidden');
                } else {
                    document.getElementById('pagination').classList.remove('hidden');
                }

                const datas = notifications.datas;

                datas.forEach((notification) => {
                    parent.innerHTML += `
                        <button 
                            onclick="open_content(${notification.id})"
                            class="w-full text-left bg-white p-3 rounded-lg shadow-sm hover:bg-emerald-50 hover:shadow-md transition-all duration-300 active:scale-95 notification-item"
                        >
                            <div class="flex items-start gap-3">
                                <div class="p-2 bg-emerald-100 rounded-full flex-shrink-0">
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        ${svg_img_group}
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start gap-2">
                                        <div class="flex items-center gap-2 flex-1 min-w-0">
                                            <h3 class="text-sm font-semibold ${notification.is_readed ? 'text-gray-600' : 'text-gray-900'} truncate">
                                                ${notification.title}
                                            </h3>
                                            ${!notification.is_readed ? `<span id="dot${notification.id}" class="w-2 h-2 bg-red-500 rounded-full flex-shrink-0"></span>` : ''}
                                        </div>
                                        <span class="text-xs font-semibold text-white bg-emerald-500 rounded-full px-2 py-1 flex-shrink-0">!</span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1 line-clamp-2">${notification.description}</p>
                                    <p class="text-xs text-gray-500 mt-1">Received ${notification.created_at}</p>
                                </div>
                            </div>
                        </button>
                    `;
                });
            }

            function search() {
                const query = `keyword=${document.getElementById('search').value}&type=${search_type}`;
                get_data(`/staff/notifications?${query}`, show_list);
            }

            function set_content(notif) {
                const notification = notif.data;
                
                if (isMobile()) {
                    openMobileModal(
                        notification.title,
                        notification.created_at,
                        notification.description,
                        () => openDeleteModal(notification.id, delete_data)
                    );
                } else {
                    document.getElementById('content-title').innerHTML = notification.title;
                    document.getElementById('content-date').innerHTML = notification.created_at;
                    document.getElementById('content-content').innerHTML = notification.description;
                    document.getElementById('content-open').classList.remove('hidden');
                    document.getElementById('content-close').style.display = 'none';
                }
            }

            function open_content(id) {
                const dot = document.getElementById(`dot${id}`);
                if (dot) {
                    dot.remove();
                }

                get_data(`/staff/notifications`, set_content, id);
                
                if (!isMobile()) {
                    document.getElementById('content-delete').onclick = () => {
                        openDeleteModal(id, delete_data);
                    }
                }
            }

            function delete_data(id) {
                api_destroy('/staff/notifications', id).then(response => {
                    if (isMobile()) {
                        closeMobileModal();
                    } else {
                        closePreview();
                    }
                    search();
                    closeDeleteModal();
                });
            }
        @endif

        // Initialize
        search();

        // Handle window resize
        window.addEventListener('resize', () => {
            if (isMobile()) {
                closeMobileModal();
            }
        });
    </script>

    {{-- Custom Animation Styles --}}
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
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-layout>