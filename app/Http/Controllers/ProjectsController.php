<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Loops\Models\Project;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return view('project.index', compact('projects'));
    }
}
