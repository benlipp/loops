<?php

namespace App\Http\Controllers;

use Loops\Models\Team;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $projects = Team::getFromSession()->projects()->openLoops()->get();

        return view('dashboard.index', compact('projects'));
    }
}
