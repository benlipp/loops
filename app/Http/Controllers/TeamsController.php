<?php

namespace App\Http\Controllers;

use Loops\Models\Team;
use Illuminate\Http\Request;

class TeamsController extends Controller
{
    public function teamSelect(Team $team, Request $request)
    {
        $teams = collect($request->user()->teams()->get()->toArray());
        if (! $teams->contains('id', $team->id)) {
            return redirect()->route('dashboard')->with('error', 'You do not belong to that team.');
        }
        $request->session()->put('team_id', $team->id);

        return redirect()->route('dashboard');
    }
}
