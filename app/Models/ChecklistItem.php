<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class ChecklistItem extends Model {
    protected $table = 'task_checklists';
    protected $fillable = ['task_id', 'name', 'completed', 'order'];
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
