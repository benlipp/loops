<div class="modal fade" id="new-loop-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Open a Loop</h4>
            </div>
            <div class="modal-body">
                <form id="new-loop-form" action="/loops" method="POST">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name</label>
                                <input name="name" class="form-control" value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Project</label>
                                <select name="project" class="form-control">
                                    @foreach( \Auth::user()->teams as $team)
                                        <optgroup label="{{ $team->name }}">
                                            @foreach($team->projects as $project)
                                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Note</label>
                                <textarea name="note" class="form-control" value="{{ old('note') }}" style="resize: none" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="sendForm()">Open the Loop</button>
            </div>
        </div>
    </div>
</div>
@section('scripts')
    @parent
    <script>
        function sendForm() {
            $.ajax('/loops', {
                type: "POST",
                data: $("#new-loop-form").serialize(),
                success: function(){
                    window.location = window.location;
                },
                error: function (error) {
                    alert("Error, see console");
                    console.log(error.responseJSON);
                }
            });
        }
    </script>
@endsection