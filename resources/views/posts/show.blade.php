@extends('layout')

@section('content')
<div class="row">
    <div class="col-8">
    @if($post->image)
        <div style="background-image: url('{{ $post->image->url() }}'); min-height: 105px; color: white; text-align: center; background-attachment: fixed;">
            <h1 style="padding-top: 100px; text-shadow: 1px 2px #000">
        @else
            <h1>
        @endif
            {{ $post->title }}
           
        @component('components.badge',['show'=>now()->diffInMinutes($post->created_at) < 60 ] )
         Brand New!
         @endcomponent
        @if($post->image)    
            </h1>
        </div>
        @else
            </h1>
        @endif
    <p>{{ $post->content }}</p>


            @component('components.updated',['date'=>$post->created_at,'name'=>$post->user->name] )
            
            @endcomponent
 

            @component('components.updated',['date'=>$post->updated_at])
            updated at
            @endcomponent
            @component('components.tags',['tags'=>$post->tags])

             @endcomponent

        <p> currently read by {{$counter}} peaple</p>

    <h4>Comments</h4>

         @component('components.comment-form',['route'=>route('posts.comments.store',['post'=>$post->id])])

        @endcomponent
        @component('components.comment-list',['comments'=>$post->comments])

         @endcomponent

     </div>   
     <div class="col-4">
         @include('posts._activity')
     </div> 
</div>
@endsection('content')



