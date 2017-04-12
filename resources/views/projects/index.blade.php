@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row loop-header">
            <div class="col-md-9">
                <h2 class="loop-title">Projects</h2>
            </div>
            <div class="col-md-3">
                <div class="header-buttons">
                    <button type="button" class="btn btn-default btn-block" data-toggle="modal" data-target="#new-project-modal">New Project</button>
                </div>
            </div>
        </div>
        <div class="row loop-buttons"></div>

        <div class="row">
            @if($projects)
                @foreach($projects as $project)
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading clearfix">
                                <div class="pull-right">
                                    <button class="btn btn-default btn-xs"
                                            onclick="newLoop({{ $project->id }})">
                                        <span class="glyphicon glyphicon-plus"></span>
                                    </button>
                                </div>
                                <h2 class="panel-title"><a href="/projects/{{ $project->id }}" class="style-link">{{ $project->name }}</a></h2>
                            </div>
                            <div class="panel-body">
                                @if($project->loops()->count() >=1 )
                                    @if($project->loops()->open()->count() >= 1)
                                        <span class="project-loop-status">Open Loops:</span>
                                        <ul class="project-loops">
                                            @foreach($project->loops()->open()->get() as $l)
                                                <li class="project-loop"><a href="/loops/{{ $l->id }}" class="style-link"><span class="glyphicon glyphicon-refresh"></span> {{ $l->name }}</a></li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    @if($project->loops()->closed()->count() >= 1)
                                        <span class="project-loop-status">Closed Loops:</span>
                                        <ul class="project-loops">
                                            @foreach($project->loops()->closed()->get() as $l)
                                                <li><a href="/loops/{{ $l->id }}" class="style-link"> {{ $l->name }}</a></li>
                                            @endforeach
                                        </ul>
                                    @endif
                                @else
                                    <span class="project-loop-status">No loops yet.</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    @include('projects._new-project-modal')
@endsection