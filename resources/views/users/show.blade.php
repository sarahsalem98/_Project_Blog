@extends('layout')
@section('content')


<div class="row">
    <div class="col-4">
        <img class="img-thumbnail avatar" src="{{$user->image? $user->image->url() :''}}" alt="">


    </div>

    <div class="col-8">
        <h3>{{$user->name}}</h3>
        @component('components.comment-form',['route'=>route('users.comments.store',['user'=>$user ->id])])

        @endcomponent


        @component('components.comment-list',['comments'=>$user->commentsOn])

        @endcomponent
    </div>


</div>




@endsection