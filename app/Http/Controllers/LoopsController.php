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
            'name' => 'required|max:255',
            'project' => 'required',
            'note' => 'required'
        ]);

        // TODO: Secure this
        $project = Project::find($request->project);

        $loop = new Loop(['name' => $request->name]);
        $project->addLoop($loop);
        $note = new Note([
            'body' => $request->note
        ]);
        $loop->open($note);
        return back()->with('status', 'Saved');
    }

    public function show(Loop $loop)
    {
        return view('loops.loop', ['theLoop' => $loop]);
    }

    public function addNote(Request $request, Loop $loop)
    {
        $this->validate($request, [
            'note' => 'required'
        ]);
        $note = new Note([
            'body' => $request->note
        ]);
        $loop->addNote($note);
        return back()->with('status', 'Saved');
    }
}
