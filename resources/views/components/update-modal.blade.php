    <div id="update-modal" class="hidden fixed inset-0 bg-black/50 shadow-md backdrop-blur-sm flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Confirmation for Update</h3>
            <p class="text-gray-600 mb-6">Are you sure update this note?</p>      
            <div class="flex justify-end gap-4">
                <button type="button" onclick="close_update_modal()"
                    class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                    Cancel
                </button>
                <button type="button" id="update-button"
                    class="bg-emerald-500 text-white px-4 py-2 rounded-lg hover:bg-emerald-600 transition">
                    Save
                </button>
            </div>
        </div>
    </div>

    <script>
        function open_update_modal(id, callback) 
        {
            if(id === false){
                document.getElementById('update-button').onclick = () => {
                    callback();       
                };
            }else{
                document.getElementById('update-button').onclick = () => {
                    callback(id);       
                };
            }

            
            
            const modal = document.getElementById('update-modal');
            // const titleSpan = document.getElementById('delete-note-title');
            const form = document.getElementById('update-form-confirm');

            modal.classList.remove('hidden');
        };

        function close_update_modal () 
        {
            const modal = document.getElementById('update-modal');
            modal.classList.add('hidden');
        };
    </script>