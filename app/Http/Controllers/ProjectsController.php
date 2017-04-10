<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Loops\Models\Project;

class ProjectsController extends Controller
{
    public function index(Request $request)
    {
        $projects = $request->user()->projects;
        return view('projects.index', compact('projects'));
    }
}
