<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Http\Requests\StorePost;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

// use Illuminate\Support\Facades\DB;

// [
//     'show' => 'view',
//     'create' => 'create',
//     'store' => 'create',
//     'edit' => 'update',
//     'update' => 'update',
//     'destroy' => 'delete',
// ]
class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')
            ->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // DB::connection()->enableQueryLog();

        // $posts = BlogPost::with('comments')->get();

        // foreach ($posts as $post) {
        //     foreach ($post->comments as $comment) {
        //         echo $comment->content;
        //     }
        // }

        // dd(DB::getQueryLog());

        // comments_count
        // $mostCommented=Cache::tags(['blog-post'])->remember( 'blog-post-commented',now()->addSeconds(10),function(){
        //  return BlogPost::mostCommented()->take(5)->get();
        // });

        // $mostActive=Cache::remember( 'users-most-active',now()->addSeconds(10),function(){
        //    return User::withMostBlogPosts()->take(5)->get();
        //    });

        // $mostActiveLastMonth=Cache::remember( 'users-most-active-last-month',now()->addSeconds(10),function(){
        //   return  User::withMostBlogPostsLastMonth()->take(5)->get();
        //    });

        return view(
            'Posts.index',
            [
                'posts' => BlogPost::LatestWithRelations()->get()
                // 'mostCommented' =>$mostCommented,
                // 'mostActive' =>   $mostActive,
                // 'mostActiveLastMonth' => $mostActiveLastMonth,
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return view('posts.show', [
        //     'post' => BlogPost::with(['comments' => function ($query) {
        //         return $query->latest();
        //     }])->findOrFail($id),
        // ]);
              $blogPost=Cache::tags(['blog-post'])->remember("blog-post-{$id}",60,function() use($id){
                  return BlogPost::with('comments','tags','user','comments.user')->findOrFail($id);
             });
             $sessionId=session()->getId();
             $counterKey="blog-post-{$id}-counter";
             $usersKey="blog-post-{$id}-users ";

             $users=Cache::tags(['blog-post'])->get($usersKey,[]);
             $usersUpdate=[];
             $difference=0;
             $now=now();


             foreach($users as $session=>$lastVisited){
                if($now->diffInMinutes($lastVisited)>=1){
                     $difference--;
                }else{
                    $usersUpdate[$session]=$lastVisited;
                }
             }
              if(!array_key_exists($sessionId,$users)
                || $now->diffInMinutes($users[$sessionId])>=1
              ){
                  $difference++;
              }
              $usersUpdate[$sessionId]=$now;
              Cache::tags(['blog-post'])->forever( $usersKey,$usersUpdate);

              if(!Cache::tags(['blog-post'])->has($counterKey)){
                  Cache::tags(['blog-post'])->forever($counterKey,1);
              }else{
                Cache::tags(['blog-post'])->increment($counterKey,$difference);

              }
                $counter=Cache::tags(['blog-post'])->get($counterKey);                        
            

        return view('Posts.show', [
            'post' => $blogPost,
            'counter'=>$counter,
        ]);
    }

    public function create()
    {
        // $this->authorize('posts.create');
        return view('Posts.create');
    }

    public function store(StorePost $request)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = $request->user()->id;

        $blogPost = BlogPost::create($validatedData);
       if($request->hasFile('thumbnail')){
       $path=$request->file('thumbnail')->store('thumbnails');  
       $blogPost->image()->save(
           Image::make(['path'=>$path])
       ) ;
       }
       


        $request->session()->flash('status', 'Blog post was created!');

        return redirect()->route('posts.show', ['post' => $blogPost->id]);
    }

    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);
        $this->authorize($post);

        return view('Posts.edit', ['post' => $post]);
    }

    public function update(StorePost $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        // if (Gate::denies('update-post', $post)) {
        //     abort(403, "You can't edit this blog post!");
        // }
        $this->authorize($post);

        $validatedData = $request->validated();

        $post->fill($validatedData);

        if($request->hasFile('thumbnail')){
            $path=$request->file('thumbnail')->store('thumbnails'); 
            if($post->image){
                Storage::delete($post->image->path);
                $post->image->path=$path;
                $post->image->save();
            } else{
                $post->image()->save(
                    Image::make(['path'=>$path])
                ) ;
            }
          
            }
        $post->save();
        $request->session()->flash('status', 'Blog post was updated!');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    public function destroy(Request $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        // if (Gate::denies('delete-post', $post)) {
        //     abort(403, "You can't delete this blog post!");
        // }
        $this->authorize($post);

        $post->delete();

        // BlogPost::destroy($id);

        $request->session()->flash('status', 'Blog post was deleted!');

        return redirect()->route('posts.index');
    }
}