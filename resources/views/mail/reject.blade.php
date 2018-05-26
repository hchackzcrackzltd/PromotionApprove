@component('mail::message')
Notification Request For Reject

@component('mail::panel')
Your request has reject by <b>{{auth()->user()->name}}</b>, Promotion For <b>{{$pro->account_group}}</b></b>
@endcomponent

@component('mail::button', ['url' => route('approve.index')])
  Click
  @endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
