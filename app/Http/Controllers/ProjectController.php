<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\Task;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\ChecklistItem;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{

    public function showAddTask(Request $request)
    {
        $tasks = Task::where('created_by', auth()->id())->get();
        return view('pages.AddTask', compact('tasks'));
    }

    public function store(Request $request)
    {
        $userId = auth()->id();
        if (!$userId) {
            return response()->json(['error' => 'User ID not found'], 400);
        }
        $validator = Validator::make($request->all(), [
            'tasks' => 'required|array',
            'tasks.*.name' => 'required|string|max:255',
            'tasks.*.priority' => 'required|in:High,Medium,Low',
            'tasks.*.due_date' => 'nullable|date|after_or_equal:today|before_or_equal:' . now()->addYears(3)->format('Y-m-d'),
            'tasks.*.description' => 'nullable|string',
            'tasks.*.due_time' => 'nullable|date_format:H:i|after_or_equal:' . now()->format('H:i'),
        ], [
            'tasks.*.name.required' => 'Task name is required',
            'tasks.*.priority.required' => 'Task priority is required',
            'tasks.*.due_date.after_or_equal' => 'Due date must be today or later',
            'tasks.*.due_date.before_or_equal' => 'Due date must be within 3 years',
            'tasks.*.due_time.after_or_equal' => 'Due time must be after current time',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            foreach ($request->tasks as $taskData) {
                $task = Task::create([
                    'name' => $taskData['name'],
                    'priority' => $taskData['priority'],
                    'due_date' => $taskData['due_date'] ?? null,
                    'description' => $taskData['description'] ?? null,
                    'due_time' => $taskData['due_time'] ?? null,
                    'project_id' => $request->project_id ?? null,
                    'created_by' => $userId,
                    'status' => 'To Do'
                ]);

                if (!empty($taskData['checklist'])) {
                    $checklistItems = array_filter($taskData['checklist'], function ($item) {
                        return !empty($item['name']);
                    });

                    foreach ($checklistItems as $index => $item) {
                        $task->checklist()->create([
                            'name' => $item['name'],
                            'completed' => false,
                            'order' => $index + 1
                        ]);
                    }
                }
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Tasks created successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Task creation error:', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to create tasks. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function storeTeamProject(Request $request)
    {
        Log::info($request->all()); // Log the request data
        // Validate project data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:team',
            'team_members' => 'required|array',
            'team_members.*' => 'email|exists:users,email',
            'tasks' => 'required|array',
            'tasks.*.name' => 'required|string|max:255',
            'tasks.*.description' => 'nullable|string',
            'tasks.*.assignee' => 'required|exists:users,id',
            'tasks.*.due_date' => 'required|date',
            'tasks.*.due_time' => 'required',
            'tasks.*.priority' => 'required|in:High,Medium,Low',
        ]);

        // Create project
        $project = Project::create([
            'title' => $validated['title'],
            'type' => $validated['type'],
            'created_by' => auth()->id(),
        ]);

        // Add creator as owner
        ProjectMember::create([
            'project_id' => $project->id,
            'user_id' => auth()->id(),
            'role' => 'owner',
        ]);

        // Add team members
        foreach ($validated['team_members'] as $email) {
            $user = User::where('email', $email)->first();
            ProjectMember::create([
                'project_id' => $project->id,
                'user_id' => $user->id,
                'role' => 'member',
            ]);
        }

        // Create tasks
        foreach ($validated['tasks'] as $taskData) {
            Task::create([
                'project_id' => $project->id,
                'name' => $taskData['name'],
                'description' => $taskData['description'],
                'assigned_to' => $taskData['assignee'],
                'due_date' => $taskData['due_date'],
                'due_time' => $taskData['due_time'],
                'priority' => $taskData['priority'],
            ]);
        }
        foreach ($validated['team_members'] as $email) {
            $user = User::where('email', $email)->first();
            if ($user) {
                Notification::create([
                    'user_id' => $user->id,
                    'type' => 'added_to_project',
                    'message' => 'You have been added to the project "' . $validated['title'] . '".',
                    'project_id' => $project->id,
                    'link' => route('projects.show', $project->id),
                ]);
            }
        }

        return redirect()->route('task', $project->id)
            ->with('success', 'Project created successfully');
    }
    public function projectView(Request $request)
    {
        $tasks = Task::where('created_by', auth()->id())->get();
        $userId = auth()->id();

        $query = Project::where(function ($query) use ($userId) {
            // Get personal projects created by the user
            $query->where('created_by', $userId)
                ->where('type', 'Personal')
                // Or team projects where the user is a member but not an owner
                ->orWhere(function ($q) use ($userId) {
                    $q->where('type', 'Team')
                        ->whereHas('projectMembers', function ($pm) use ($userId) {
                            $pm->where('user_id', $userId)
                                ->where('role', '!=', 'owner');
                        });
                });
        });

        // Apply Category Filter
        if ($request->filled('category')) {
            $query->where('type', $request->category);
        }

        // Apply Status Filter
        if ($request->filled('status')) {
            $query->whereHas('tasks', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        // Apply Priority Filter
        if ($request->filled('priority')) {
            $query->whereHas('tasks', function ($q) use ($request) {
                $q->where('priority', $request->priority);
            });
        }
        $projects = $query->with([
            'tasks' => function ($query) {
                $query->orderBy('due_date', 'asc');
            },
            'projectMembers'
        ])
            ->paginate(10)
            ->withQueryString();

        return view('pages.Projects', compact('projects', 'tasks'));
    }

    //this is for the team page
    public function validateUser(Request $request)
    {
        $validated = $request->validate([
            'emails' => 'required|array',
            'emails.*' => 'required|email',
        ]);

        $currentUserEmail = auth()->user()->email;

        $emails = array_filter($validated['emails'], function ($email) {
            return !empty(trim($email));
        });

        $errors = [];
        $users = [];

        foreach ($emails as $email) {
            if ($email === $currentUserEmail) {
                $errors[] = [
                    'email' => $email,
                    'message' => 'You cannot add yourself as a team member.',
                ];
            } else {
                $user = User::where('email', $email)->first();
                if ($user) {
                    $users[] = $user;
                } else {
                    $errors[] = [
                        'email' => $email,
                        'message' => 'This email is not registered in the system.',
                    ];
                }
            }
        }

        if (!empty($errors)) {
            return response()->json([
                'success' => false,
                'errors' => $errors,
            ], 422);
        }

        return response()->json([
            'success' => true,
            'users' => $users,
        ]);
    }
    //this is for the team page
    public function searchUsers(Request $request)
    {
        $query = $request->get('query');

        $users = User::where('email', 'LIKE', "%{$query}%")
            ->orWhere('first_name', 'LIKE', "%{$query}%")
            ->orWhere('last_name', 'LIKE', "%{$query}%")
            ->where('id', '!=', auth()->id())
            ->select('id', 'email', 'first_name', 'last_name')
            ->limit(5)
            ->get();

        return response()->json(['users' => $users]);
    }
    public function filter(Request $request)
    {
        $query = Project::query();

        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('priority') && $request->priority != '') {
            $query->where('priority', $request->priority);
        }

        $projects = $query->get();

        return view('pages.Projects', compact('projects'));
    }

    public function searchProjects(Request $request)
    {
        $query = $request->get('query');
        $userId = auth()->id();

        $projects = Project::where(function ($queryBuilder) use ($query, $userId) {
            $queryBuilder->where('title', 'LIKE', "%{$query}%")
                ->where(function ($q) use ($userId) {
                    $q->where('created_by', $userId)
                        ->orWhereHas('members', function ($q) use ($userId) {
                            $q->where('user_id', $userId);
                        });
                });
        })
            ->with([
                'tasks' => function ($query) {
                    $query->orderBy('due_date', 'asc');
                }
            ])
            ->limit(5)
            ->get(['id', 'title', 'type']);

        return response()->json(['projects' => $projects]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $projects = Project::where('title', 'like', "%{$query}%")
            ->orWhere('type', 'like', "%{$query}%")
            ->limit(5)
            ->get();

        return response()->json(['projects' => $projects]);
    }

    public function getProjectStats()
    {
        $userId = auth()->id();

        // Get projects and their tasks with proper conditions
        $projects = Project::where(function ($query) use ($userId) {
            $query->where(function ($q) use ($userId) {
                // Personal projects created by user
                $q->where('created_by', $userId)
                    ->where('type', 'Personal');
            })->orWhereHas('members', function ($q) use ($userId) {
                // Team projects where user is a member
                $q->where('user_id', $userId);
            });
        })->with([
                    'tasks' => function ($query) use ($userId) {
                        $query->where(function ($q) use ($userId) {
                            // Get tasks that are either:
                            // 1. From personal projects (assigned_to is null)
                            // 2. From team projects and assigned to this user
                            $q->whereNull('assigned_to')
                                ->orWhere('assigned_to', $userId);
                        });
                    }
                ])->get();

        // Calculate stats from filtered tasks
        $stats = [
            'todo' => $projects->flatMap->tasks->where('status', 'To Do')->count(),
            'ongoing' => $projects->flatMap->tasks->where('status', 'Ongoing')->count(),
            'completed' => $projects->flatMap->tasks->where('status', 'Done')->count(),
            'nearest_deadlines' => $projects->flatMap->tasks
                ->where('status', '!=', 'Done')
                ->where('due_date', '>=', now())
                ->sortBy('due_date')
                ->take(5)
        ];

        // Debug logging
        Log::info('Project Stats:', [
            'user_id' => $userId,
            'project_count' => $projects->count(),
            'task_counts' => [
                'todo' => $stats['todo'],
                'ongoing' => $stats['ongoing'],
                'completed' => $stats['completed']
            ]
        ]);

        return view('pages.Dashboard', compact('stats'));
    }
}
