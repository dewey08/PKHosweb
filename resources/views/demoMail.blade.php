@component('mail::message')
# {{ $mailData['title'] }}
  
The body of your message.
  
@component('mail::button', ['url' => $mailData['url']])
Visit Our Website
@endcomponent
  
Thanks,

{{ config('app.name') }}
@endcomponent