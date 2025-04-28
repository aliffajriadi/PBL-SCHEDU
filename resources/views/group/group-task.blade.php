@php
    $role = "teacher";
@endphp
<x-layout title="Group Task" role="{{ $role }}" :user="$user">
    <x-nav-group type="search" page="tasks"></x-nav-group>

    <!-- Konten Utama -->
    <section class="flex flex-col lg:flex-row mt-3 gap-4">
        <!-- Kolom Kiri: Daftar Tugas -->
        <div class="bg-white shadow-md rounded-2xl w-full lg:w-5/12 p-4">
            <div class="flex justify-between items-center mb-4">
                <p class="text-md font-semibold text-gray-800">Task List</p>
                @if($role === 'teacher')
                    <div class="flex gap-2">
                        <button onclick="openAddTaskModal()"
                            class="bg-emerald-400 text-white px-3 py-1 rounded-lg hover:bg-emerald-500 transition">
                            + Add Task
                        </button>
                        <button onclick="openAddUnitModal()"
                            class="bg-blue-400 text-white px-3 py-1 rounded-lg hover:bg-blue-500 transition">
                            + Add Unit
                        </button>
                    </div>
                @endif
            </div>
            <div class="flex flex-col gap-3 max-h-96 overflow-auto">
                @php
                    $units = [
                        'Unit 1' => [
                            1 => ['title' => 'Tugas Matematika', 'deadline' => '2025-04-15'],
                            2 => ['title' => 'Tugas Bahasa', 'deadline' => '2025-04-17'],
                            3 => ['title' => 'Tugas IPA', 'deadline' => '2025-04-20'],
                            4 => ['title' => 'Tugas Sejarah', 'deadline' => '2025-04-22'],
                        ],
                        'Unit 2' => [
                            5 => ['title' => 'Tugas Seni', 'deadline' => '2025-04-25'],
                            6 => ['title' => 'Tugas Olahraga', 'deadline' => '2025-04-27'],
                        ],
                    ];
                @endphp
                @foreach($units as $unit => $tasks)
                    <div class="bg-white border border-gray-200 rounded-md p-3">
                        <p class="text-gray-800 font-medium mb-2">{{ $unit }}</p>
                        <div class="flex flex-col gap-2">
                            @foreach($tasks as $id => $task)
                                <a href="?task={{ $id }}" class="tasks block border-l-4 border-emerald-400 pl-3 py-2 rounded-sm hover:bg-emerald-50">
                                    <p class="font-medium text-gray-800">{{ $task['title'] }}</p>
                                    <p class="text-sm text-gray-500">Tenggat: {{ $task['deadline'] }}</p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Kolom Kanan: Detail Tugas -->
        <div class="bg-white shadow-md rounded-2xl w-full lg:w-7/12 p-4 mt-4 lg:mt-0">
            @if(request()->query('task'))
                @php
                    $tasks = [
                        1 => [
                            'title' => 'Tugas Matematika',
                            'deadline' => '2025-04-15',
                            'description' => 'Selesaikan 10 soal aljabar linear. Pastikan menunjukkan langkah-langkah penyelesaian secara rinci.'
                        ],
                        2 => [
                            'title' => 'Tugas Bahasa',
                            'deadline' => '2025-04-17',
                            'description' => 'Buat esai 500 kata tentang pentingnya pelestarian lingkungan. Sertakan referensi jika diperlukan.'
                        ],
                        3 => [
                            'title' => 'Tugas IPA',
                            'deadline' => '2025-04-20',
                            'description' => 'Lakukan percobaan sederhana tentang fotosintesis dan tulis laporan hasilnya.'
                        ],
                        4 => [
                            'title' => 'Tugas Sejarah',
                            'deadline' => '2025-04-22',
                            'description' => 'Buat ringkasan tentang perjuangan kemerdekaan Indonesia.'
                        ],
                        5 => [
                            'title' => 'Tugas Seni',
                            'deadline' => '2025-04-25',
                            'description' => 'Buat sketsa bertema alam dengan cat air.'
                        ],
                        6 => [
                            'title' => 'Tugas Olahraga',
                            'deadline' => '2025-04-27',
                            'description' => 'Rekam video latihan kebugaran selama 10 menit.'
                        ]
                    ];
                    $taskId = request()->query('task');
                    $task = isset($tasks[$taskId]) ? $tasks[$taskId] : null;
                @endphp

                @if($task)
                    @if($role === 'teacher')
                        <!-- Form Edit Tugas untuk Guru -->
                        <form action="/tasks/update/{{ $taskId }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="text" name="title" value="{{ $task['title'] }}" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                            <input type="date" name="deadline" value="{{ $task['deadline'] }}" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                            <textarea name="description" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" rows="6" required>{{ $task['description'] }}</textarea>
                            <div class="flex gap-4">
                                <button type="submit" class="bg-emerald-400 text-white px-4 py-2 rounded-lg hover:bg-emerald-500 transition">Update Task</button>
                                <button type="button" onclick="openDeleteModal({{ $taskId }}, '{{ $task['title'] }}')"
                                    class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">Delete Task</button>
                            </div>
                        </form>
                    @else
                        <!-- Tampilan untuk Murid -->
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $task['title'] }}</h3>
                        <p class="text-sm text-gray-500 mb-4">Tenggat: {{ $task['deadline'] }}</p>
                        <p class="text-gray-700 mb-6">{{ $task['description'] }}</p>
                        <div class="border-t border-gray-200 pt-4">
                            <h4 class="font-semibold text-gray-700 mb-2">Kumpulkan Tugas</h4>
                            <form action="/submit-task" method="POST" enctype="multipart/form-data" id="submission-form">
                                @csrf
                                <input type="hidden" name="task_id" value="{{ $taskId }}">
                                <input type="file" name="submissions[]" id="file-input" class="mb-4 p-2 border border-gray-200 rounded-lg w-full" accept=".pdf,.doc,.docx" multiple>
                                <div id="file-preview" class="flex flex-col gap-2 mb-4"></div>
                                <button type="submit" class="bg-emerald-400 text-white px-6 py-2 rounded-lg hover:bg-emerald-500 transition">Kumpul Tugas</button>
                            </form>
                        </div>
                    @endif
                @else
                    <div class="flex items-center justify-center h-full text-gray-500">
                        <p>Tugas tidak ditemukan.</p>
                    </div>
                @endif
            @else
                <div class="flex items-center justify-center h-full text-gray-500">
                    <p>Pilih tugas di sebelah kiri untuk melihat detail.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Section History Task -->
    <section class="bg-white rounded-2xl shadow-md p-4 w-full mt-3">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">History Task</h3>
        @php
            $submissions = [
                [
                    'task_id' => 1,
                    'student_name' => 'Andi Pratama',
                    'title' => 'Tugas Matematika',
                    'submitted_at' => '2025-04-14',
                    'files' => [
                        ['name' => 'jawaban_aljabar.pdf', 'path' => 'submissions/jawaban_aljabar.pdf'],
                        ['name' => 'catatan_aljabar.docx', 'path' => 'submissions/catatan_aljabar.docx']
                    ],
                    'grade' => 85,
                    'graded_at' => '2025-04-16'
                ],
                [
                    'task_id' => 2,
                    'student_name' => 'Budi Santoso',
                    'title' => 'Tugas Bahasa',
                    'submitted_at' => '2025-04-16',
                    'files' => [
                        ['name' => 'esai_lingkungan.pdf', 'path' => 'submissions/esai_lingkungan.pdf']
                    ],
                    'grade' => null,
                    'graded_at' => null
                ],
                [
                    'task_id' => 3,
                    'student_name' => 'Cindy Amelia',
                    'title' => 'Tugas IPA',
                    'submitted_at' => '2025-04-19',
                    'files' => [
                        ['name' => 'laporan_fotosintesis.pdf', 'path' => 'submissions/laporan_fotosintesis.pdf'],
                        ['name' => 'data_eksperimen.docx', 'path' => 'submissions/data_eksperimen.docx']
                    ],
                    'grade' => 90,
                    'graded_at' => '2025-04-21'
                ]
            ];
        @endphp

        @if(request()->query('task') && $role === 'teacher')
            @php
                $taskId = request()->query('task');
                $filteredSubmissions = array_filter($submissions, function($submission) use ($taskId) {
                    return $submission['task_id'] == $taskId;
                });
            @endphp
            @if(!empty($filteredSubmissions))
                <div class="flex flex-col gap-3 max-h-96 overflow-auto">
                    @foreach($filteredSubmissions as $submission)
                        <div class="bg-white border border-gray-200 rounded-md p-3">
                            <p class="text-gray-800 font-medium">{{ $submission['title'] }} - {{ $submission['student_name'] }}</p>
                            <p class="text-sm text-gray-500">Dikumpulkan: {{ $submission['submitted_at'] }}</p>
                            <div class="mt-2">
                                <p class="text-sm font-medium text-gray-700">File:</p>
                                <ul class="list-disc pl-5 text-sm text-gray-600">
                                    @foreach($submission['files'] as $file)
                                        <li>
                                            <a href="{{ asset('storage/' . $file['path']) }}" target="_blank" class="text-emerald-400 hover:underline">
                                                {{ $file['name'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="mt-2">
                                <p class="text-sm font-medium text-gray-700">Nilai:</p>
                                <form action="/grade-task/{{ $submission['task_id'] }}" method="POST" class="flex gap-2 items-center">
                                    @csrf
                                    <input type="number" name="grade" value="{{ $submission['grade'] ?? '' }}" min="0" max="100"
                                        class="p-1 border border-gray-200 rounded-lg w-20" placeholder="0-100">
                                    <input type="hidden" name="student_name" value="{{ $submission['student_name'] }}">
                                    <button type="submit" class="bg-emerald-400 text-white px-3 py-1 rounded-lg hover:bg-emerald-500 transition">
                                        Simpan Nilai
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-gray-500 text-center">
                    <p>Belum ada pengumpulan untuk tugas ini.</p>
                </div>
            @endif
        @elseif($role === 'student')
            <div class="flex flex-col gap-3 max-h-96 overflow-auto">
                @foreach($submissions as $submission)
                    <div class="bg-white border border-gray-200 rounded-md p-3">
                        <p class="text-gray-800 font-medium">{{ $submission['title'] }}</p>
                        <p class="text-sm text-gray-500">Dikumpulkan: {{ $submission['submitted_at'] }}</p>
                        <div class="mt-2">
                            <p class="text-sm font-medium text-gray-700">File:</p>
                            <ul class="list-disc pl-5 text-sm text-gray-600">
                                @foreach($submission['files'] as $file)
                                    <li>
                                        <a href="{{ asset('storage/' . $file['path']) }}" target="_blank" class="text-emerald-400 hover:underline">
                                            {{ $file['name'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <p class="text-sm mt-2">
                            <span class="font-medium text-gray-700">Nilai: </span>
                            @if($submission['grade'] !== null)
                                <span class="text-emerald-400">{{ $submission['grade'] }}/100</span>
                                <span class="text-gray-500">(Dinilai pada {{ $submission['graded_at'] }})</span>
                            @else
                                <span class="text-gray-500">Menunggu Penilaian</span>
                            @endif
                        </p>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-gray-500 text-center">
                <p>Pilih tugas untuk melihat riwayat pengumpulan.</p>
            </div>
        @endif
    </section>

    <!-- Modal Tambah Tugas (Hanya untuk Guru) -->
    @if($role === 'teacher')
        <div id="add-task-modal" class="hidden fixed inset-0 slide-down shadow-md bg-slate-50/50 backdrop-blur-sm flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Tambah Tugas Baru</h3>
                <form action="/tasks/add" method="POST">
                    @csrf
                    <input type="text" name="title" placeholder="Judul Tugas" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                    <select name="unit" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                        <option value="" disabled selected>Pilih Unit</option>
                        @foreach($units as $unit => $tasks)
                            <option value="{{ $unit }}">{{ $unit }}</option>
                        @endforeach
                    </select>
                    <input type="date" name="deadline" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                    <textarea name="description" placeholder="Deskripsi Tugas" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" rows="4" required></textarea>
                    <div class="flex justify-end gap-4">
                        <button type="button" onclick="closeAddTaskModal()"
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

    <!-- Modal Tambah Unit (Hanya untuk Guru) -->
    @if($role === 'teacher')
        <div id="add-unit-modal" class="hidden fixed inset-0 slide-down shadow-md bg-slate-50/50 backdrop-blur-sm flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Tambah Unit Baru</h3>
                <form action="/units/add" method="POST">
                    @csrf
                    <input type="text" name="unit_name" placeholder="Nama Unit (contoh: Unit 3)" class="mb-2 p-2 border border-gray-200 rounded-lg w-full" required>
                    <div class="flex justify-end gap-4">
                        <button type="button" onclick="closeAddUnitModal()"
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
        <div id="delete-modal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Hapus Tugas</h3>
                <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus tugas "<span id="delete-task-title"></span>"? Tindakan ini tidak dapat dibatalkan.</p>
                <form id="delete-task-form" action="" method="POST">
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

    <!-- JavaScript untuk Pratinjau File, Modal Tambah, Modal Unit, dan Modal Delete -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Pratinjau File
            const fileInput = document.getElementById('file-input');
            if (fileInput) {
                fileInput.addEventListener('change', function(event) {
                    const filePreview = document.getElementById('file-preview');
                    filePreview.innerHTML = ''; // Kosongkan pratinjau sebelumnya

                    const files = event.target.files;
                    for (let file of files) {
                        const fileItem = document.createElement('div');
                        fileItem.className = 'flex items-center gap-2 text-gray-700';

                        // Tentukan ikon berdasarkan tipe file
                        let icon = '';
                        if (file.type === 'application/pdf') {
                            icon = '<svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>';
                        } else if (file.type.includes('msword') || file.type.includes('wordprocessingml')) {
                            icon = '<svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>';
                        } else {
                            icon = '<svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>';
                        }

                        fileItem.innerHTML = `
                            ${icon}
                            <span class="text-sm">${file.name}</span>
                        `;
                        filePreview.appendChild(fileItem);
                    }
                });
            }

            // Fungsi Modal Tambah Tugas
            window.openAddTaskModal = function() {
                const modal = document.getElementById('add-task-modal');
                modal.classList.remove('hidden');
            };

            window.closeAddTaskModal = function() {
                const modal = document.getElementById('add-task-modal');
                modal.classList.add('hidden');
            };

            // Fungsi Modal Tambah Unit
            window.openAddUnitModal = function() {
                const modal = document.getElementById('add-unit-modal');
                modal.classList.remove('hidden');
            };

            window.closeAddUnitModal = function() {
                const modal = document.getElementById('add-unit-modal');
                modal.classList.add('hidden');
            };

            // Fungsi Modal Delete
            window.openDeleteModal = function(taskId, taskTitle) {
                const modal = document.getElementById('delete-modal');
                const titleSpan = document.getElementById('delete-task-title');
                const form = document.getElementById('delete-task-form');
                titleSpan.textContent = taskTitle;
                form.action = `/tasks/delete/${taskId}`;
                modal.classList.remove('hidden');
            };

            window.closeDeleteModal = function() {
                const modal = document.getElementById('delete-modal');
                modal.classList.add('hidden');
            };
        });
    </script>
</x-layout>