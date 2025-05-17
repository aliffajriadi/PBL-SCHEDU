<x-layout title="Group Dashboard" role="{{ $role }}" :user="$user">
    <x-nav-group type="name" page="dashboard" group_name="{{ $group->name }}"></x-nav-group>


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
                        <p class="text-sm font-medium">{{ $note_total > 1 ? 'Notes' : 'Note' }}</p>
                        <p class="text-2xl font-bold">{{ $note_total }}</p>
                    </div>
                    <div class="bg-emerald-400 text-white rounded-2xl shadow-md p-3 flex-1 text-center">
                        <img src="{{ asset('assets/bx-task (1) 2.svg') }}" alt="Task" class="w-8 h-8 mx-auto mb-2">
                        <p class="text-sm font-medium">{{ $task_total> 1 ? 'Tasks' : 'Task' }}</p>
                        <p class="text-2xl font-bold">{{ $task_total }}</p>
                    </div>
                    <div class="bg-emerald-400 text-white rounded-2xl shadow-md p-3 flex-1 text-center">
                        <img src="{{ asset('assets/calender-white.svg') }}" alt="Schedule" class="w-8 h-8 mx-auto mb-2">
                        <p class="text-sm font-medium">{{ $schedule_total > 1 ? 'Schedules' : 'Schedule' }}</p>
                        <p class="text-2xl font-bold">{{ $schedule_total }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full md:w-5/12">
            <div class="bg-emerald-400 p-3 shadow-md rounded-2xl h-full text-white">
                <h2 class="text-lg font-semibold mb-3">Anggota Kelas</h2>
                <div class="flex flex-col gap-3">
                    <!-- Anggota 1 -->
                    @foreach ($members as $member)
                        <div class="flex items-center gap-3 bg-emerald-50 rounded-2xl p-1">
                            <img src="{{ asset('image/Ryan-Gosling.jpg') }}" alt="Anggota 1" class="w-12 h-12 rounded-full border border-emerald-400">
                            <div>
                                <p class="text-sm font-medium">{{ $member->user->name }}</p>
                                <p class="text-xs text-gray-500">Siswa</p>
                            </div>
                        </div>
                        
                    @endforeach
                    
                  
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
                    @foreach ($tasks as $task)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-emerald-50 transition-all duration-300">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('assets/bx-task.svg') }}" alt="Tugas" class="w-8 h-8">
                            <div>
                                <p class="text-sm font-medium">{{ $task->title }}</p>
                                <p class="text-xs text-gray-500">Tenggat: {{ $task->deadline }}</p>
                            </div>
                        </div>
                        <span class="text-xs bg-emerald-400 text-white px-2 py-1 rounded-full">Belum Selesai</span>
                    </div>
                        
                    @endforeach

                </div>
            </div>
        </div>
        <div class="w-full md:w-5/12">
            <div class="bg-emerald-400 p-3 shadow-md rounded-2xl h-full text-white">
                <h2 class="text-lg font-semibold mb-3">Catatan Kelas</h2>
                <div class="flex flex-col gap-3">
                    <!-- Catatan 1 -->
                    @foreach ($notes as $note)
                    <div class="p-3 bg-gray-50 text-gray-800 rounded-xl hover:bg-emerald-50 transition-all duration-300">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('assets/bx-notepad 2.svg') }}" alt="Catatan" class="w-8 h-8">
                            <div>
                                <p class="text-sm font-medium">{{ $note->title }}</p>
                                <p class="text-xs text-gray-500">Created {{ $note->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        {{-- <p class="text-xs text-gray-600 mt-2 line-clamp-2">{{ $note->content }}</p> --}}
                    </div>
                    @endforeach

                 
                </div>
            </div>
        </div>
    </section>

    <div class="bg-white shadow-md rounded-2xl p-3 mt-3">
        <h2 class="text-lg pb-3 font-semibold">Schedule</h2>
        <x-calender></x-calender>
    </div>
</x-layout>