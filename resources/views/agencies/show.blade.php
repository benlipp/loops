@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row loop-header">
            <div class="col-md-9">
                <h2 class="loop-title">{{ $agency->name }}</h2>
                <ul class="loop-details">
                    <li><strong>Lead: </strong>{{ $agency->primaryContact->name }}</li>
                    <li><strong>Email: </strong>{{ $agency->primaryContact->email }}</li>
                    <li><strong>Phone: </strong>{{ $agency->primaryContact->phone }}</li>
                </ul>
            </div>
            <div class="col-md-3">
                <div class="header-buttons">
                    <button type="button" class="btn btn-default btn-block" data-toggle="modal"
                            data-target="#new-contact-modal">New Contact
                    </button>
                </div>
            </div>
        </div>
        <div class="row loop-buttons"></div>
        <div class="row">
            <div class="col-md-8">
                <h4>Projects</h4>
                <div class="row">
                    @foreach($agency->projects as $project)
                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading clearfix">
                                    <h2 class="panel-title"><a
                                                href="{{ route('project-show', ['project' => $project] ) }}"
                                                class="style-link">{{ $project->name }}</a></h2>
                                </div>
                                <div class="panel-body">
                                    <ul class="project-loops">
                                        <li><strong>Open Loops: </strong>{{ $project->loops()->open()->count() }}</li>
                                        <li><strong>Closed Loops: </strong>{{ $project->loops()->closed()->count() }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4">
                <h4>Contacts</h4>
                @foreach($agency->contacts as $contact)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading clearfix">
                                    <h2 class="panel-title">{{ $contact->name }} {{$loop->first?'(primary)':''}}</h2>
                                </div>
                                <div class="panel-body">
                                    <ul class="project-loops">
                                        <li>{{ $contact->email }}</li>
                                        <li>{{ $contact->phone }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @include('agencies._new-contact-modal')
@endsection