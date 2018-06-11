@component('mail::message')
####{{$message}}
@component('mail::button', ['url' => config('app.url')])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
