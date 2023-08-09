<?php

namespace App\Models;

use App\Models\Activity;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $touches = ['project'];

    protected $casts = [
        'completed' => 'boolean'
    ];

    public function complete()
    {
        $this->update(['completed' => true]);

        $this->recordActivity('task_completed');
    }

    public function incomplete()
    {
        $this->update(['completed' => false]);

        $this->recordActivity('task_not_completed');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function path()
    {
        return "/projects/{$this->project->id}/tasks/{$this->id}";
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

    public function recordActivity(string $description)
    {
        $this->activity()->create([
            'project_id' => $this->project_id,
            'description' => $description,
        ]);
    }
}
