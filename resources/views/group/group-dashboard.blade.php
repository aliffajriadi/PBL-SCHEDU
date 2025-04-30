<x-layout title="Group Dashboard" role="student" :user="$user">
    <x-nav-group type="name" page="dashboard"></x-nav-group>

    <section class="flex flex-col md:flex-row gap-2 mt-3">
        <div class="w-full md:w-7/12 flex flex-col gap-y-2">
            <div class="bg-white shadow-md p-3 rounded-2xl">
                <h2 class="text-lg font-semibold">Group</h2>
                <div class="mt-3 bg-emerald-400 rounded-2xl w-full shadow-2xs p-3 flex">
                    <img src="{{ asset('storage/' . $group->instance->folder_name . '/groups/' . $group->group_code . '/' . $group->pic) }}" alt="pictgroup" class="w-32 h-auto rounded-2xl me-3 border border-amber-300">
                    <div class="text-white">
                        <p class="text-lg font-semibold">{{ $group->name }}</p>
                        <p class="text-md">{{ $group->instance->instance_name }}</p>
                        <p class="text-sm">Nama Guru yang buat</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-3 shadow-md rounded-2xl">
                <h2 class="text-lg font-semibold mb-3">Statistik Kelas</h2>
                <div class="flex flex-col md:flex-row justify-around gap-3">
                    <div class="bg-emerald-400 text-white rounded-2xl shadow-md p-3 flex-1 text-center">
                        <img src="{{ asset('assets/bx-notepad 2.svg') }}" alt="Notes" class="w-8 h-8 mx-auto mb-2">
                        <p class="text-sm font-medium">COUNT() Notes</p>
                        <p class="text-2xl font-bold">5</p>
                    </div>
                    <div class="bg-emerald-400 text-white rounded-2xl shadow-md p-3 flex-1 text-center">
                        <img src="{{ asset('assets/bx-task (1) 2.svg') }}" alt="Task" class="w-8 h-8 mx-auto mb-2">
                        <p class="text-sm font-medium">COUNT() Task</p>
                        <p class="text-2xl font-bold">30</p>
                    </div>
                    <div class="bg-emerald-400 text-white rounded-2xl shadow-md p-3 flex-1 text-center">
                        <img src="{{ asset('assets/calender-white.svg') }}" alt="Schedule" class="w-8 h-8 mx-auto mb-2">
                        <p class="text-sm font-medium">COUNT() Schedule</p>
                        <p class="text-2xl font-bold">85</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full md:w-5/12">
            <div class="bg-emerald-400 p-3 shadow-md rounded-2xl h-full text-white">
                <h2 class="text-lg font-semibold mb-3">Anggota Kelas</h2>
                <div class="flex flex-col gap-3">
                    <!-- Anggota 1 -->
                    <div class="flex items-center gap-3 bg-emerald-50 rounded-2xl p-1">
                        <img src="{{ asset('image/Ryan-Gosling.jpg') }}" alt="Anggota 1" class="w-12 h-12 rounded-full border border-emerald-400">
                        <div>
                            <p class="text-sm font-medium">Budi Santoso</p>
                            <p class="text-xs text-gray-500">Siswa</p>
                        </div>
                    </div>
                    <!-- Anggota 2 -->
                    <div class="flex items-center gap-3 bg-emerald-50 rounded-2xl p-1">
                        <img src="{{ asset('image/Ryan-Gosling.jpg') }}" alt="Anggota 2" class="w-12 h-12 rounded-full border border-emerald-400">
                        <div>
                            <p class="text-sm font-medium">Ani Lestari</p>
                            <p class="text-xs text-gray-500">Siswa</p>
                        </div>
                    </div>
                    <!-- Anggota 3 -->
                    <div class="flex items-center gap-3 bg-emerald-50 rounded-2xl p-1">
                        <img src="{{ asset('image/Ryan-Gosling.jpg') }}" alt="Anggota 3" class="w-12 h-12 rounded-full border border-emerald-400">
                        <div>
                            <p class="text-sm font-medium">Citra Dewi</p>
                            <p class="text-xs text-gray-500">Siswa</p>
                        </div>
                    </div>
                    <!-- Anggota 4 -->
                    <div class="flex items-center gap-3 bg-emerald-50 rounded-2xl p-1">
                        <img src="{{ asset('image/Ryan-Gosling.jpg') }}" alt="Anggota 4" class="w-12 h-12 rounded-full border border-emerald-400">
                        <div>
                            <p class="text-sm font-medium">Dedi Pratama</p>
                            <p class="text-xs text-gray-500">Siswa</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bagian Tugas dan Catatan -->
    <section class="flex flex-col md:flex-row gap-2 mt-3">
        <div class="w-full md:w-7/12">
            <div class="bg-white p-3 shadow-md rounded-2xl h-full">
                <h2 class="text-lg font-semibold mb-3">Daftar Tugas</h2>
                <div class="flex flex-col gap-3">
                    <!-- Tugas 1 -->
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-emerald-50 transition-all duration-300">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('assets/bx-task.svg') }}" alt="Tugas" class="w-8 h-8">
                            <div>
                                <p class="text-sm font-medium">Membuat Puisi</p>
                                <p class="text-xs text-gray-500">Tenggat: 20 April 2025</p>
                            </div>
                        </div>
                        <span class="text-xs bg-emerald-400 text-white px-2 py-1 rounded-full">Belum Selesai</span>
                    </div>
                    <!-- Tugas 2 -->
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-emerald-50 transition-all duration-300">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('assets/bx-task.svg') }}" alt="Tugas" class="w-8 h-8">
                            <div>
                                <p class="text-sm font-medium">Analisis Cerpen</p>
                                <p class="text-xs text-gray-500">Tenggat: 25 April 2025</p>
                            </div>
                        </div>
                        <span class="text-xs bg-emerald-400 text-white px-2 py-1 rounded-full">Belum Selesai</span>
                    </div>
                    <!-- Tugas 3 -->
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-emerald-50 transition-all duration-300">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('assets/bx-task.svg') }}" alt="Tugas" class="w-8 h-8">
                            <div>
                                <p class="text-sm font-medium">Latihan Kosa Kata</p>
                                <p class="text-xs text-gray-500">Tenggat: 18 April 2025</p>
                            </div>
                        </div>
                        <span class="text-xs bg-green-500 text-white px-2 py-1 rounded-full">Selesai</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full md:w-5/12">
            <div class="bg-emerald-400 p-3 shadow-md rounded-2xl h-full text-white">
                <h2 class="text-lg font-semibold mb-3">Catatan Kelas</h2>
                <div class="flex flex-col gap-3">
                    <!-- Catatan 1 -->
                    <div class="p-3 bg-gray-50 text-gray-800 rounded-xl hover:bg-emerald-50 transition-all duration-300">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('assets/bx-note.svg') }}" alt="Catatan" class="w-8 h-8">
                            <div>
                                <p class="text-sm font-medium">Struktur Puisi</p>
                                <p class="text-xs text-gray-500">Dibuat: 15 April 2025</p>
                            </div>
                        </div>
                        <p class="text-xs text-gray-600 mt-2 line-clamp-2">Penjelasan tentang bait, rima, dan irama dalam puisi tradisional.</p>
                    </div>
                    <!-- Catatan 2 -->
                    <div class="p-3 bg-gray-50 text-gray-800 rounded-xl hover:bg-emerald-50 transition-all duration-300">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('assets/bx-note.svg') }}" alt="Catatan" class="w-8 h-8">
                            <div>
                                <p class="text-sm font-medium">Unsur Cerpen</p>
                                <p class="text-xs text-gray-500">Dibuat: 10 April 2025</p>
                            </div>
                        </div>
                        <p class="text-xs text-gray-600 mt-2 line-clamp-2">Catatan tentang tema, tokoh, dan latar dalam cerita pendek.</p>
                    </div>
                    <!-- Catatan 3 -->
                    <div class="p-3 bg-gray-50 text-gray-800 rounded-xl hover:bg-emerald-50 transition-all duration-300">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('assets/bx-note.svg') }}" alt="Catatan" class="w-8 h-8">
                            <div>
                                <p class="text-sm font-medium">Kosa Kata Baru</p>
                                <p class="text-xs text-gray-500">Dibuat: 8 April 2025</p>
                            </div>
                        </div>
                        <p class="text-xs text-gray-600 mt-2 line-clamp-2">Daftar kosa kata dari teks yang dibahas di kelas.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="bg-white shadow-md rounded-2xl p-3 mt-3">
        <h2 class="text-lg pb-3 font-semibold">Schedule</h2>
        <x-calender></x-calender>
    </div>
</x-layout>