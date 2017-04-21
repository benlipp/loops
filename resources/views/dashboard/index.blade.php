@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row loop-header">
            <div class="col-md-9">
                <h2 class="loop-title">Open Loops</h2>
            </div>
            <div class="col-md-3">
                <div class="header-buttons">
                    {{--@if(count(Auth::user()->projects) >= 1)--}}
                    <div class="row">
                        <button type="button" class="btn btn-default btn-block" data-toggle="modal" data-target="#new-loop-modal">Open a Loop</button>
                        <div class="dropdown" style="margin-top: 5px">
                            <button class="btn btn-default btn-block dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                View Assigned Loops
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <li><a href="{{ route('dashboard') }}">All</a></li>
                                <li><a href="{{ route('user-assigned-loops', ['user' => null ]) }}">Nobody</a></li>
                                <li role="separator" class="divider"></li>
                                @foreach(Team::getFromSession()->users as $user)
                                    <li><a href="{{ route('user-assigned-loops', ['user' => $user ]) }}">{{ $user->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    {{--@endif--}}
                </div>
            </div>
        </div>
        <div class="row loop-buttons">
            <div class="col-md-3">

            </div>
        </div>
        <div class="row">
            @if(count($projects) >= 1)
                @foreach($projects as $project)
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading clearfix">
                                <div class="pull-right">
                                    <button class="btn btn-default btn-xs"
                                            onclick="newLoop('{{ $project->id }}')">
                                        <span class="glyphicon glyphicon-plus"></span>
                                    </button>
                                </div>
                                <h2 class="panel-title"><a href="/projects/{{ $project->id }}" class="style-link">{{ $project->name }}</a></h2>
                            </div>
                            <div class="panel-body">
                                <ul class="project-loops">
                                    @foreach($project->loops()->open()->get() as $l)
                                        <li><a href="/loops/{{ $l->id }}" class="style-link"><span class="glyphicon glyphicon-refresh"></span> {{ $l->name }}</a></li>
                                    @endforeach
                                </ul>

                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="panel-title">No Open Loops!</h2>
                        </div>
                        <div class="panel-body">
                            <img class="img-responsive center-block" src="/images/nothing_to_do_here.png">
                        </div>
                    </div>
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