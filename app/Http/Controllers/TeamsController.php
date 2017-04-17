<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Loops\Models\Team;

class TeamsController extends Controller
{
    public function teamSelect(Request $request, Team $team)
    {
        $teams = collect($request->user()->teams()->get()->toArray());
        if(! $teams->contains('id', $team->id)){
            return redirect()->route('dashboard')->with('error', 'You do not belong to that team.');
        }
        $request->session()->put('team_id', $team->id);
        return redirect()->route('dashboard');
    }
}
