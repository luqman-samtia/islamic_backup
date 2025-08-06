<form id="resetPasswordForm">
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ $email }}">
    <input type="password" name="password" placeholder="New Password">
    <input type="password" name="password_confirmation" placeholder="Confirm Password">
    <button type="submit">Reset Password</button>
</form>

<script>
    $('#resetPasswordForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('student.reset.password') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                alert(response.message);
                window.location.href = "/";
            },
            error: function(xhr) {
                alert(xhr.responseJSON.error || 'Something went wrong');
            }
        });
    });
</script>
