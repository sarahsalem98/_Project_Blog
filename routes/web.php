<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostTagController;
use App\Http\Controllers\UserCommentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
$posts = [
    1 => [
        'title' => 'Intro to Laravel',
        'content' => 'This is a short intro to Laravel',
        'is_new'=>true,
        'has_comments'=>true
    ],
    2 => [
        'title' => 'Intro to PHP',
        'content' => 'This is a short intro to PHP',
        'is_new'=>false
    ]
];
// Route::get('/', function () {
//     return view('home.index');
// })->name('home.index');

// Route::get ('/contact',function(){
//     return view('home.contact');
// })->name('home.contact');

Route::get('/',[HomeController::class,'home'])->name('home')
// ->middleware('auth')
;
Route::get('/contact',[HomeController::class,'contact'])->name('contact');
Route::resource('posts',PostController::class);
Route::get('posts/tag/{id}',[PostTagController::class,'index'])->name('posts.tags.index');

Route::get('/secret',[HomeController::class,'secret'])
->name('secret')
->middleware('can:home.secret');

Route::resource('posts.comments',PostCommentController::class)->only(['index','store']);
Route::resource('users.comments',UserCommentController::class)->only(['store']);
Route::resource('users',UserController::class)->only(['show','edit','update']);

//Auth::routes();

// Route::get('/posts',function()use($posts){
   // dd (request()->all());

//    dd(request()->input('page',1));
// return view ('posts.index',['posts'=>$posts]);
// });



// Route::get('/post{id}',function($id) use($posts){


//     abort_if(!isset($posts[$id]),404);
//     return view ('posts.show',['post'=>$posts[$id]]);
// })
// ->where([
//     'id'=>'[1-9]+'
// ])
// ->name('post.show');

Route::get('/recent-posts/{days_ago?}',function($days_ago=30){
return 'this post from '.$days_ago.'days ago';
})->name('posts.recent.index')->middleware('auth');


Route::prefix('/fun')->name('fun.')->group(function()use($posts){
    Route::get('/responses',function() use($posts){
        return response($posts,201)
        ->header('Content-Type','application/json')
        ->cookie('MY_COOKIE','sara salem',3600);
        });
        
        Route::get('/redirect',function(){
            return redirect('/contact');
        });
        Route::get('/dowmload',function(){
            return response()->download(public_path('/hello.jpg'),'hiii.jpg');
        });
        
});






Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
