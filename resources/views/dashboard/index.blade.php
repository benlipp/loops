@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="pull-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#new-loop-modal">New Loop</button>
                </div>
                <h2>Open Loops</h2>
                <br>
            </div>
        </div>
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
                                <h2 class="panel-title">{{ $project->name }}</h2>
                            </div>
                            <div class="panel-body">
                                @foreach($project->loops()->open()->get() as $l)
                                    <p><span class="glyphicon glyphicon-refresh"></span> {{ $l->name }}</p>
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