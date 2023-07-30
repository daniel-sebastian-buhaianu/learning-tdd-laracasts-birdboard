<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        return view('projects.index', [
            'projects' => Project::all(),
        ]);
    }

    public function store()
    {
        $attributes = request()->validate([
            'title' => 'required', 
            'description' => 'required',
        ]);

        auth()->user()->projects()->create($attributes);
        
        return redirect('/projects');
    }

    public function show(Project $project)
    {
        return view('projects.show', [
            'project' => $project
        ]);
    }
}
