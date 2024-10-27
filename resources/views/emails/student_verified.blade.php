@component('mail::message')
# Account Verified

Dear {{ $user->name }},

Your account has been successfully verified by the admin. You can now log in and start using the system.

@component('mail::button', ['url' => route('site')])
Log in Now
@endcomponent

Thanks,  
{{ config('app.name') }}
@endcomponent
