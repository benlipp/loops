<div class="modal fade" id="new-project-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">New Project</h4>
            </div>
            <div class="modal-body">
                <form id="new-project-form">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input name="name" type="text" class="form-control" value="{{ old('name') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Contact Name</label>
                                <input name="contact[name]" type="text" class="form-control" value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <label>Contact Email</label>
                                <input name="contact[email]" type="text" class="form-control" value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <label>Contact Phone</label>
                                <input name="contact[phone]" type="text" class="form-control" value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Note</label>
                                <textarea name="note" class="form-control" value="{{ old('note') }}"
                                          style="resize: none" rows="8"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="addProject()">Add Project</button>
            </div>
        </div>
    </div>
</div>
@section('scripts')
    @parent
    <script>
        function addProject() {
            $.ajax('{{ route('project-store') }}', {
                type: "POST",
                data: $("#new-project-form").serialize(),
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