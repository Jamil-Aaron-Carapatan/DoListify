@extends('layout.PmsTheme')

@section('title', 'Team Projects | DoListify')

@section('content')
    <main id="main-content" class="main-content">
        <div class="rounded-2xl px-3 pb-5 pt-2 space-y-3">
            @if (Auth::user()->projects()->where('type', 'team')->count() > 0)
                <h1 class="text-2xl text-large text-gray-500">Team Projects</h1>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach (Auth::user()->projects()->where('type', 'team')->get() as $project)
                        <div class="bg-white rounded-xl shadow-md p-4 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 flex flex-col h-[40.5vh]">
                            <!-- Fixed Header Section -->
                            <div class="flex justify-between items-center mb-3">
                                <h2 class="text-lg text-large text-cyan-800">{{ $project->title }}</h2>
                                <span class="px-2 py-1 bg-cyan-600 text-white rounded-full text-xs">Team</span>
                            </div>

                            <!-- Scrollable Content -->
                            <div class="flex-grow overflow-hidden">
                                <div class="h-full">
                                    <div class="overflow-y-auto scrollbar-thin h-full">
                                        <!-- Team Leader -->
                                        <div class="mb-3">
                                            <label class="text-medium text-gray-600">Leader</label>
                                            <div class="flex items-center mt-1">
                                                <div
                                                    class="w-7 h-7 rounded-full flex items-center justify-center  bg-{{ ['red', 'blue', 'green', 'yellow', 'purple', 'pink', 'indigo', 'cyan'][array_rand(['red', 'blue', 'green', 'yellow', 'purple', 'pink', 'indigo', 'cyan'])] }}-600">
                                                    <span
                                                        class="text-white text-xs">{{ substr($project->leader()->first_name, 0, 1) }}</span>
                                                </div>
                                                <span
                                                    class="ml-2 text-medium text-gray-500">{{ $project->leader()->first_name }}</span>
                                            </div>
                                        </div>

                                        <!-- Team Members -->
                                        <div class="mb-3">
                                            <label class="text-medium text-gray-600">Team</label>
                                            <div class="mt-1">
                                                @foreach ($project->regularMembers() as $member)
                                                    <div class="flex items-center mb-2">
                                                        <div
                                                            class="w-6 h-6 bg-gray-100 rounded-full flex items-center justify-center">
                                                            <span
                                                                class="text-gray-600 text-xs">{{ substr($member->first_name, 0, 1) }}</span>
                                                        </div>
                                                        <span
                                                            class="ml-2 text-medium text-gray-500">{{ $member->first_name }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Fixed Action Button -->
                            <a href="{{ route('task', $project->id) }}"
                                class="w-full block text-center py-2 bg-gradient-to-br from-cyan-600 to-cyan-800 text-white text-sm rounded-lg hover:opacity-90 transition-opacity mt-3">
                                View Tasks
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center h-[calc(100vh-100px)]">
                    <div class="mb-8 text-gray-400 transform hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-users-slash text-9xl"></i>
                    </div>
                    <div class="text-center text-gray-400 text-2xl mb-4">
                        <p>Oops! Looks like there aren't any team projects yet.</p>
                        <p class="text-lg mt-2">Create a new team project to get started!</p>

                    </div>
                    <a href="{{ route('addProject') }}"
                        class="inline-flex items-center mt-4 px-5 py-2 bg-zinc-900 text-white text-medium rounded-full shadow hover:bg-zinc-800 transition ease-in-out">Create
                        Project</a>
                </div>
            @endif
        </div>
    </main>
@endsection
