@component('mail::message')
  Notification Request For Approve

  @component('mail::panel')
  You have new request for approve form <b>{{Adldap::search()->where('sAMAccountName',$pro->createby)->get()[0]->cn[0]}}</b>, Promotion For <b>{{$pro->account_group}}</b>
  @endcomponent

  @component('mail::button', ['url' => route('approve.index')])
  Click
  @endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
