<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class PostTagController extends Controller
{
   public function index($tagId){
$tagId=Tag::findorfail($tagId);
return view('Posts.index',['posts'=>$tagId->blogPosts()
->LatestWithRelations()->get(),
// ,'mostCommented'=>[]
// ,'mostActive'=>[]
// ,'mostActiveLastMonth'=>[]

]);
   }
}
