@component('mail::message')

<h1>{{$title}}</h1>

Hello {{$owner}}

We would like to inform you that your car {{$name}} - {{$license}} has been repaired. The car can be taken to the workshop

@component('mail::button', ['url'=>'https://www.youtube.com/'])
    Detail
@endcomponent
    
@endcomponent
