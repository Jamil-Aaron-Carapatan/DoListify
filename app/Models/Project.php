<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'created_by'
    ];

    /**
     * Get all tasks for the project
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get all members of the project
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_members')
            ->withPivot('role')
            ->withTimestamps();
    }

    /**
     * Get the creator of the project
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the leader of the project
     */
    public function leader()
    {
        return $this->members()->wherePivot('role', 'owner')->first();
    }

    /**
     * Get the regular members of the project
     */
    public function regularMembers()
    {
        return $this->members()->wherePivot('role', 'member')->get();
    }

    /**
     * Get all project members
     */
    public function projectMembers()
    {
        return $this->hasMany(ProjectMember::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'project_id');
    }
}
