<x-mail::message>


Job Portal

<x-mail::button :url="route('reset_password_view', ['token' => $body['token']])">
Reset Password
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
