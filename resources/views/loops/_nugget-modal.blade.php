<div class="modal fade" id="nugget-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Add Nugget</h4>
            </div>
            <div class="modal-body">
                <form id="nugget-form">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Name</label>
                                <input name="name" type="text" class="form-control" value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Data</label>
                                <input name="data" type="text" class="form-control" value="{{ old('date') }}">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="addNugget()">Add Nugget</button>
            </div>
        </div>
    </div>
</div>
@section('scripts')
    @parent
    <script>
        function addNugget() {
            $.ajax('{{ route('loop-add-nugget', ['loop' => $theLoop]) }}', {
                type: "POST",
                data: $("#nugget-form").serialize(),
                success: function () {
                    console.log('success');
                    window.location.reload(true);
                },
                error: function (error) {
                    alert("Error, see console");
                    console.log(error.responseJSON);
                }
            });
        }
    </script>
@endsection