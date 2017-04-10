<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Loops\Models\Loop;
use Loops\Models\Note;
use Loops\Models\Project;

class LoopsController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'project' => 'required',
            'note' => 'required'
        ]);
        $project = Project::find($request->project);
        $loop = new Loop(['name' => $request->name]);
        $project->addLoop($loop);
        $note = new Note([
            'body' => $request->note
        ]);
        $loop->addNote($note, $request->user());
        return back()->with('status', 'Saved');
    }
}
