<div class="modal fade" id="rolesModal" xmlns="">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form method="post" action="{{ route('users.role', $user->id) }}">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Assign Role</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            @foreach($roles as $role)
                            <div class="form-group">
                                <label>
                                    <input {{ $user->hasRole($role) ? "checked" : ""  }} type="radio" class="minimal" value="{{ $role->name }}" name="role">
                                    {{ $role->name }}
                                </label>
                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Assign</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<link rel="stylesheet" href="{{asset('vendor/adminlte/plugins/iCheck/square/blue.css')}}">
<script src="{{ asset('vendor/adminlte/plugins/iCheck/icheck.js') }}"></script>
<script>
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
    });
</script>