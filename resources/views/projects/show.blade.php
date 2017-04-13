@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row loop-header">
            <div class="col-md-8">
                <h2 class="loop-title">{{ $project->name }}</h2>
                @if($project->contacts()->count() > 0)
                    <ul class="loop-details">
                        <li><strong>Client: </strong>{{ $project->contacts()->first()->name }}</li>
                        @if($project->contacts()->first()->email)
                            <li>
                                <strong>E-Mail: </strong>
                                <a class="style-link" href="mailto:{{ $project->contacts()->first()->email }}">{{ $project->contacts()->first()->email }}</a>
                            </li>
                        @endif
                        @if($project->contacts()->first()->phone)
                            <li>
                                <strong>Phone: </strong>
                                <a class="style-link" href="tel:{{ $project->contacts()->first()->phone }}">{{ $project->contacts()->first()->phone }}</a>
                            </li>
                        @endif
                    </ul>
                @else
                    <ul class="loop-details">
                        <li>contact info here (this project doesn't have any)</li>
                    </ul>
                @endif
            </div>
            <div class="col-md-4">
                <ul class="loop-status">
                    <li><span>Open Loops</span>:<span>{{ $project->loops()->open()->count() }}</span></li>
                    <li><span>Closed Loops</span>:<span>{{ $project->loops()->closed()->count() }}</span></li>
                    <li><span>Created At</span>:<span>{{ $project->created_at->format('F j, Y') }}</span></li>
                </ul>
            </div>
        </div>
        <div class="row nuggets">
            <div class="col-md-12">
                @if($project->nuggets)
                    <ul class="nugget-group">
                        @foreach($project->nuggets as $nugget)
                            <li><span class="nugget-name">{{ $nugget->name }} </span>{{ $nugget->data }}</li>
                        @endforeach
                    </ul>
                @endif
                <a href="#" data-toggle="modal" data-target="#nugget-modal"><span class="glyphicon glyphicon-plus"></span> New Nugget</a>
            </div>
        </div>
        <div class="row loop-buttons">
            <div class="col-md-3">
                <button class="btn btn-block btn-default" data-toggle="modal" data-target="#open-loop-modal" onclick="alert('use /loops for now');">Open A Loop</button>
            </div>
            <div class="col-md-3 col-md-offset-6">
                <button class="btn btn-block btn-default" data-toggle="modal" data-target="#add-note-modal" onclick="alert('not implemented yet');">Add Note</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">
                            Open Loops
                        </h2>
                    </div>
                    <div class="panel-body">
                        <ul class="project-loops">
                        @foreach($project->loops()->open()->get() as $l)
                            <li><a class="style-link" href="/loops/{{ $l->id }}"><span class="glyphicon glyphicon-refresh"></span> {{ $l->name }}</a></li>
                        @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">
                            Closed Loops
                        </h2>
                    </div>
                    <div class="panel-body">
                        <ul class="project-loops">
                            @foreach($project->loops()->closed()->get() as $l)
                                <li><a class="style-link" href="/loops/{{ $l->id }}">{{ $l->name }}</a></li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @foreach($project->notes as $note)
                    <div class="panel panel-default">
                        <div class="loop-note">
                            <h3>From: {{ $note->author->name }}
                                <small data-toggle="tooltip" data-placement="right" title="{{ $note->created_at->format('g:i:s a, F j, Y') }}">
                                    {{ $note->created_at->diffForHumans() }}
                                </small>
                            </h3>
                            {!! $note->displayBody !!}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @include('projects._nugget-modal')
@endsection

@section('scripts')
    @parent
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endsection
