<div class="modal fade" id="rolesModal" xmlns="">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form method="post" action="{{ route('roles.permissions', $role->id) }}">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Assign Permissions</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            @foreach($permissions as $permission)
                                <div class="form-group">
                                    <label>
                                        <input {{ $permission->hasRole($role) ? "checked" : "" }} type="checkbox" class="minimal" value="{{ $permission->name }}" name="permissions[]">
                                        {{ $permission->name }}
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