@component('mail::message')
####{{Carbon\Carbon::now()->toDayDateTimeString()}}
#### Dear {{$supplier->name}},

### Your are requested to supply the following items to CubeMessenger
@component('mail::table')
    |Item| Quantity   |
    |:-------|:----------:|
    @foreach($LPOItems as $item)
        |{{$item['item']}}|{{$item['quantity']}}|
    @endforeach
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
