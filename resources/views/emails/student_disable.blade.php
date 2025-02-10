@component('mail::message')
# ❌ Account Disabled

Dear {{ $user->name }},

We regret to inform you that your account has been ❌ disabled by the admin. You no longer have access to our services.  

If you believe this was a mistake or need further assistance, please contact our support team.

Thanks for your understanding.
  
{{ config('app.name') }}
@endcomponent
