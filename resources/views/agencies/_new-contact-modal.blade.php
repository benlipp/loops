<div class="modal fade" id="new-contact-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">New Contact</h4>
            </div>
            <div class="modal-body">
                <form id="new-contact-form">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Contact Name</label>
                                <input name="contact[name]" type="text" class="form-control" value="{{ old('name') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Contact Email</label>
                                <input name="contact[email]" type="text" class="form-control" value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Contact Phone</label>
                                <input name="contact[phone]" type="text" class="form-control" value="{{ old('name') }}">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="addContact()">Add Contact</button>
            </div>
        </div>
    </div>
</div>
@section('scripts')
    @parent
    <script>
        function addContact() {
            $.ajax('{{ route('agency-add-contact', ['agency' => $agency ]) }}', {
                type: "POST",
                data: $("#new-contact-form").serialize(),
                success: function (response) {
                    swal("Contact Added!", "ring ring", "success");
                    window.location.reload();
                },
                error: function (error) {
                    swal("Error", "see console", "error");
                    console.log(error.responseJSON);
                }
            });
        }
    </script>
@endsection