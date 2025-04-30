@php
    $role = "teacher";
@endphp
<x-layout role="{{ $role }}" title="Group Settings" :user="$user">
    <x-nav-group type="name" page="settings"></x-nav-group>

    <!-- Konten Utama -->
    <section class="mt-3 space-y-6">
        <!-- Card untuk Murid (Daftar Anggota) -->
        <div class="bg-white shadow-md rounded-2xl p-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Daftar Anggota Grup</h2>
            </div>
            <!-- Tabel untuk Desktop -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Nama</th>
                            <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Email</th>
                            <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Tanggal Bergabung</th>
                            <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $members = [
                                [
                                    'id' => 1,
                                    'name' => 'Andi Pratama',
                                    'email' => 'andi.pratama@example.com',
                                    'joined_at' => '2025-04-01',
                                ],
                                [
                                    'id' => 2,
                                    'name' => 'Budi Santoso',
                                    'email' => 'budi.santoso@example.com',
                                    'joined_at' => '2025-04-02',
                                ],
                                [
                                    'id' => 3,
                                    'name' => 'Cindy Amelia',
                                    'email' => 'cindy.amelia@example.com',
                                    'joined_at' => '2025-04-03',
                                ],
                            ];
                        @endphp
                        @foreach($members as $member)
                            <tr class="border-t">
                                <td class="py-2 px-4 text-sm text-gray-700">{{ $member['name'] }}</td>
                                <td class="py-2 px-4 text-sm text-gray-700">{{ $member['email'] }}</td>
                                <td class="py-2 px-4 text-sm text-gray-700">{{ $member['joined_at'] }}</td>
                                <td class="py-2 px-4 text-sm">
                                    <button onclick="openKickModal({{ $member['id'] }}, '{{ $member['name'] }}')"
                                        class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition">
                                        Kick
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Card untuk Mobile -->
            <div class="md:hidden flex flex-col gap-3">
                @foreach($members as $member)
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                        <p class="text-sm font-medium text-gray-800">{{ $member['name'] }}</p>
                        <p class="text-sm text-gray-600">{{ $member['email'] }}</p>
                        <p class="text-sm text-gray-500">Bergabung: {{ $member['joined_at'] }}</p>
                        <button onclick="openKickModal({{ $member['id'] }}, '{{ $member['name'] }}')"
                            class="mt-2 bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition">
                            Kick
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Card untuk Approve Student -->
        <div class="bg-white shadow-md rounded-2xl p-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Permintaan Bergabung</h2>
            </div>
            <!-- Tabel untuk Desktop -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Nama</th>
                            <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Email</th>
                            <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Tanggal Permintaan</th>
                            <th class="py-2 px-4 text-left text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $pendingRequests = [
                                [
                                    'id' => 4,
                                    'name' => 'Dewi Lestari',
                                    'email' => 'dewi.lestari@example.com',
                                    'requested_at' => '2025-04-10',
                                ],
                                [
                                    'id' => 5,
                                    'name' => 'Eko Wahyu',
                                    'email' => 'eko.wahyu@example.com',
                                    'requested_at' => '2025-04-11',
                                ],
                            ];
                        @endphp
                        @foreach($pendingRequests as $request)
                            <tr class="border-t">
                                <td class="py-2 px-4 text-sm text-gray-700">{{ $request['name'] }}</td>
                                <td class="py-2 px-4 text-sm text-gray-700">{{ $request['email'] }}</td>
                                <td class="py-2 px-4 text-sm text-gray-700">{{ $request['requested_at'] }}</td>
                                <td class="py-2 px-4 text-sm flex gap-2">
                                    <form action="/group/approve/{{ $request['id'] }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="bg-emerald-400 text-white px-3 py-1 rounded-lg hover:bg-emerald-500 transition">
                                            Approve
                                        </button>
                                    </form>
                                    <button onclick="openRejectModal({{ $request['id'] }}, '{{ $request['name'] }}')"
                                        class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition">
                                        Reject
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Card untuk Mobile -->
            <div class="md:hidden flex flex-col gap-3">
                @foreach($pendingRequests as $request)
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                        <p class="text-sm font-medium text-gray-800">{{ $request['name'] }}</p>
                        <p class="text-sm text-gray-600">{{ $request['email'] }}</p>
                        <p class="text-sm text-gray-500">Permintaan: {{ $request['requested_at'] }}</p>
                        <div class="mt-2 flex gap-2">
                            <form action="/group/approve/{{ $request['id'] }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="bg-emerald-400 text-white px-3 py-1 rounded-lg hover:bg-emerald-500 transition">
                                    Approve
                                </button>
                            </form>
                            <button onclick="openRejectModal({{ $request['id'] }}, '{{ $request['name'] }}')"
                                class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition">
                                Reject
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Custom Section dengan Tombol Hapus -->
        <div class="bg-white shadow-md rounded-2xl p-4">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Pengaturan Penghapusan</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <button onclick="openDeleteConfirmModal('notes')"
                    class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                    Hapus Seluruh Catatan
                </button>
                <button onclick="openDeleteConfirmModal('tasks')"
                    class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                    Hapus Seluruh Tugas
                </button>
                <button onclick="openDeleteConfirmModal('schedules')"
                    class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                    Hapus Seluruh Jadwal
                </button>
                <button onclick="openDeleteConfirmModal('members')"
                    class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                    Hapus Seluruh Murid
                </button>
                <button onclick="openDeleteConfirmModal('pending')"
                    class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                    Hapus Seluruh Permintaan Masuk
                </button>
                <button onclick="openDeleteConfirmModal('group')"
                    class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                    Hapus Grup
                </button>
            </div>
        </div>
    </section>

    <!-- Modal Konfirmasi Kick -->
    <div id="kick-modal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Kick Anggota</h3>
            <p class="text-gray-600 mb-6">Apakah Anda yakin ingin mengeluarkan "<span id="kick-student-name"></span>" dari grup? Tindakan ini tidak dapat dibatalkan.</p>
            <form id="kick-student-form" action="" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-4">
                    <button type="button" onclick="closeKickModal()"
                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                        Kick
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Konfirmasi Reject -->
    <div id="reject-modal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Tolak Permintaan</h3>
            <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menolak permintaan "<span id="reject-student-name"></span>" untuk bergabung? Tindakan ini tidak dapat dibatalkan.</p>
            <form id="reject-student-form" action="" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-4">
                    <button type="button" onclick="closeRejectModal()"
                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                        Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Konfirmasi Penghapusan Massal -->
    <div id="delete-confirm-modal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4" id="delete-confirm-title"></h3>
            <p class="text-gray-600 mb-6" id="delete-confirm-message"></p>
            <form id="delete-confirm-form" action="" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-4">
                    <button type="button" onclick="closeDeleteConfirmModal()"
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

    <!-- JavaScript untuk Modal -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Fungsi Modal Kick
            window.openKickModal = function(id, name) {
                const modal = document.getElementById('kick-modal');
                const nameSpan = document.getElementById('kick-student-name');
                const form = document.getElementById('kick-student-form');
                nameSpan.textContent = name;
                form.action = `/group/kick/${id}`;
                modal.classList.remove('hidden');
            };

            window.closeKickModal = function() {
                const modal = document.getElementById('kick-modal');
                modal.classList.add('hidden');
            };

            // Fungsi Modal Reject
            window.openRejectModal = function(id, name) {
                const modal = document.getElementById('reject-modal');
                const nameSpan = document.getElementById('reject-student-name');
                const form = document.getElementById('reject-student-form');
                nameSpan.textContent = name;
                form.action = `/group/reject/${id}`;
                modal.classList.remove('hidden');
            };

            window.closeRejectModal = function() {
                const modal = document.getElementById('reject-modal');
                modal.classList.add('hidden');
            };

            // Fungsi Modal Konfirmasi Penghapusan Massal
            window.openDeleteConfirmModal = function(type) {
                const modal = document.getElementById('delete-confirm-modal');
                const title = document.getElementById('delete-confirm-title');
                const message = document.getElementById('delete-confirm-message');
                const form = document.getElementById('delete-confirm-form');

                let titleText = '';
                let messageText = '';
                let actionUrl = '';

                switch(type) {
                    case 'notes':
                        titleText = 'Hapus Seluruh Catatan';
                        messageText = 'Apakah Anda yakin ingin menghapus seluruh catatan? Tindakan ini tidak dapat dibatalkan.';
                        actionUrl = '/group/delete/notes';
                        break;
                    case 'tasks':
                        titleText = 'Hapus Seluruh Tugas';
                        messageText = 'Apakah Anda yakin ingin menghapus seluruh tugas? Tindakan ini tidak dapat dibatalkan.';
                        actionUrl = '/group/delete/tasks';
                        break;
                    case 'schedules':
                        titleText = 'Hapus Seluruh Jadwal';
                        messageText = 'Apakah Anda yakin ingin menghapus seluruh jadwal? Tindakan ini tidak dapat dibatalkan.';
                        actionUrl = '/group/delete/schedules';
                        break;
                    case 'members':
                        titleText = 'Hapus Seluruh Murid';
                        messageText = 'Apakah Anda yakin ingin menghapus seluruh murid dari grup? Tindakan ini tidak dapat dibatalkan.';
                        actionUrl = '/group/delete/members';
                        break;
                    case 'pending':
                        titleText = 'Hapus Seluruh Permintaan Masuk';
                        messageText = 'Apakah Anda yakin ingin menghapus seluruh permintaan masuk? Tindakan ini tidak dapat dibatalkan.';
                        actionUrl = '/group/delete/pending';
                        break;
                    case 'group':
                        titleText = 'Hapus Grup';
                        messageText = 'Apakah Anda yakin ingin menghapus grup ini? Semua data terkait akan hilang dan tindakan ini tidak dapat dibatalkan.';
                        actionUrl = '/group/delete';
                        break;
                }

                title.textContent = titleText;
                message.textContent = messageText;
                form.action = actionUrl;
                modal.classList.remove('hidden');
            };

            window.closeDeleteConfirmModal = function() {
                const modal = document.getElementById('delete-confirm-modal');
                modal.classList.add('hidden');
            };
        });
    </script>
</x-layout>