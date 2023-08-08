<?php

namespace Tests\Arrangements;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class ProjectArrangement
{
    protected $tasksCount = 0;

    protected $user;

    public function withTasks(int $count)
    {
        $this->tasksCount = $count;

        return $this;
    }

    public function ownedBy(User $user)
    {
        $this->user = $user;

        return $this;
    }

    public function create()
    {
        $project = Project::factory()->create();

        Task::factory($this->tasksCount)->create([
            'project_id' => $project->id
        ]);

        return $project;
    }
}