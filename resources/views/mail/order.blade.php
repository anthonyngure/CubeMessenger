@component('mail::message')
####{{Carbon\Carbon::now()->toDayDateTimeString()}}
#### Dear {{$client->name}},

### The following items were ordered through your CubeMessenger Account for {{\App\Utils::toCurrencyText($totalCost)}}
@component('mail::table')
    |Item Name|Item Price|Quantity|Total|
    |:----------|:----------|:------------:|:----------|
    @foreach($order->items as $item)
        |{{$item->product->name}}|{{\App\Utils::toCurrencyText($item->price_at_purchase)}}|{{$item->quantity}}|{{\App\Utils::toCurrencyText($item->quantity * $item->price_at_purchase)}}|
    @endforeach
@endcomponent
### Your new account balance is as shown below
@component('mail::table')
    |Actual|Limit|Spent|Blocked|
    |:----------|:----------|:------------|:----------|
    |{{\App\Utils::toCurrencyText($client->getBalance())}}|{{\App\Utils::toCurrencyText($client->limit)}}|{{\App\Utils::toCurrencyText($client->getSpent())}}|{{\App\Utils::toCurrencyText($client->getBlocked())}}|
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
