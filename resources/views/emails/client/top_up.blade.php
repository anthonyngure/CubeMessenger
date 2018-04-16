@component('mail::message')
# Account Top Up

Your account has been topped up with KSH. 20,0000

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

@component('mail::table')
    |A      |A      |A      |
    |-------|:-------|:-------|
    |baoao  |baoao  |baoao  |
    |baoao  |baoao  |baoao  |
    |baoao  |baoao  |baoao  |
    |baoao  |baoao  |baoao  |
@endcomponent

Thanks you,<br>{{ config('app.name') }}
@endcomponent
