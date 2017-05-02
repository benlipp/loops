<?php

namespace App\Http\Controllers;

use Loops\Models\Note;
use Loops\Models\Team;
use Loops\Models\Nugget;
use Loops\Models\Contact;
use Loops\Models\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index(Request $request)
    {
        $projects = Team::getFromSession()->projects;

        return view('projects.index', compact('projects'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'          => 'required',
            'contact.name'  => 'required',
            'contact.email' => 'required_without:contact.phone',
            'contact.phone' => 'required_without:contact.email',
        ]);

        $project = new Project([
            'name' => $request->name,
        ]);
        $project->agency_id = $request->agency;
        $team = Team::getFromSession();
        $team->addProject($project);

        $contact = new Contact($request->contact);
        $project->addContact($contact);

        if ($request->note) {
            $project->addNote(new Note([
                'body' => $request->note,
            ]));
        }

        return redirect()->route('project-show', ['project' => $project]);
    }

    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    public function addNugget(Project $project, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'data' => 'required',
        ]);
        $nugget = new Nugget([
            'name' => $request->name,
            'data' => $request->data,
        ]);
        $project->addNugget($nugget);

        return response()->json('');
    }

    public function addNote(Project $project, Request $request)
    {
        $this->validate($request, [
            'note' => 'required',
        ]);
        $note = new Note(['body' => $request->note]);
        $project->addNote($note);

        return response()->json('');
    }
}
