@component('mail::message')
# Welcome to Verblick Website

We have added you as a new user.<br>
Please change your password after logged in.<br>

**Email:**  {{ $loginEmail }}<br>
**Password:**  {{ $loginPassword }}<br>

@component('mail::button', ['url' => 'localhost:8000/test'])
View my Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
