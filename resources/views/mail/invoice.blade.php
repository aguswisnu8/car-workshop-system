@component('mail::message')

<h1>{{$title}}</h1>

Hello {{$owner}}

Here your Invoice

Vehicle Detail : {{$name}} - {{$license}}

Date in: {{$in}}

Total Amount : {{$total}}

@component('mail::button', ['url'=>'https://www.youtube.com/'])
    Detail
@endcomponent
    
@endcomponent
