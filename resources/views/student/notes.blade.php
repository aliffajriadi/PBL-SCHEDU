<x-layout title="Notes">
    <div class="bg-white items-center rounded-xl flex justify-between p-3 mt-3 mb-3 shadow-md hover:shadow-lg transition-all duration-300">
        <button id="openModalBtn" class="bg-emerald-400 text-white text-sm px-2 py-1 rounded-xl hover:bg-emerald-500 transition-all">Add Notes</button>
        <form id="searchForm" class="">
            <input type="text" id="searchInput" name="search" class="px-2 py-1 bg-emerald-200 rounded-xl" placeholder="Search....">
        </form>
    </div>
    <section class="flex space-x-3">
        <div class="bg-white w-5/12 items-center rounded-xl justify-between p-3 mt-3 mb-3 shadow-md hover:shadow-lg transition-all duration-300">
            <h3 class="text-md font-semibold mb-3">List Notes</h3>
            <div id="notesList" class="space-y-2 overflow-y-auto max-h-64">
                <!-- Notes will be dynamically added here -->
            </div>
        </div>
        <div id="noteDisplay" class="bg-emerald-400 w-7/12 items-center rounded-xl justify-between p-3 mt-3 mb-3 shadow-md hover:shadow-lg transition-all duration-300">
            <div id="noteContent" class="text-white h-full flex items-center justify-center overflow-y-auto max-h-64">
                <p>Select a note to view its content</p>
            </div>
        </div>
    </section>

    <!-- Modal for adding notes -->
    <div id="addNoteModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-xl w-96 max-w-md">
            <h2 class="text-xl font-bold mb-4">Add New Note</h2>
            <form id="addNoteForm">
                <div class="mb-4">
                    <label for="modalTitleInput" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <input type="text" id="modalTitleInput" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" required>
                </div>
                <div class="mb-4">
                    <label for="modalContentInput" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                    <textarea id="modalContentInput" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" required></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" id="closeModalBtn" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">Cancel</button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-emerald-500 rounded-md hover:bg-emerald-600">Save Note</button>
                </div>
            </form>
        </div>
    </div>
@php
$data = [
    ['id' => '1', 'title' => 'belanja', 'content' => 'beli baju'],
    ['id' => '2', 'title' => 'makan', 'content' => 'makan nasi'],
    ['id' => '3', 'title' => 'minum', 'content' => 'minum air']
]
@endphp

    <script>
        // Sample notes data
        let notes = [
            @foreach ( $data as $d)
                { id: @json($d['id']), title: @json($d['title']), content: @json($d['content']) },
            @endforeach
            
            
        ];
        
        let selectedNoteId = null;
        
        // DOM elements
        const openModalBtn = document.getElementById('openModalBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const addNoteModal = document.getElementById('addNoteModal');
        const addNoteForm = document.getElementById('addNoteForm');
        const modalTitleInput = document.getElementById('modalTitleInput');
        const modalContentInput = document.getElementById('modalContentInput');
        const searchInput = document.getElementById('searchInput');
        const notesList = document.getElementById('notesList');
        const noteDisplay = document.getElementById('noteDisplay');
        
        // Function to render notes list
        function renderNotesList(searchTerm = '') {
            notesList.innerHTML = '';
            
            const filteredNotes = searchTerm 
                ? notes.filter(note => note.title.toLowerCase().includes(searchTerm.toLowerCase()) || 
                                      note.content.toLowerCase().includes(searchTerm.toLowerCase()))
                : notes;
            
            filteredNotes.forEach(note => {
                const noteElement = document.createElement('div');
                noteElement.classList.add('p-2', 'rounded-lg', 'cursor-pointer', 'transition-all');
                
                // Apply different styles based on selection
                if (selectedNoteId === note.id) {
                    noteElement.classList.add('bg-emerald-200');
                } else {
                    noteElement.classList.add('bg-gray-100', 'hover:bg-emerald-100');
                }
                
                noteElement.innerHTML = `<h4 class="font-medium">${note.title}</h4>`;
                
                // Add click event to show note content
                noteElement.addEventListener('click', () => {
                    selectedNoteId = note.id;
                    renderNotesList(searchInput.value); // Re-render list to update selection styles
                    displayNoteContent(note);
                });
                
                notesList.appendChild(noteElement);
            });
        }
        
        // Function to display note content
        function displayNoteContent(note) {
            noteDisplay.innerHTML = `
                <div id="noteContent" class="text-white overflow-y-auto max-h-64 p-2">
                    <h3 class="text-lg text-white font-semibold mb-3">${note.title}</h3>
                    <p class="text-white">${note.content}</p>
                </div>
            `;
        }
        
        // Function to add a new note
        function addNote(title, content) {
            if (title.trim() && content.trim()) {
                const newNote = {
                    id: Date.now(), // Using timestamp as a simple unique ID
                    title: title,
                    content: content
                };
                
                notes.push(newNote);
                renderNotesList(searchInput.value);
                
                // Select the new note
                selectedNoteId = newNote.id;
                displayNoteContent(newNote);
                
                // Clear the inputs and close modal
                modalTitleInput.value = '';
                modalContentInput.value = '';
                closeModal();
            }
        }
        
        // Function to open modal
        function openModal() {
            addNoteModal.classList.remove('hidden');
        }
        
        // Function to close modal
        function closeModal() {
            addNoteModal.classList.add('hidden');
        }
        
        // Event listeners
        openModalBtn.addEventListener('click', openModal);
        
        closeModalBtn.addEventListener('click', closeModal);
        
        addNoteForm.addEventListener('submit', (e) => {
            e.preventDefault();
            addNote(modalTitleInput.value, modalContentInput.value);
        });
        
        searchInput.addEventListener('input', () => {
            renderNotesList(searchInput.value);
        });
        
        // Close modal when clicking outside
        addNoteModal.addEventListener('click', (e) => {
            if (e.target === addNoteModal) {
                closeModal();
            }
        });
        
        // Initial render
        renderNotesList();
    </script>
</x-layout>