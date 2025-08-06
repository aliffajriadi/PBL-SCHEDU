<div id="chatbot-container" class="fixed bottom-6 right-6 z-50">
    <!-- Tombol Chat -->
    <button onclick="toggleChatModal()" class="bg-emerald-400 hover:bg-emerald-600 text-white rounded-full p-4 shadow-lg">
        💬
    </button>

    <!-- Modal Chat -->
    <div id="chat-modal" class="hidden w-80 h-[450px] bg-white shadow-2xl rounded-xl mt-4 overflow-hidden flex flex-col border">
        <div class="bg-emerald-400 text-white p-4 font-semibold text-lg flex justify-between items-center">
            <span>Schedu Chat</span>
            <button onclick="toggleChatModal()" class="text-white text-xl">&times;</button>
        </div>

        <div id="chat-messages" class="flex-1 p-4 overflow-y-auto text-sm space-y-2">
            <!-- Pesan tampil di sini -->
        </div>

        <form id="chat-form" class="p-4 border-t flex items-center gap-2" onsubmit="sendMessage(event)">
            <input type="text" id="chat-input" class="flex-1 border rounded-md px-3 py-2 text-sm" placeholder="Ketik pesan..." required>
            <button type="submit" class="bg-emerald-400 text-white px-3 py-2 rounded-md text-sm">Kirim</button>
        </form>
    </div>
</div>
