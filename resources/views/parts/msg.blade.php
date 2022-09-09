@if(session('message'))
<div class="message"> {{session('message')}} </div>
@endif
@if ($errors->any())
<div>
    <ul class="list-group">
        @foreach ($errors->all() as $error)
        <li class="message m-0">{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div>
    <ul class="list-group js--messages d-none">  
    </ul>
</div>
