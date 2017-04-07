<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Loops\Models\Project;

class DashboardController extends Controller
{

    public function index()
    {
        $projects = Project::openLoops();
        return view('dashboard.index', compact('projects'));
    }
}
