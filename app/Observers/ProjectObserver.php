<?php

namespace App\Observers;

use App\Models\Project;

class ProjectObserver
{
    /**
     * Handle the Project "created" event.
     */
    public function created(Project $project): void
    {
        $project->recordActivity('project_created');
    }

    /**
     * Handle the Project "updating" event.
     */
    public function updating(Project $project): void
    {
        $project->old = $project->getOriginal();
    } 

    /**
     * Handle the Project "updated" event.
     */
    public function updated(Project $project): void
    {
        $project->recordActivity('project_updated');
    }
}
