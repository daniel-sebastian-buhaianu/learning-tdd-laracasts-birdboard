<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    public function store(Project $project, Request $request)
    {
        $this->authorize('update', $project);

        $request->validate(['body' => 'required']);

        $project->addTask(request('body'));

        return redirect($project->path());
    }

    public function update(Project $project, Task $task, Request $request)
    {
        $this->authorize('update', $task->project);

        $task->update($request->validate(['body' => 'required']));

        $method = $request->completed ? 'complete' : 'incomplete';

        $task->$method();

        return redirect($project->path());
    }
}
