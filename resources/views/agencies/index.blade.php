@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row loop-header">
            <div class="col-md-9">
                <h2 class="loop-title">Agencies</h2>
            </div>
            <div class="col-md-3">
                <div class="header-buttons">
                    <button type="button" class="btn btn-default btn-block" data-toggle="modal" data-target="#new-agency-modal">New Agency</button>
                </div>
            </div>
        </div>
        <div class="row loop-buttons"></div>

        <div class="row">
            @if($agencies)
                @foreach($agencies as $agency)
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading clearfix">
                                <h2 class="panel-title"><a href="{{ route('agency-show', ['agency' => $agency ]) }}" class="style-link">{{ $agency->name }}</a></h2>
                            </div>
                            <div class="panel-body">
                                <strong>{{ $agency->primaryContact->name }}</strong>
                                <ul class="project-loops">
                                    <li>{{ $agency->primaryContact->email }}</li>
                                    <li>{{ $agency->primaryContact->phone }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    @include('agencies._new-agency-modal')
@endsection