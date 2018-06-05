@component('mail::message')
####{{Carbon\Carbon::now()->toDayDateTimeString()}}
#### Dear {{$client->name}},

### {{\App\Utils::toCurrencyText($bill->amount)}} have been *{{$bill->status}}* for {{$bill->description}}

### Your new account balance is as shown below
@component('mail::table')
    |Actual|Limit|Spent|Blocked|
    |:----------|:----------|:------------|:----------|
    |{{\App\Utils::toCurrencyText($client->getBalance())}}|{{\App\Utils::toCurrencyText($client->limit)}}|{{\App\Utils::toCurrencyText($client->getSpent())}}|{{\App\Utils::toCurrencyText($client->getBlocked())}}|
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
