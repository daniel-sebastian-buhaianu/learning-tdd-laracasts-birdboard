<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        // validate

        // persist
        Project::create(request(['title', 'description']));
        
        // redirect
        return redirect('/projects');
    }
}
