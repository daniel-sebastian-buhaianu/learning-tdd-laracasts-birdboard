<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    public function store(Project $project, Request $request)
    {
        $request->validate(['body' => 'required']);

        $project->addTask(request('body'));

        return redirect($project->path());
    }
}
