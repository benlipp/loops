<div class="modal fade" id="close-loop-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Close Loop</h4>
            </div>
            <div class="modal-body">
                <form id="close-loop-form">
                    {{ csrf_field() }}
                    <input type="hidden" name="loop_id" value="{{ $theLoop->id }}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Closing Note</label>
                                <textarea name="note" class="form-control" value="{{ old('note') }}"
                                          style="resize: none" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="closeLoop()">Close Loop</button>
            </div>
        </div>
    </div>
</div>
@section('scripts')
    @parent
    <script>
        function closeLoop() {
            $.ajax('{{ route('loop-close', ['loop' => $theLoop->id ]) }}', {
                type: "POST",
                data: $("#close-loop-form").serialize(),
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
