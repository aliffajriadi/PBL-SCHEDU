<x-layout title="Notes" role="teacher">
    <!-- Header Section -->
    <div class="bg-white flex flex-col sm:flex-row items-center justify-between p-4 mt-3 mb-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
        <button id="openModalBtn" class="bg-emerald-500 text-white text-sm px-4 py-2 rounded-xl hover:bg-emerald-600 transition-all flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add Note
        </button>
        <div class="flex items-center space-x-3 mt-3 sm:mt-0">
            <form id="searchForm" class="w-full sm:w-auto">
                <input 
                    type="text" 
                    id="searchInput" 
                    name="search" 
                    class="w-full sm:w-64 px-3 py-2 bg-emerald-100 rounded-xl placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500" 
                    placeholder="Search notes..."
                >
            </form>
            <button id="toggleDarkMode" class="p-2 rounded-full bg-gray-200 hover:bg-gray-300 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </button>
        </div>
    </div>

    <!-- Notes Section -->
    <section class="flex flex-col md:flex-row md:space-x-6 space-y-6 md:space-y-0">
        <!-- Notes List -->
        <div class="bg-white w-full md:w-5/12 rounded-xl p-4 shadow-md hover:shadow-lg transition-all duration-300 max-h-[70vh] overflow-hidden">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                Notes List
            </h3>
            <div id="notesList" class="space-y-3 overflow-y-auto max-h-[60vh] pr-2"></div>
        </div>

        <!-- Note Display with Notebook Lines -->
        <div id="noteDisplay" class="bg-white w-full md:w-7/12 rounded-xl p-4 shadow-md hover:shadow-lg transition-all duration-300 max-h-[70vh] overflow-y-auto hidden relative">
            <div id="noteContent" class="text-black h-full p-4 relative z-10">
                <p class="text-lg">Select a note to view its content</p>
            </div>
        </div>
    </section>

    @php
    $data = [
        ['id' => '1', 'title' => 'belanja', 'content' => 'beli baju', 'pinned' => false, 'timestamp' => '2025-03-28 10:00'],
        ['id' => '2', 'title' => 'makan', 'content' => 'makan nasi', 'pinned' => true, 'timestamp' => '2025-03-28 12:00'],
        ['id' => '3', 'title' => 'minum', 'content' => 'minum air', 'pinned' => false, 'timestamp' => '2025-03-28 14:00']
    ]
    @endphp

    <script>
        let notes = @json($data);
        let selectedNoteId = null;

        // DOM Elements
        const searchInput = document.getElementById('searchInput');
        const notesList = document.getElementById('notesList');
        const noteDisplay = document.getElementById('noteDisplay');
        const toggleDarkMode = document.getElementById('toggleDarkMode');

        // Render Notes List
        function renderNotesList(searchTerm = '') {
            notesList.innerHTML = '';
            const filteredNotes = notes
                .filter(note => note.title.toLowerCase().includes(searchTerm.toLowerCase()) || note.content.toLowerCase().includes(searchTerm.toLowerCase()))
                .sort((a, b) => b.pinned - a.pinned || new Date(b.timestamp) - new Date(a.timestamp));

            filteredNotes.forEach(note => {
                const noteElement = document.createElement('div');
                noteElement.classList.add('p-3', 'rounded-lg', 'cursor-pointer', 'transition-all', 'flex', 'justify-between', 'items-center');
                noteElement.classList.add(selectedNoteId === note.id ? 'bg-emerald-200' : 'bg-gray-100', 'hover:bg-emerald-100');
                noteElement.innerHTML = `
                    <div>
                        <h4 class="font-medium ${note.pinned ? 'text-emerald-600' : ''}">${note.title}</h4>
                        <p class="text-xs text-gray-500">${new Date(note.timestamp).toLocaleString()}</p>
                    </div>
                `;
                noteElement.addEventListener('click', () => {
                    selectedNoteId = note.id;
                    renderNotesList(searchInput.value);
                    displayNoteContent(note);
                });
                notesList.appendChild(noteElement);
            });
        }

        // Display Note Content
        function displayNoteContent(note) {
            noteDisplay.classList.remove('hidden');
            noteDisplay.innerHTML = `
                <div class="text-black p-4 relative z-10">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="text-lg font-semibold underline-red">${note.title}</h3>
                        <span class="text-xs opacity-70">${note.pinned ? '📌 Pinned' : ''}</span>
                    </div>
                    <p class="text-sm mb-3">${note.content}</p>
                    <p class="text-xs opacity-70">Last updated: ${new Date(note.timestamp).toLocaleString()}</p>
                    <div class="flex justify-end space-x-2 mt-4">
                        <button class="text-black hover:text-emerald-600">✏️ Edit</button>
                        <button class="text-black hover:text-red-500">🗑️ Delete</button>
                    </div>
                </div>
            `;
            if (window.innerWidth < 768) {
                noteDisplay.classList.add('fixed', 'inset-0', 'z-50', 'rounded-none', 'p-6');
                noteDisplay.innerHTML += `<button id="closeNoteBtn" class="absolute top-4 right-4 text-black">✖</button>`;
                document.getElementById('closeNoteBtn').addEventListener('click', () => noteDisplay.classList.add('hidden'));
            }
        }

        // Event Listeners
        searchInput.addEventListener('input', () => renderNotesList(searchInput.value));
        toggleDarkMode.addEventListener('click', () => document.documentElement.classList.toggle('dark'));

        // Dark Mode Styles + Notebook Lines
        const customStyles = `
            .dark .bg-white { background-color: #1f2937; color: #e5e7eb; }
            .dark .bg-gray-100 { background-color: #374151; }
            .dark .bg-emerald-200 { background-color: #065f46; }
            .dark .text-gray-800 { color: #e5e7eb; }
            .dark .text-gray-500 { color: #9ca3af; }
            #noteDisplay {
                background: linear-gradient(to bottom, transparent 19px, rgba(0, 0, 0, 0.1) 20px), linear-gradient(to right, #ffffff, #f0f0f0);
                background-size: 100% 20px, 100% 100%;
                background-color: #ffffff;
            }
            #noteDisplay .text-black {
                line-height: 20px; /* Match the line spacing with background */
            }
            .underline-red {
                position: relative;
                display: inline-block;
            }
            .underline-red::after {
                content: '';
                position: absolute;
                left: 0;
                bottom: -2px;
                width: 100%;
                height: 2px;
                background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 10" preserveAspectRatio="none"><path d="M0 5 Q 10 0, 20 5 T 40 5 T 60 5 T 80 5 T 100 5" stroke="red" stroke-width="2" fill="none"/></svg>') repeat-x;
                background-size: 20px 10px;
            }
        `;
        const styleSheet = document.createElement('style');
        styleSheet.textContent = customStyles;
        document.head.appendChild(styleSheet);

        // Initial Render
        renderNotesList();
    </script>
</x-layout>