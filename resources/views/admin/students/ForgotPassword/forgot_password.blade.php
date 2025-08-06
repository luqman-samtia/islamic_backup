<form id="forgotPasswordForm">
    <input type="email" name="email" id="forgotEmail" placeholder="Enter your registered email">
    <button type="submit">Send Reset Link</button>
</form>

<script>
    $('#forgotPasswordForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('student.forgot.password') }}",
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                email: $('#forgotEmail').val()
            },
            success: function(response) {
                alert(response.message);
            },
            error: function(xhr) {
                alert(xhr.responseJSON.error || 'Something went wrong');
            }
        });
    });
</script>
