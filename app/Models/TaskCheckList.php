<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskChecklist extends Model
{
    use HasFactory;

    protected $table = 'task_checklists';

    protected $fillable = [
        'task_id',
        'name',
        'completed',
        'order'
    ];

    protected $casts = [
        'completed' => 'boolean',
    ];

    protected $attributes = [
        'completed' => false,
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}

