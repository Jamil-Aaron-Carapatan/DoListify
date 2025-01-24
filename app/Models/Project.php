<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'description',
        'created_by',
    ];

    /**
     * Get all tasks for the project.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'project_id');
    }

    /**
     * Get all members of the project.
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_members')
            ->withPivot('role')
            ->withTimestamps();
    }

    /**
     * Get the creator of the project.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the leader of the project (owner).
     */
    public function leader()
    {
        return $this->members()->wherePivot('role', 'owner')->first();
    }

    /**
     * Get the regular members of the project (excluding the leader).
     */
    public function regularMembers()
    {
        return $this->members()->wherePivot('role', 'member')->get();
    }

    /**
     * Get all project members as a direct relation.
     */
    public function projectMembers(): HasMany
    {
        return $this->hasMany(ProjectMember::class, 'project_id');
    }

    /**
     * Get all comments associated with the project.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'project_id');
    }
}
