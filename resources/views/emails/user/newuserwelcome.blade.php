@component('mail::message')
# Welcome to Verblick Website

We have added you as a new user.<br>
Please change your password after logged in.<br>

**Email:**  {{ $loginEmail }}<br>
**Password:**  {{ $loginPassword }}<br>

@component('mail::button', ['url' => 'localhost:8000/users/login'])
Go to Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
