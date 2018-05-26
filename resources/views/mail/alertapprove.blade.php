@component('mail::message')
Notification Approve

@component('mail::panel')
Your Request Approve By <b>{{Adldap::search()->where('sAMAccountName',Auth::user()->username)->get()[0]->cn[0]}}</b>, Promotion For <b>{{$pro->account_group}}</b>
@endcomponent

@component('mail::button', ['url' => route('promotion.index')])
Click
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
