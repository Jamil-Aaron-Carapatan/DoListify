<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\ChecklistItem;

class TaskController extends Controller
{
    public function taskview(Task $task)
    {
        $tasks = Task::where('created_by', auth()->id())->get();
        return view('TasksView', compact('tasks'));
    }

    public function show($id, Request $request)
    {
        // Fetch the requested task with related comments
        $currentTask = Task::with('task_comments.user') // Load related task comments and user
            ->where('id', $id)
            ->where('created_by', auth()->id())
            ->firstOrFail();

        // Fetch all tasks for the user
        $tasks = Task::where('created_by', auth()->id())->get();

        // Handle comment form submission
        if ($request->isMethod('post')) {
            // Validate the comment and file upload (if any)
            $validated = $request->validate([
                'comment' => 'nullable|string',
                'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip|max:10240', // Validate file types and size
            ]);

            // Check if at least one of comment or file is provided
            if (!$request->filled('comment') && !$request->hasFile('file')) {
                return back()->withErrors('You must provide either a comment or a file.');
            }

            // Handle file upload (if any)
            $filePath = null;
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = $file->getClientOriginalName();
                $filePath = $file->storeAs('comments', $fileName, 'public');
            }

            // Save the comment
            $currentTask->task_comments()->create([
                'user_id' => auth()->id(),
                'comment' => $validated['comment'] ?? '', // Default to empty string if no comment
                'file_path' => $filePath, // Save the file path if there is an uploaded file
            ]);

            // Redirect back to the task view with a success message
            return back()->with('success', 'Comment added successfully');
        }

        // Define the view data to pass to the view
        $type = 'personal';

        // Pass all tasks and the current task to the view
        return view('pages.TasksView', compact('tasks', 'currentTask', 'type'));
    }


    public function addComment(Request $request, $id)
    {
        $validated = $request->validate([
            'comment' => 'required|string',
            'file' => 'nullable|file|  max:2048',
        ]);

        try {
            // Find the task
            $task = Task::findOrFail($id);

            // Save the comment
            $comment = $task->comments()->create([
                'user_id' => auth()->id(),
                'comment' => $validated['comment'],
                'file_path' => $request->file('file') ? $request->file('file')->store('comments') : null,
            ]);

            return redirect()->back()->with('success', 'Comment added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add the comment. Please try again.');
        }
    }

    public function create(Request $request)
    {
        $dueDate = $request->query('due_date');
        // You can pass any additional data needed for task creation
        return view('pages.CreateTask', compact('dueDate'));
    }

    public function getTask($id)
    {
        $task = Task::with('checklist')->findOrFail($id);
        return response()->json($task);
    }

    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|string|in:To Do,Ongoing,Done',
        ]);
        $task->update([
            'status' => $request->status,
        ]);
        return redirect()->back()->with('success', 'Task status updated successfully.');
    }

    public function storeAttachment(Request $request, $projectId)
    {
        $request->validate([
            'attachment' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip|max:10240',
        ]);

        // Get the existing task for this project
        $task = Task::where('project_id', $projectId)->first();

        if (!$task) {
            return back()->with('error', 'Task not found');
        }

        // Handle old attachment if it exists
        if ($task->attachment) {
            Storage::disk('public')->delete($task->attachment);
        }

        $file = $request->file('attachment');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('attachments', $fileName, 'public');

        // Update the existing task with the new attachment
        $task->update([
            'attachment' => $filePath
        ]);

        return back()->with('success', 'Attachment uploaded successfully');
    }
    public function update(Request $request, $taskId)
    {
        try {
            // Find the task to update
            $task = Task::findOrFail($taskId);

            // Validate incoming request data
            $validated = $request->validate([
                'description' => 'nullable|string',
                'items' => 'nullable|array',
                'items.*.id' => 'nullable|string',
                'items.*.name' => 'nullable|string',
                'items.*.completed' => 'nullable|boolean',
                'items.*.deleted' => 'nullable|boolean', // Validate the 'deleted' flag
            ]);

            // Update the task description
            $description = isset($validated['description']) ? trim($validated['description']) : null;
            $task->description = $description;

            // Update checklist items (creating, updating, or nullifying as needed)
            if (isset($validated['items'])) {
                foreach ($validated['items'] as $itemData) {
                    if (isset($itemData['deleted']) && $itemData['deleted'] == 1) {
                        // If the 'deleted' flag is 1, nullify the checklist item
                        $item = ChecklistItem::find($itemData['id']);
                        if ($item && $item->task_id == $task->id) {
                            // Nullify the item instead of deleting
                            $item->name = null;
                            $item->completed = null; // Or set it to whatever you want as "deleted" state
                            $item->save();  // Save the changes
                        }
                    } else {
                        if (isset($itemData['id']) && str_starts_with($itemData['id'], 'new-')) {
                            // Create a new checklist item if the ID starts with "new-"
                            ChecklistItem::create([
                                'task_id' => $task->id,
                                'name' => $itemData['name'],
                                'completed' => $itemData['completed'] ?? false,
                            ]);
                        } elseif (isset($itemData['id'])) {
                            // Otherwise, update existing checklist items
                            $item = ChecklistItem::findOrFail($itemData['id']);
                            $item->update([
                                'name' => $itemData['name'],
                                'completed' => $itemData['completed'],
                            ]);
                        }
                    }
                }
            }

            // Save the task
            $task->save();

            return response()->json(['success' => true, 'message' => 'Task updated successfully.']);
        } catch (\Exception $e) {
            \Log::error('Error updating task: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'There was an error updating the task.'], 500);
        }
    }

}
