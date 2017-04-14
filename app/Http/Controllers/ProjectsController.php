<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Loops\Models\Contact;
use Loops\Models\Note;
use Loops\Models\Nugget;
use Loops\Models\Project;
use Loops\Models\Team;

class ProjectsController extends Controller
{

    public function index(Request $request)
    {
        $projects = Project::all();//$request->user()->projects;

        return view('projects.index', compact('projects'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name'          => 'required',
            'team'          => 'required',
            'contact.name'  => 'required',
            'contact.email' => 'required_without:contact.phone',
            'contact.phone' => 'required_without:contact.email',
        ]);

        $project = new Project([
            'name' => $request->name
        ]);
        $team = Team::find($request->team);
        $team->addProject($project);

        $contact = new Contact($request->contact);
        $project->addContact($contact);

        if ($request->note) {
            $project->addNote(new Note([
                'body' => $request->note
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
            'data' => 'required'
        ]);
        $nugget = new Nugget([
            'name' => $request->name,
            'data' => $request->data
        ]);
        $project->addNugget($nugget);

        return response()->json('');
    }
}
