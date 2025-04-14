@php
    $role = "student";
@endphp
<x-layout title="Group Notes" role="{{ $role }}">
    <x-nav-group type="search" page="notes"></x-nav-group>

    <!-- Konten Utama -->
    <section class="flex flex-col lg:flex-row mt-3 gap-4">
        <!-- Bagian Kiri: Daftar Catatan -->
        <div class="bg-white shadow-md rounded-2xl w-full lg:w-5/12 p-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Note List</h2>
                @if($role === 'teacher')
                    <button onclick="openAddNoteModal()"
                        class="bg-emerald-400 text-white px-3 py-1 rounded-lg hover:bg-emerald-500 transition">
                        + Add Note
                    </button>
                @endif
            </div>
            <!-- Daftar Catatan -->
            <div class="flex flex-col gap-3 max-h-96 overflow-auto">
                @php
                    $notes = [
                        1 => [
                            'title' => 'Nasi Padang',
                            'created_at' => '2025-04-14 10:00',
                            'content' => 'Catatan tentang resep dan sejarah Nasi Padang. Termasuk daftar lauk pauk seperti rendang dan ayam pop.',
                            'attachments' => [['name' => 'resep_nasi_padang.pdf', 'path' => 'notes/resep_nasi_padang.pdf']],
                        ],
                        2 => [
                            'title' => 'Nasi Goreng',
                            'created_at' => '2025-04-14 08:00',
                            'content' => 'Panduan membuat nasi goreng spesial dengan telur dan kecap manis.',
                            'attachments' => [],
                        ],
                        3 => [
                            'title' => 'Sate Ayam',
                            'created_at' => '2025-04-13',
                            'content' => 'Tips marinasi sate ayam agar empuk dan bumbu meresap.',
                            'attachments' => [['name' => 'foto_sate.jpg', 'path' => 'notes/foto_sate.jpg']],
                        ],
                        4 => [
                            'title' => 'Rendang Daging',
                            'created_at' => '2025-04-11',
                            'content' => 'Resep rendang daging otentik dengan santan kental.',
                            'attachments' => [],
                        ],
                        5 => [
                            'title' => 'Gado-Gado',
                            'created_at' => '2025-04-09',
                            'content' => 'Cara membuat gado-gado dengan saus kacang yang lezat.',
                            'attachments' => [['name' => 'resep_gado_gado.docx', 'path' => 'notes/resep_gado_gado.docx']],
                        ],
                    ];
                @endphp
                @foreach ($notes as $id => $note)
                    <a href="?note={{ $id }}"
                        class="block border-l-4 border-emerald-400 pl-3 py-2 rounded-sm hover:bg-emerald-50 transition-all duration-300">
                        <div class="flex justify-between items-center">
                            <h3 class="font-medium text-gray-800">{{ $note['title'] }}</h3>
                            <p class="text-sm text-gray-500">{{ $loop->iteration }}</p>
                        </div>
                        <p class="text-sm text-gray-500">Created at {{ $note['created_at'] }}</p>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Bagian Kanan: Detail Catatan -->
        <div class="bg-white shadow-md rounded-2xl w-full lg:w-7/12 p-4 mt-4 lg:mt-0">
            @if(request()->query('note'))
                @php
                    $noteId = request()->query('note');
                    $note = isset($notes[$noteId]) ? $notes[$noteId] : null;
                @endphp
                @if($note)
                    @if($role === 'teacher')
                        <!-- Form Edit Catatan untuk Guru -->
                        <form action="/notes/update/{{ $noteId }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="text" name="title" value="{{ $note['title'] }}" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                            <textarea name="content" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" rows="6" required>{{ $note['content'] }}</textarea>
                            <input type="file" name="attachments[]" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" accept=".pdf,.doc,.docx,.jpg,.png" multiple>
                            <div class="flex gap-4">
                                <button type="submit" class="bg-emerald-400 text-white px-4 py-2 rounded-lg hover:bg-emerald-500 transition">Update Note</button>
                                <button type="button" onclick="openDeleteModal({{ $noteId }}, '{{ $note['title'] }}')"
                                    class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">Delete Note</button>
                            </div>
                        </form>
                        @if(!empty($note['attachments']))
                            <div class="border-t border-gray-200 pt-4 mt-4">
                                <h4 class="font-semibold text-gray-700 mb-2">Existing Attachments</h4>
                                <ul class="list-disc pl-5 text-sm text-gray-600">
                                    @foreach($note['attachments'] as $attachment)
                                        <li>
                                            <a href="{{ asset('storage/' . $attachment['path']) }}" target="_blank"
                                                class="text-emerald-400 hover:underline">{{ $attachment['name'] }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @else
                        <!-- Tampilan untuk Murid (Hanya Baca) -->
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $note['title'] }}</h3>
                        <p class="text-sm text-gray-500 mb-4">Created at: {{ $note['created_at'] }}</p>
                        <p class="text-gray-700 mb-6">{{ $note['content'] }}</p>
                        @if(!empty($note['attachments']))
                            <div class="border-t border-gray-200 pt-4">
                                <h4 class="font-semibold text-gray-700 mb-2">Attachments</h4>
                                <ul class="list-disc pl-5 text-sm text-gray-600">
                                    @foreach($note['attachments'] as $attachment)
                                        <li>
                                            <a href="{{ asset('storage/' . $attachment['path']) }}" target="_blank"
                                                class="text-emerald-400 hover:underline">{{ $attachment['name'] }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endif
                @else
                    <div class="flex items-center justify-center h-full text-gray-500">
                        <p>Catatan tidak ditemukan.</p>
                    </div>
                @endif
            @else
                <div class="flex flex-col items-center justify-center h-full text-gray-500">
                    <img src="/image/ilustr1.jpg" alt="ilustrator" class="w-40 h-auto mb-4">
                    <p>Pilih catatan di sebelah kiri untuk melihat detail.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Bagian Riwayat Catatan -->
    <section class="bg-white rounded-2xl shadow-md p-4 w-full mt-3">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Note History</h3>
        @php
            $history = [
                [
                    'title' => 'Nasi Padang',
                    'action' => 'Created',
                    'timestamp' => '2025-04-14 10:00',
                    'details' => 'Catatan tentang resep Nasi Padang dibuat.',
                ],
                [
                    'title' => 'Nasi Goreng',
                    'action' => 'Created',
                    'timestamp' => '2025-04-14 08:00',
                    'details' => 'Catatan tentang nasi goreng dibuat.',
                ],
                [
                    'title' => 'Sate Ayam',
                    'action' => 'Updated',
                    'timestamp' => '2025-04-13 15:30',
                    'details' => 'Menambahkan tips baru untuk sate ayam.',
                ],
            ];
        @endphp
        @if(!empty($history))
            <div class="flex flex-col gap-3 max-h-96 overflow-auto">
                @foreach($history as $entry)
                    <div class="bg-white border border-gray-200 rounded-md p-3">
                        <p class="text-gray-800 font-medium">{{ $entry['title'] }} - {{ $entry['action'] }}</p>
                        <p class="text-sm text-gray-500">Timestamp: {{ $entry['timestamp'] }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ $entry['details'] }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-gray-500 text-center">
                <p>Belum ada riwayat catatan.</p>
            </div>
        @endif
    </section>

    <!-- Modal Tambah Catatan (Hanya untuk Guru) -->
    @if($role === 'teacher')
        <div id="add-note-modal" class="hidden fixed inset-0 bg-slate-50/50 backdrop-blur-sm flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Tambah Catatan Baru</h3>
                <form action="/notes/add" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="title" placeholder="Note Title" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                    <textarea name="content" placeholder="Note Content" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" rows="4" required></textarea>
                    <input type="file" name="attachments[]" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" accept=".pdf,.doc,.docx,.jpg,.png" multiple>
                    <div class="flex justify-end gap-4">
                        <button type="button" onclick="closeAddNoteModal()"
                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="bg-emerald-400 text-white px-4 py-2 rounded-lg hover:bg-emerald-500 transition">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Modal Konfirmasi Delete (Hanya untuk Guru) -->
    @if($role === 'teacher')
        <div id="delete-modal" class="hidden fixed inset-0 bg-slate-50/50 shadow-md backdrop-blur-sm flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Hapus Catatan</h3>
                <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus catatan "<span id="delete-note-title"></span>"? Tindakan ini tidak dapat dibatalkan.</p>
                <form id="delete-note-form" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-end gap-4">
                        <button type="button" onclick="closeDeleteModal()"
                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                            Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- JavaScript untuk Pratinjau File, Modal Tambah, dan Modal Delete -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Pratinjau File
            const fileInputs = document.querySelectorAll('input[type="file"]');
            fileInputs.forEach(input => {
                input.addEventListener('change', function (event) {
                    const preview = document.createElement('div');
                    preview.className = 'flex flex-col gap-2 mb-4';
                    const files = event.target.files;
                    for (let file of files) {
                        const fileItem = document.createElement('div');
                        fileItem.className = 'flex items-center gap-2 text-gray-700';
                        let icon = '';
                        if (file.type === 'application/pdf') {
                            icon = '<svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>';
                        } else if (file.type.includes('msword') || file.type.includes('wordprocessingml')) {
                            icon = '<svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>';
                        } else if (file.type.includes('image')) {
                            icon = '<svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>';
                        } else {
                            icon = '<svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>';
                        }
                        fileItem.innerHTML = `${icon}<span class="text-sm">${file.name}</span>`;
                        preview.appendChild(fileItem);
                    }
                    input.parentNode.insertBefore(preview, input.nextSibling);
                });
            });

            // Fungsi Modal Tambah Catatan
            window.openAddNoteModal = function() {
                const modal = document.getElementById('add-note-modal');
                modal.classList.remove('hidden');
            };

            window.closeAddNoteModal = function() {
                const modal = document.getElementById('add-note-modal');
                modal.classList.add('hidden');
            };

            // Fungsi Modal Delete
            window.openDeleteModal = function(noteId, noteTitle) {
                const modal = document.getElementById('delete-modal');
                const titleSpan = document.getElementById('delete-note-title');
                const form = document.getElementById('delete-note-form');
                titleSpan.textContent = noteTitle;
                form.action = `/notes/delete/${noteId}`;
                modal.classList.remove('hidden');
            };

            window.closeDeleteModal = function() {
                const modal = document.getElementById('delete-modal');
                modal.classList.add('hidden');
            };
        });
    </script>
</x-layout>