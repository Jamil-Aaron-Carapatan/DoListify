<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function taskview($projectId, Request $request)
    {
        // Fetch project by ID with tasks and team members
        $project = Project::with(['tasks', 'members', 'comments.user'])->findOrFail($projectId);
        $task = $project->tasks->first(); // Fetch the first task or a specific task

        // Handle comment form submission
        if ($request->isMethod('post')) {
            // Validate the request
            $request->validate([
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
            Comment::create([
                'project_id' => $projectId,
                'user_id' => Auth::id(),
                'comment' => $request->input('comment') ?? '', // Default to empty string if no comment
                'file_path' => $filePath, // Save the file path
            ]);

            // Redirect back to the task view with a success message
            return back()->with('success', 'Comment added successfully');
        }

        return view('pages.TasksView', compact('project', 'task'));
    }

    public function updateTask(Request $request)
    {
        $task = Task::findOrFail($request->task_id);
        $task->update($request->only('name', 'description'));

        // Update checklist items
        $task->checklist()->delete();
        foreach ($request->checklist as $item) {
            $task->checklist()->create($item);
        }

        return redirect()->back()->with('success', 'Task updated successfully.');
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
}
