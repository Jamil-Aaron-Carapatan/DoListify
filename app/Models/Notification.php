<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',       // The ID of the user who receives the notification
        'type',          // The type/category of the notification (e.g., 'project_created', 'task_assigned')
        'message',       // The content of the notification
        'link',          // Optional link to the related resource (e.g., project/task URL)
        'status',        // Notification status (e.g., 'unread', 'read')
        'project_id',    // Optional project ID related to the notification
    ];

    /**
     * Default values for attributes.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'status' => 'unread', // Default status is 'unread'
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array<string>
     */
    protected $with = ['user', 'project'];

    /**
     * Relationship: Notification belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: Notification may belong to a project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Scope to filter unread notifications.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnread($query)
    {
        return $query->where('status', 'unread');
    }

    /**
     * Scope to filter read notifications.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRead($query)
    {
        return $query->where('status', 'read');
    }

    /**
     * Mark the notification as read.
     *
     * @return void
     */
    public function markAsRead()
    {
        $this->update(['status' => 'read']);
    }

    /**
     * Generate a link for the notification if applicable.
     *
     * @return string|null
     */
    public function getLinkAttribute()
    {
        return $this->attributes['link'] ?: optional($this->project)->route('task', $this->project_id);
    }
}
