<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'created_by',
        'points',
    ];

    protected $casts = [
        'due_date' => 'date',
        'due_time' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($currentTask) {
            // Notify the task creator
            Notification::create([
                'user_id' => $currentTask->created_by,
                'type' => 'task_created',
                'message' => "Task '{$currentTask->name}' has been successfully created.",
                'link' => "/DoListify/Task/{$currentTask->id}",
            ]);

            // Notify the assigned member if it's a team task
            if ($currentTask->project_id && $currentTask->project && $currentTask->project->type === 'Team' && $currentTask->assigned_to) {
                Notification::create([
                    'user_id' => $currentTask->assigned_to,
                    'type' => 'task_assigned',
                    'message' => "A new task '{$currentTask->name}' has been assigned to you.",
                    'link' => "/DoListify/Task/{$currentTask->id}",
                ]);
            }
        });
    }

    /**
     * Get the project that owns the task.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user who created the task.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all comments associated with the task.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'task_id');
    }

    /**
     * Get the checklist items for the task.
     */
    public function checklist(): HasMany
    {
        return $this->hasMany(TaskChecklist::class)->orderBy('order');
    }
}
