<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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


    public function create(Request $request)
    {
        $dueDate = $request->query('due_date');
        // You can pass any additional data needed for task creation
        return view('pages.CreateTask', compact('dueDate'));
    }

    public function updateStatus(Request $request, Task $task)
    {
        // Validate the input
        $request->validate([
            'status' => 'required|string|in:To Do,Ongoing,Done',
        ]);

        // Update the task's status
        $task->update([
            'status' => $request->status,
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Task status updated successfully.');
    }
    public function storeAttachment(Request $request, $taskId)
    {
        // Validate the file
        $request->validate([
            'attachment' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip|max:10240', // Maximum size of 10MB
        ]);

        try {
            // Find the task
            $task = Task::findOrFail($taskId);

            // Handle file upload
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $fileName = time() . '_' . $file->getClientOriginalName(); // Ensure unique file name
                $filePath = $file->storeAs('task_attachments', $fileName, 'public'); // Store in 'task_attachments' folder

                // Save the file path in the task record
                $task->update([
                    'attachment' => $filePath, // Store the file path in the 'attachment' column
                ]);
            }
            return redirect()->back()->with('success', 'Task status updated successfully.');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Attachment upload failed:', ['error' => $e->getMessage()]);

            return back()->withErrors('Failed to upload attachment. Please try again.');
        }
    }


}
