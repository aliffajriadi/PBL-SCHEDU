<x-layout 
    title="Group Dashboard" 
    role="{{ $role }}" 
    :user="$user" 
    :image="$userData->profile_pic !== null ? asset('storage/' . $userData->instance->folder_name . '/' . $userData->profile_pic) : 'image/Ryan-Gosling.jpg'"
>
    <x-nav-group 
        type="name" 
        page="dashboard" 
        group_name="{{ $group->name }}"
    />

    {{-- Main Content Grid --}}
    <section class="flex flex-col lg:flex-row gap-4 mt-4">
        {{-- Left Column - Group Info & Statistics --}}
        <div class="w-full lg:w-7/12 flex flex-col gap-4">
            {{-- Group Information Card --}}
            <div class="bg-white shadow-md p-4 rounded-2xl">
                <h2 class="text-lg font-semibold mb-3">Group</h2>
                <div class="bg-emerald-400 rounded-2xl w-full shadow-sm p-4 flex flex-col sm:flex-row items-center sm:items-start gap-4">
                    <img 
                        src="{{ $group->pic === null ? asset('image/image2.jpg') : asset('storage/' . $group->instance->folder_name . '/groups/' . $group->group_code . '/' . $group->pic) }}" 
                        alt="Group Picture" 
                        class="w-24 h-24 sm:w-32 sm:h-32 rounded-2xl border border-amber-300 object-cover flex-shrink-0"
                    >
                    <div class="text-white text-center sm:text-left">
                        <p class="text-lg font-semibold">{{ $group->name }}</p>
                        <p class="text-base">{{ $group->instance->instance_name }}</p>
                        <p class="text-sm opacity-90">{{ $group->user->name }}</p>
                    </div>
                </div>
            </div>

            {{-- Statistics Card --}}
            <div class="bg-white p-4 shadow-md rounded-2xl">
                <h2 class="text-lg font-semibold mb-4">Statistics Group</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-emerald-400 text-white rounded-2xl shadow-md p-4 text-center">
                        <img 
                            src="{{ asset('assets/bx-notepad 2.svg') }}" 
                            alt="Notes" 
                            class="w-8 h-8 mx-auto mb-2"
                        >
                        <p class="text-sm font-medium">{{ $note_total > 1 ? 'Notes' : 'Note' }}</p>
                        <p class="text-2xl font-bold">{{ $note_total }}</p>
                    </div>
                    <div class="bg-emerald-400 text-white rounded-2xl shadow-md p-4 text-center">
                        <img 
                            src="{{ asset('assets/bx-task (1) 2.svg') }}" 
                            alt="Task" 
                            class="w-8 h-8 mx-auto mb-2"
                        >
                        <p class="text-sm font-medium">{{ $task_total > 1 ? 'Tasks' : 'Task' }}</p>
                        <p class="text-2xl font-bold">{{ $task_total }}</p>
                    </div>
                    <div class="bg-emerald-400 text-white rounded-2xl shadow-md p-4 text-center">
                        <img 
                            src="{{ asset('assets/calender-white.svg') }}" 
                            alt="Schedule" 
                            class="w-8 h-8 mx-auto mb-2"
                        >
                        <p class="text-sm font-medium">{{ $schedule_total > 1 ? 'Schedules' : 'Schedule' }}</p>
                        <p class="text-2xl font-bold">{{ $schedule_total }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column - Members --}}
        <div class="w-full lg:w-5/12">
            <div class="bg-emerald-400 p-4 shadow-md rounded-2xl h-full text-white">
                <h2 class="text-lg font-semibold mb-4">Member Group</h2>
                <div class="flex flex-col gap-3 max-h-96 overflow-y-auto">
                    @foreach ($members as $member)
                        <div class="flex items-center gap-3 bg-emerald-50 rounded-2xl p-3">
                            <img 
                                src="{{ asset('image/Ryan-Gosling.jpg') }}" 
                                alt="Member Avatar" 
                                class="w-12 h-12 rounded-full border border-emerald-400 object-cover flex-shrink-0"
                            >
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-700 font-medium truncate">{{ $member->user->name }}</p>
                                <p class="text-xs text-gray-500">Siswa</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Tasks and Notes Section --}}
    <section class="flex flex-col lg:flex-row gap-4 mt-4">
        {{-- Tasks Column --}}
        <div class="w-full lg:w-7/12">
            <div class="bg-white p-4 shadow-md rounded-2xl h-full">
                <h2 class="text-lg font-semibold mb-4">Task Group</h2>
                <div class="flex flex-col gap-3 max-h-96 overflow-y-auto">
                    @forelse ($tasks as $task)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-emerald-50 transition-all duration-300">
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                <img 
                                    src="{{ asset('assets/bx-task.svg') }}" 
                                    alt="Task Icon" 
                                    class="w-8 h-8 flex-shrink-0"
                                >
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium truncate">{{ $task->title }}</p>
                                    <p class="text-xs text-gray-500">Deadline: {{ $task->deadline }}</p>
                                </div>
                            </div>
                            @if($role === 'student')
                                <span class="text-xs bg-emerald-400 text-white px-3 py-1 rounded-full flex-shrink-0 ml-2">
                                    Progress
                                </span>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-sm text-gray-500">No tasks available.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Notes Column --}}
        <div class="w-full lg:w-5/12">
            <div class="bg-emerald-400 p-4 shadow-md rounded-2xl h-full text-white">
                <h2 class="text-lg font-semibold mb-4">Notes Group</h2>
                <div class="flex flex-col gap-3 max-h-96 overflow-y-auto">
                    @forelse ($notes as $note)
                        <div class="p-3 bg-gray-50 text-gray-800 rounded-xl hover:bg-emerald-50 transition-all duration-300">
                            <div class="flex items-center gap-3">
                                <img 
                                    src="{{ asset('assets/bx-notepad 2.svg') }}" 
                                    alt="Note Icon" 
                                    class="w-8 h-8 flex-shrink-0"
                                >
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium truncate">{{ $note->title }}</p>
                                    <p class="text-xs text-gray-500">Created {{ $note->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            {{-- <p class="text-xs text-gray-600 mt-2 line-clamp-2">{{ $note->content }}</p> --}}
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-sm text-gray-300">No notes available.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    {{-- Calendar Section --}}
    <div class="bg-white shadow-md rounded-2xl p-4 mt-4">
        <h2 class="text-lg font-semibold mb-4">Calendar</h2>
        <x-calender />
    </div>
</x-layout>

<script>
    set_calendar(@json($schedules))
</script>