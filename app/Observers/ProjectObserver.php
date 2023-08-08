<?php

namespace App\Observers;

use App\Models\Project;
use App\Models\Activity;

class ProjectObserver
{
    /**
     * Handle the Project "created" event.
     */
    public function created(Project $project): void
    {
        $this->recordActivity('created', $project);
    }

    /**
     * Handle the Project "updated" event.
     */
    public function updated(Project $project): void
    {
        $this->recordActivity('updated', $project);
    }

    protected function recordActivity(string $type, Project $project)
    {
        Activity::create([
            'project_id' => $project->id,
            'description' => $type,
        ]);
    }
}
