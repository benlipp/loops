<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Loops\Models\Contact;
use Loops\Models\Note;
use Loops\Models\Nugget;
use Loops\Models\Project;

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
            'contact.name'  => 'required',
            'contact.email' => 'required_without:contact.phone',
            'contact.phone' => 'required_without:contact.email',
        ]);

        $project = new Project([
            'name' => $request->name
        ]);
        $project->save();

        // TODO: this feels like a security flaw (on update), we should check if the project already exists first, and only addUser() on new project
        $project->addUser($request->user());

        $contact = new Contact($request->contact);
        $contact->project()->associate($project)->save();

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
