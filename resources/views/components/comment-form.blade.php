
<div class="mb-2 mt-2">
@auth


<form method="POST" action="{{$route}}">
    @csrf

    <div class="form-group">
       
        <textarea type="text" name="content" class="form-control"></textarea>
    </div>

    <button type="submit" class="btn btn-primary btn-block">Add comment!</button>
</form>
@component('components.errors')
 @endcomponent
@else
<a href="{{route('login')}}">sign in</a>  to post a comment

@endauth
</div>
<hr/>