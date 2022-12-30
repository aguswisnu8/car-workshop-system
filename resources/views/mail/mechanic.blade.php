@component('mail::message')

<h2>
    {{$title}}
</h2>

<h5>
    Car : {{$name}}
</h5>
<p>
    License : {{$license}}
</p>
<p>
    Service : {{$service}}
</p>
<p>
    Description : {{$desc}}
</p>


@component('mail::button', ['url'=>'https://www.youtube.com/'])
    Detail
@endcomponent
    
@endcomponent
