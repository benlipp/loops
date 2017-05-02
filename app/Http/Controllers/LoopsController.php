<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Loops\Models\Loop;
use Loops\Models\Note;
use Loops\Models\Nugget;
use Loops\Models\Project;
use Loops\Models\Team;

class LoopsController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'    => 'required|max:255',
            'project' => 'required',
            'note'    => 'required',
        ]);

        $project = Project::find($request->project);
        $loop = new Loop(['name' => $request->name]);
        $project->addLoop($loop);
        $loop->open(new Note([
            'body' => $request->note,
        ]));

        return response()->json([
            'url' => route('loop-show', ['loop' => $loop]),
        ]);
    }

    public function show(Loop $loop)
    {
        return view('loops.show', ['theLoop' => $loop]);
    }

    public function addNote(Loop $loop, Request $request)
    {
        $this->validate($request, [
            'note' => 'required',
        ]);

        $loop->addNote(new Note([
            'body' => $request->note,
        ]));

        return back()->with('status', 'Saved');
    }

    public function close(Loop $loop, Request $request)
    {
        $this->validate($request, [
            'note' => 'required',
        ]);

        $loop->close(new Note([
            'body' => $request->note,
        ]));

        return back()->with('status', 'Saved');
    }

    public function addNugget(Loop $loop, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'data' => 'required',
        ]);
        $nugget = new Nugget([
            'name' => $request->name,
            'data' => $request->data,
        ]);
        $loop->addNugget($nugget);

        return response()->json('');
    }

    public function assignUser(Loop $loop, Request $request)
    {
        $user = User::find($request->user);
        $loop->assignTo($user);

        return response()->json('');
    }

    public function assignedToUser(Request $request)
    {
        $selectedUser = User::find($request->user) ?? null;
        $projects = Team::getFromSession()->projects()->loopsByUser($selectedUser)->openLoops()->get();

        return view('loops.assigned-to-user', compact('selectedUser', 'projects'));
    }
}
