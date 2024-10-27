@component('mail::message')
# New Student Registration

A new student has registered and is awaiting verification.

**Student Name**: {{ $user->name }}  
**Email**: {{ $user->email }}

Please review and verify the account.

@component('mail::button', ['url' => route('admin.verifyStudent', $user->id)])
Verify Student
@endcomponent

Thanks,  
{{ config('app.name') }}
@endcomponent
