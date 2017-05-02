<?php

namespace App\Http\Controllers;

use Loops\Models\Agency;
use Loops\Models\Team;
use Loops\Models\Contact;
use Illuminate\Http\Request;

class AgenciesController extends Controller
{
    public function index()
    {
        $agencies = Team::getFromSession()->agencies;

        return view('agencies.index', compact('agencies'));
    }

    public function store(Request $request, Agency $agency = null)
    {
        if (! $agency) {
            $agency = new Agency();
        }
        $team = Team::getFromSession();
        $agency->team()->associate($team)->save();
        $agency->fill($request->agency);
        $contact = new Contact($request->contact);
        $agency->addContact($contact);
        $agency->save();

        return response()->json($agency);
    }

    public function show(Request $request, Agency $agency)
    {
        return view('agencies.show', compact('agency'));
    }

    public function addContact(Request $request, Agency $agency)
    {
        $contact = new Contact($request->contact);
        $agency->addContact($contact);

        return response()->json('');
    }
}
