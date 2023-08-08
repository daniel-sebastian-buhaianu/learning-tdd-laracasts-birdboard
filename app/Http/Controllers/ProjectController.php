<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        return view('projects.index', [
            'projects' => auth()->user()->projects,
        ]);
    }

    public function store()
    {
        $attributes = request()->validate([
            'title' => 'required', 
            'description' => 'required',
            'notes' => 'min:3',
        ]);

        $project = auth()->user()->projects()->create($attributes);
        
        return redirect($project->path());
    }

    public function show(Project $project)
    {
        $this->authorize('update', $project);
        
        return view('projects.show', [
            'project' => $project
        ]);
    }

    public function update(Project $project)
    {
        $this->authorize('update', $project);
 
        $project->update(request(['notes']));

        return redirect($project->path());
    }

    public function create()
    {
        return view('projects.create');
    }
}
