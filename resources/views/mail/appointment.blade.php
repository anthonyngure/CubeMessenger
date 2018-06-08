@component('mail::message')
####{{Carbon\Carbon::now()->toDayDateTimeString()}}
#### Dear {{$participant->name}},

You have been added to participate in the appointment/meeting below
@component('mail::table')
Time and Date|Subject| Venue   |
|:----------|:-------|:----------|
|{{$appointment->all_day ? 'Starting '.$appointment->starting_at.' - all day' : $appointment->starting_at.' to '.$appointment->ending_at}}|{{$appointment->title}}|{{$appointment->venue}}|
@endcomponent
@if(count($appointment->items) > 0)
### Items to discuss are
@component('mail::table')
|No.| Details   |
|:-------|:----------|
@foreach($appointment->items as $key => $item)
|{{($key+1)}}|{{$item->details}}|
@endforeach
@endcomponent
@endif
@if(count($appointment->internalParticipants) > 0)
### Other participants are
@component('mail::table')
|Name| Email   |
|:-------|:----------|
@foreach($appointment->internalParticipants as $internalParticipant)
@if($internalParticipant->email != $participant->email)
|{{$internalParticipant->name}}|{{$internalParticipant->email}}|
@endif
@endforeach
@foreach($appointment->externalParticipants as $externalParticipant)
@if($externalParticipant->email != $participant->email)
|{{$externalParticipant->name}}|{{$externalParticipant->email}}|
@endif
@endforeach
@endcomponent
@endif
Thanks,<br>
{{ config('app.name') }}
@endcomponent
