@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row loop-header">
            <div class="col-md-8">
                <h2 class="loop-title">{{ $theLoop->name }}</h2>
                <ul class="loop-details">
                    <li><strong>Project: </strong><a class="style-link"
                                                     href="/projects/{{ $theLoop->project->id }}">{{ $theLoop->project->name }}</a>
                    </li>
                    <li><strong>Agency: </strong>Loop Agency</li>
                    <li><strong>Client: </strong>Loop Client</li>
                </ul>
                <div>
                    <strong>Descrtiption: </strong> <?=$theLoop->display_description?>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="loop-status">
                    <li><span>Opened By</span>: <span>{{ $theLoop->openedBy->name }}</span></li>
                    <li><span>On</span>: <span>{{ $theLoop->created_at->format('F j, Y') }}</span></li>
                    <li><span>At</span>: <span>{{ $theLoop->created_at->format('g:i a') }}</span></li>
                    <li><span>Latest Status</span>: <span><strong>{{ $theLoop->status }}</strong></span></li>
                </ul>
            </div>
        </div>
        <div class="row nuggets">
            <div class="col-md-8">
                @if($theLoop->nuggets)
                    <ul class="nugget-group">
                        @foreach($theLoop->nuggets as $nugget)
                            <li><span class="nugget-name">{{ $nugget->name }} </span>{{ $nugget->data }}</li>
                        @endforeach
                    </ul>
                @endif
                <a href="#" data-toggle="modal" data-target="#nugget-modal"><span
                            class="glyphicon glyphicon-plus"></span> New Nugget</a>
            </div>
            <div class="col-md-4">
                <select class="form-control" id="user-select">
                    <option value="">Nobody</option>
                    @foreach($theLoop->project->team->users as $user)
                        @if($theLoop->user && $theLoop->user->id == $user->id)
                            <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                        @else
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row loop-buttons">
            <div class="col-md-3">
                <button class="btn btn-block btn-default" data-toggle="modal" data-target="#new-note-modal">New Note
                </button>
            </div>
            <div class="col-md-3 col-md-offset-6">
                @if($theLoop->isOpen())
                    <button class="btn btn-block btn-default" data-toggle="modal" data-target="#close-loop-modal">Close
                        Loop
                    </button>
                @else
                    <button class="btn btn-block btn-default" data-toggle="modal" data-target="#open-loop-modal">Open
                        Loop
                    </button>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @foreach($theLoop->notes as $note)
                    <div class="panel panel-default">
                        <div class="loop-note">
                            <h3>From: {{ $note->author->name }}
                                <small data-toggle="tooltip" data-placement="right"
                                       title="{{ $note->created_at->format('g:i:s a, F j, Y') }}">
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

    @include('loops._new-note-modal')
    @include('loops._close-loop-modal')
    @include('loops._nugget-modal')
@endsection

@section('scripts')
    @parent
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
            $("#user-select").on('change', function () {
                var user = $(this).val();
                console.log('(example) User change to: ' + user);

                $.ajax('{{ route('loop-assign-user', ['loop' => $theLoop]) }}', {
                    type: "POST",
                    data: {
                        "user": user
                    },
                    success: function () {
                        console.log('success');
                        swal("User assigned!", "Loop assigned to user.", "success");
                    },
                    error: function (error) {
                        alert("Error, see console");
                        console.log(error.responseJSON);
                    }
                });
            });
        });
    </script>
@endsection
