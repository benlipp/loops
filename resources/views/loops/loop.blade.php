@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row loop-header">
            <div class="col-md-8">
                <h2 class="loop-title">{{ $loop->name }}</h2>
                <ul class="loop-details clearfix">
                    <li><strong>Client: </strong>Loop Client</li>
                    <li><strong>Agency: </strong>LoopAgency</li>
                    <li><strong>Project: </strong><a class="style-link" href="#">LoopProject</a></li>
                </ul>
                <span class="loop-description">
                    Loop description here because things happen sometimes
                </span>
            </div>
            <div class="col-md-4">
                <ul class="loop-status">
                    <li><span>Opened By</span>: <span>{{ $loop->openedBy->name }}</span></li>
                    <li><span>On</span>: <span>{{ $loop->created_at->format('F j, Y') }}</span></li>
                    <li><span>Latest Status</span>: <span><strong>{{ $loop->status }}</strong></span></li>
                </ul>
            </div>
        </div>
        <div class="row loop-buttons">
            <div class="col-md-3">
                <button class="btn btn-block btn-default">New Note</button>
            </div>
            <div class="col-md-3 col-md-offset-6">
                <button class="btn btn-block btn-default">Close Loop</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @foreach($loop->notes as $note)
                    <div class="panel panel-default">
                        <div class="loop-note">
                            <h2>From: {{ $note->author->name }} <small>{{ $note->created_at->format('F j, Y') }}</small></h2>
                            {!! $note->displayBody !!}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection