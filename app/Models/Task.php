<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'name',
        'description',
        'assigned_to',
        'due_date',
        'due_time',
        'priority',
        'status',
        'attachment',
    ];

    protected $casts = [
        'due_date' => 'date',
        'due_time' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($task) {
            // Create notification for task owner
            Notification::create([
                'user_id' => $task->project->created_by,
                'type' => 'task_created',
                'message' => "Task '{$task->name}' has been successfully created",
                'link' => "/DoListify/Task/{$task->project_id}",
            ]);

            // If it's a team project, notify assigned members
            if ($task->project->type === 'Team' && $task->assigned_to) {
                Notification::create([
                    'user_id' => $task->assigned_to,
                    'type' => 'task_assigned',
                    'message' => "A new task '{$task->name}' has been assigned to you",
                    'link' => "/DoListify/Task/{$task->project_id}",
                ]);
            }
        });
    }

    /**
     * Get the project that owns the task
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user assigned to the task
     */
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the users assigned to the task
     */
    public function assignees()
    {
        return $this->belongsToMany(User::class, 'task_user', 'task_id', 'user_id');
    }

    /**
     * Get the assignee of the task
     */
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    public function task_comments()
    {
        return $this->hasMany(Comment::class, 'task_id');
    }
    
}
