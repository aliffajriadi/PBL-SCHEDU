<div id="chatbot-container" class="fixed bottom-6 right-6 z-50 font-sans">
  <!-- Tombol Chat -->
  <button
    onclick="toggleChatModal()"
    class="bg-emerald-500 hover:bg-emerald-700 text-white rounded-full p-4 shadow-lg transition-colors duration-300 focus:outline-none"
    aria-label="Buka chat"
  >
    💬
  </button>

  <!-- Modal Chat -->
  <div
    id="chat-modal"
    class="hidden w-80 max-w-full h-[500px] bg-white shadow-2xl rounded-xl mt-3 flex flex-col border border-gray-300"
    role="dialog"
    aria-modal="true"
    aria-labelledby="chat-title"
  >
    <header
      class="bg-emerald-500 text-white p-4 font-semibold text-lg flex justify-between items-center select-none"
    >
      <h2 id="chat-title">Schedu Chat</h2>
      <button
        onclick="toggleChatModal()"
        class="text-white text-2xl leading-none hover:text-gray-200 focus:outline-none"
        aria-label="Tutup chat"
      >
        &times;
      </button>
    </header>

    <div
      id="chat-messages"
      class="flex-1 p-4 overflow-y-auto text-sm space-y-3 bg-gray-50"
      style="word-wrap: break-word;"
    >
      <div>
        <span class="bg-amber-200 text-gray-500 px-3 py-1 text-xs rounded-md inline-block">
           Kamu bisa minta AI untuk membuat catatan, tugas, atau jadwal dengan memberikan judul, deskripsi, dan tanggal. SchedU AI siap membantu produktifitas mu! ☺️📚
        </span>
    </div>
    </div>

    <form
      id="chat-form"
      class="p-4 border-t border-gray-200 flex items-end gap-2"
      onsubmit="sendMessage(event)"
    >
      <textarea
        id="chat-input"
        class="flex-1 resize-none border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-emerald-400 focus:border-emerald-400"
        placeholder="Ketik pesan..."
        rows="1"
        required
        oninput="autoResizeTextarea(this)"
        style="max-height: 100px;"
      ></textarea>
      <button
        type="submit"
        class="bg-emerald-500 hover:bg-emerald-700 text-white px-4 py-2 rounded-md text-sm transition-colors duration-300 focus:outline-none"
      >
        Kirim
      </button>
    </form>
  </div>
</div>
