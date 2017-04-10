@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default">
                    <div class="panel-heading">Open Loops</div>
                    <div class="panel-body">
                        @if($projects)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Project</th>
                                    <th>Open Loops</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projects as $project)
                                    <tr>
                                        <td>{{ $project->name }}</td>
                                        <td>{{ $project->loops()->open()->count() }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        @else
                            <img class="img-responsive center-block" src="/images/nothing_to_do_here.png">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection