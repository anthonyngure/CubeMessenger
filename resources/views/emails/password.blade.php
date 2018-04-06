@component('mail::message')
    # Order Shipped

    Your order has been shipped!
    @component('mail::button', ['url' => config('app.url')])
        View Order
    @endcomponent

    @component('mail::panel')
        This is the panel content.
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent