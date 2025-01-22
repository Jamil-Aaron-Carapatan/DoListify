<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'assigned_to',
        'due_date',
        'due_time',
        'priority',
        'status',
        'attachment',
        'project_id',
        'reminder_time',
        'created_by'  // Add this
    ];
    public function checklist()
    {
        return $this->hasMany(TaskChecklist::class)->orderBy('order');
    }

    protected $casts = [
        'due_date' => 'date',
        'due_time' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($currentTask) {
            // Create notification for task owner
            Notification::create([
                'user_id' => $currentTask->created_by,
                'type' => 'task_created',
                'message' => "Task '{$currentTask->name}' has been successfully created",
                'link' => "/DoListify/Task/{$currentTask->id}",
            ]);

            // If it's a team project task, notify assigned members
            if ($currentTask->project_id && $currentTask->project && $currentTask->project->type === 'Team' && $currentTask->assigned_to) {
                Notification::create([
                    'user_id' => $currentTask->assigned_to,
                    'type' => 'task_assigned',
                    'message' => "A new task '{$currentTask->name}' has been assigned to you",
                    'link' => "/DoListify/Task/{$currentTask->id}",
                ]);
            }
        });
    }

    /**
     * Get the project that owns the task.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function task_comments()
    {
        return $this->hasMany(Comment::class, 'task_id');
    }

}
