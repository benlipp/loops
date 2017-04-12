@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row loop-header">
            <div class="col-md-9">
                <h2 class="loop-title">Open Loops</h2>
                <span class="loop-description">Some info maybe goes here?</span>
            </div>
            <div class="col-md-3">
                <div class="header-buttons">
                    <button type="button" class="btn btn-default btn-block" data-toggle="modal" data-target="#new-loop-modal">New Loop</button>
                    <button type="button" class="btn btn-default btn-block" data-toggle="modal" data-target="#new-loop-modal">New Project</button>
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
                                @foreach($project->loops()->open()->get() as $l)
                                    <p><a href="/loops/{{ $l->id }}" class="style-link"><span class="glyphicon glyphicon-refresh"></span> {{ $l->name }}</a></p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-md-12">
                    <img class="img-responsive center-block" src="/images/nothing_to_do_here.png">
                </div>
            @endif
        </div>
    </div>
    @include('dashboard._new-loop')
@endsection

@section('scripts')
    @parent
    <script>
        function newLoop(project_id)
        {
            $("select[name='project']").val(project_id);
            $('#new-loop-modal').modal();
        }
    </script>
@endsection