@extends('layout.PmsTheme')

@section('title', 'Dashboard | DoListify')

@section('content')
    <main id="main-content" class="main-content">
        <div class="rounded-2xl px-4 pb-5 pt-2 space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- To-Do Widget -->
                <div class="bg-white rounded-2xl shadow-md ">
                    <div class="p-6 flex items-center justify-between border-b animate-fade-in">
                        <div>
                            <h3 class="text-xl  font-bold text-gray-800">To Do</h3>
                            <p class="text-3xl font-bold text-cyan-700">{{ $stats['todo'] }}</p>
                        </div>
                        <div class="bg-cyan-700 p-3 rounded-2xl">
                            <svg class="w-8 h-8 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                    <div class="p-4 flex items-center justify-center animate-fade-in">
                        <p class="text-sm text-center text-gray-500">Your tasks are ready for action!</p>
                    </div>
                </div>

                <!-- In Progress Widget -->
                <div class="bg-white rounded-2xl shadow-md">
                    <div class="p-6 flex items-center justify-between border-b animate-fade-in">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">In Progress</h3>
                            <p class="text-3xl font-bold text-amber-400">{{ $stats['ongoing'] }}</p>
                        </div>
                        <div class="bg-amber-400 p-3 rounded-2xl">
                            <svg class="w-8 h-8 text-amber-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="p-4 flex items-center justify-center animate-fade-in">
                        <p class="text-sm text-center text-gray-500">Goodluck! to the task you are working on.</p>
                    </div>
                </div>

                <!-- Completed Widget -->
                <div class="bg-white rounded-2xl shadow-md">
                    <div class="p-6 flex items-center justify-between border-b animate-fade-in">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">Completed</h3>
                            <p class="text-3xl font-bold text-emerald-600">{{ $stats['completed'] }}</p>
                        </div>
                        <div class="bg-emerald-600 p-3 rounded-2xl">
                            <svg class="w-8 h-8 text-emerald-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                    <div class="p-4 flex items-center justify-center animate-fade-in">
                        <p class="text-sm text-center text-gray-500">Great job! Keep up the excellent work!</p>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Upcoming Deadlines</h3>
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Task</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Due Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @php
                                    $deadlines = $stats['nearest_deadlines'];
                                    if ($deadlines->count() == 1) {
                                        $nextNearest = $stats['next_nearest_deadlines'];
                                        $deadlines = $deadlines->merge($nextNearest);
                                    }
                                @endphp
                                @if($deadlines->count() > 0)
                                    @foreach($deadlines as $deadline)
                                    <tr onclick="window.location='{{ route('task', $deadline->project->id) }}'" class="cursor-pointer hover:bg-slate-200">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $deadline->project->title }}</div>
                                            <div class="text-xs text-gray-500">{{ $deadline->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ $deadline->due_date->format('M d, Y') }}</div>
                                            <div class="text-xs text-gray-400">{{ $deadline->due_time->format('h:i A') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-4 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $deadline->status === 'To Do' ? 'bg-yellow-100 text-yellow-800' : 
                                                   ($deadline->status === 'Ongoing' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                                {{ $deadline->status }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">No upcoming deadlines</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Weekly Task Tasks for Points</h3>
                    <div class="bg-white rounded-2xl shadow-md p-2">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900">Complete 3 tasks</h3>
                                        <p class="text-xs text-gray-500">Earn 50 points</p>
                                    </div>
                                </div>
                                <button
                                    class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700">
                                    Claim
                                </button>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900">Log in for 5 consecutive days</h3>
                                        <p class="text-xs text-gray-500">Earn 100 points</p>
                                    </div>
                                </div>
                                <button class="px-4 py-2 text-sm font-medium text-gray-500 bg-gray-200 rounded-lg" disabled>
                                    In Progress
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
