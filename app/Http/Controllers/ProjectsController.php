<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Loops\Models\Contact;
use Loops\Models\Project;

class ProjectsController extends Controller
{

    public function index(Request $request)
    {
        $projects = $request->user()->projects;

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
        // TODO: this feels like a security flaw, (on update) we should check if the project already exists first...
        $project->addUser($request->user());
        $contact = new Contact($request->contact);
        $contact->project()->associate($project)->save();

        if ($request->note) {
            $project->addNote($request->note);
        }

        return back()->with('status', 'Success');
    }

    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }
}
