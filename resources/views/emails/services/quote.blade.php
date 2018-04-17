@component('mail::message')
####{{Carbon\Carbon::now()->toDayDateTimeString()}}
#### Dear {{$serviceRequest->user->client->name}},

_{{$serviceRequest->user->name}}_ requested that we check on the following {{$serviceRequest->type}} issues
on {{Carbon\Carbon::parse($serviceRequest->created_at)->toDayDateTimeString()}}
@php
    $issues = explode("#", $serviceRequest->details);
@endphp

@foreach($issues as $issue)
* {{$issue}}
@endforeach

#### Charges
You will be charged a **diagnosis cost** of KSH **{{$serviceRequest->quote->diagnosis_cost}}** and a **labour cost**
of KSH **{{$serviceRequest->quote->labour_cost}}**

#### Items to buy

The following items will be purchased
@php
    $items = $serviceRequest->quote->items
@endphp
@component('mail::table')
|Item name| Price(KSH) |
|:-------:|:----------:|
@foreach($items as $item)
|{{$item->name}}|{{$item->price}}|
@endforeach
@endcomponent

@component('mail::button', ['url' => config('app.url').'/acceptServiceRequestQuote/'.$serviceRequest->quote->id ])
Accept This Quote
@endcomponent

@component('mail::button', ['url' => config('app.url').'/rejectServiceRequestQuote/'.$serviceRequest->quote->id, 'color'=>'red'])
Reject This Quote
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
