<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComment;
use App\Mail\CommentedPosted;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PostCommentController extends Controller
{
public function __construct()
{
    $this->middleware('auth')->only(['store']);
    
}

public function store( BlogPost $post, StoreComment $request){


  $comment=$post->comments()->create([
        'content'=>$request->input('content'),
        'user_id'=>$request->user()->id
    ]);
// Mail::to($post->user)->send(
//     new CommentedPosted($comment)
// );
// dump($comment->commentable->user->name);
// die;
    
    $request->session()->flash('status', 'comment was created!');
    return redirect()->back();
}


public function index(BlogPost $post){
    
     return $post->comments()->with('user')->get();
}

}
