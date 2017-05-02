<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Loops\Models\Team;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $projects = Team::getFromSession()->projects()->openLoops()->get();

        return view('dashboard.index', compact('projects'));
    }
}
