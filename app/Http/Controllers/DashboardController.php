<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Loops\Models\Project;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        $projects = Project::openLoops()->get();//$request->user()->projects()->openLoops()->get();
        return view('dashboard.index', compact('projects'));
    }
}
