    <div id="delete-modal" class="hidden fixed inset-0 bg-slate-50/50 shadow-md backdrop-blur-sm flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Hapus Catatan</h3>
            <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus catatan ini? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex justify-end gap-4">
                <button type="button" onclick="closeDeleteModal()"
                    class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                    Batal
                </button>
                <button type="button" id="delete-button"
                    class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                    Hapus
                </button>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModal (id, callback) 
        {
            document.getElementById('delete-button').onclick = () => {
                callback(id);
            };
            
            const modal = document.getElementById('delete-modal');
            // const titleSpan = document.getElementById('delete-note-title');
            const form = document.getElementById('delete-note-form');
            // titleSpan.textContent = noteTitle;
            // form.action = `/notes/delete/${noteId}`;
            modal.classList.remove('hidden');
        };

        function closeDeleteModal () 
        {
            const modal = document.getElementById('delete-modal');
            modal.classList.add('hidden');
        };
    </script>