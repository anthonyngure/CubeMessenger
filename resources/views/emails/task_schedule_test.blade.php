@component('mail::message')
####This is a test for task scheduling, sent every 15 minutes!
@component('mail::button', ['url' => config('app.url')])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
