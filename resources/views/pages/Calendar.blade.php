@extends('layout.PmsTheme')

@section('title', 'Calendar | DoListify: Visualize Your Tasks with Calendar')

@section('content')
    <main id="main-content" class="main-content">
        <div class="rounded-2xl px-2 md:px-3 pb-5 pt-2 space-y-3">
            @php
                $currentDate = request('date') ? new DateTime(request('date')) : new DateTime();
                $month = $currentDate->format('n');
                $year = $currentDate->format('Y');
                $firstDay = new DateTime("$year-$month-01");
                $lastDay = new DateTime("$year-$month-" . $firstDay->format('t'));
            @endphp

            <div class="flex flex-col sm:flex-row justify-between items-center mb-2 gap-2">
                <div class="flex items-start justify-between w-full">
                    <a href="{{ request()->fullUrlWithQuery(['date' => (clone $currentDate)->modify('-1 month')->format('Y-m-d')]) }}"
                        class="px-6 py-2 flex items-center justify-center rounded-xl bg-cyan-800 text-white hover:bg-cyan-700 transition-all duration-300 transform hover:scale-110">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <span class="text-large text-2xl text-cyan-800">{{ $currentDate->format('F Y') }}</span>
                    <a href="{{ request()->fullUrlWithQuery(['date' => (clone $currentDate)->modify('+1 month')->format('Y-m-d')]) }}"
                        class="px-6 py-2 flex items-center justify-center rounded-xl bg-cyan-800 text-white hover:bg-cyan-700 transition-all duration-300 transform hover:scale-110">
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="rounded-2xl border-3 border-cyan-800 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[768px] h-[600px] lg:h-[800px] rounded-2xl bg-cyan-800 shadow-lg">
                        <thead>
                            <tr class="bg-cyan-800 text-normal h-12">
                                <th class="w-[14.28%] p-2">S</th>
                                <th class="w-[14.28%] p-2">M</th>
                                <th class="w-[14.28%] p-2">T</th>
                                <th class="w-[14.28%] p-2">W</th>
                                <th class="w-[14.28%] p-2">T</th>
                                <th class="w-[14.28%] p-2">F</th>
                                <th class="w-[14.28%] p-2">S</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white rounded-r-2xl">
                            @php
                                $currentDay = clone $firstDay;
                                $currentDay->modify('-' . $firstDay->format('w') . ' days');
                                $today = new DateTime();
                            @endphp

                            @for ($week = 0; $week < 6; $week++)
                                <tr class="h-[calc((100%-3rem)/6)] border text-medium">
                                    @for ($day = 0; $day < 7; $day++)
                                        @php
                                            $dateString = $currentDay->format('Y-m-d');
                                            $tasksQuery = App\Models\Task::whereDate('due_date', $dateString)
                                                ->where(function($query) {
                                                    $query->whereHas('project', function($q) {
                                                        $q->where('created_by', auth()->id())
                                                          ->where('type', 'personal');
                                                    })
                                                    ->orWhereHas('project', function($q) {
                                                        $q->where('type', 'team')
                                                          ->whereHas('members', function($sq) {
                                                              $sq->where('user_id', auth()->id());
                                                          });
                                                    });
                                                });
                                            
                                            // Debug information
                                            if ($dateString === '2024-02-22') {
                                                \Illuminate\Support\Facades\Log::info('Query for 22nd:', [
                                                    'SQL' => $tasksQuery->toSql(),
                                                    'Bindings' => $tasksQuery->getBindings(),
                                                    'User ID' => auth()->id(),
                                                    'Tasks Count' => $tasksQuery->count()
                                                ]);
                                            }
                                            
                                            $tasksForDay = $tasksQuery->get();
                                        @endphp
                                        <td class="w-[14.28%] p-2 hover:bg-blue-50 border transition-colors relative
                                            {{ $currentDay->format('m') != $month ? ' bg-gray-50' : '' }}
                                            {{ $dateString === $today->format('Y-m-d') ? 'bg-cyan-800 font-bold' : '' }}"
                                            data-date="{{ $dateString }}">
                                            <div class="flex justify-between items-center mb-2">
                                                <span
                                                    class="text-medium text-gray-500 lg:text-base pl-1">{{ $currentDay->format('j') }}</span>
                                            </div>
                                            @if ($tasksForDay->count() > 0)
                                                <div class="space-y-1 overflow-y-auto max-h-[200px]_ scrollbar-thin">
                                                    @foreach ($tasksForDay as $task)
                                                        @php
                                                            $isPastDue =
                                                                \Carbon\Carbon::parse($task->due_date)->isPast() &&
                                                                $task->status !== 'completed';
                                                            $isCompleted = $task->status === 'completed';
                                                            $completedBeforeDue =
                                                                $isCompleted &&
                                                                !\Carbon\Carbon::parse($task->due_date)->isPast();
                                                        @endphp
                                                        <div
                                                            class="group min-h-[26px] lg:min-h-[30px] text-[11px] lg:text-sm p-1.5 rounded 
                                                            {{ $isPastDue ? 'bg-red-500 line-through opacity-50' : '' }}
                                                            {{ $completedBeforeDue ? 'bg-green-500 line-through opacity-50 pointer-events-none' : '' }}
                                                            {{ !$isPastDue && !$isCompleted ? 'bg-cyan-500' : '' }}
                                                            hover:shadow-md transition-all duration-200">
                                                            <a href="{{ route('task', $task->project_id) }}"
                                                                class="block overflow-hidden text-ellipsis whitespace-nowrap hover:text-white {{ $isPastDue ? 'text-white' : '' }}"
                                                                title="{{ $task->name }} ({{ $task->status }})">
                                                                <span class="mr-1">•</span>
                                                                {{ $task->name }}
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </td>
                                        @php $currentDay->modify('+1 day') @endphp
                                    @endfor
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
