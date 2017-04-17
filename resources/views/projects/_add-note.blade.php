<div class="modal fade" id="add-note-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Add Note</h4>
            </div>
            <div class="modal-body">
                <form id="new-note-form">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Note</label>
                                <textarea name="note" class="form-control" style="resize: none" rows="5">{{ old('note') }}</textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="addNote()">Add Note</button>
            </div>
        </div>
    </div>
</div>
@section('scripts')
    @parent
    <script>
        function addNote() {
            $.ajax('{{ route('project-add-note', ['project' => $project]) }}', {
                type: "POST",
                data: $("#new-note-form").serialize(),
                success: function(){
                    swal("Note Added!", "", "success");
                    window.location.reload();
                },
                error: function (error) {
                    swal("Error","see console", "error");
                    console.log(error.responseJSON);
                }
            });
        }
    </script>
@endsection