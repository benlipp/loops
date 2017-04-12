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
        $this->validate($request, [
            'name'    => 'required|max:255',
            'project' => 'required',
            'note'    => 'required'
        ]);

        $project = Project::find($request->project);
        $loop = new Loop(['name' => $request->name]);
        $project->addLoop($loop);
        $loop->open(new Note([
            'body' => $request->note
        ]));

        return back()->with('status', 'Saved');
    }

    public function show(Loop $loop)
    {
        return view('loops.loop', ['theLoop' => $loop]);
    }

    public function addNote(Loop $loop, Request $request)
    {
        $this->validate($request, [
            'note' => 'required'
        ]);

        $loop->addNote(new Note([
            'body' => $request->note
        ]));

        return back()->with('status', 'Saved');
    }

    public function close(Loop $loop, Request $request)
    {
        $this->validate($request, [
            'note' => 'required'
        ]);

        $loop->close(new Note([
            'body' => $request->note
        ]));

        return back()->with('status', 'Saved');
    }
}
