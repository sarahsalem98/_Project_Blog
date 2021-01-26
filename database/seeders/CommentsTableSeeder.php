<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogPost;
use App\Models\comments;
use App\Models\User;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
         $posts=BlogPost::all();
         $users=User::all();
         if($posts->count()===0|| $users->count(0)){
               $this->command->info('there ara no blog posts or users  added,so no comments will be added ');
         }


         $CommentCount=max((int)$this->command->ask('how many Comments would you like?',50),1);
    

        comments::factory()->count($CommentCount)->make()->each(function($comment) use($posts,$users){
            $comment->commentable_id=$posts->random()->id;
            $comment->commentable_type='App/Models/BlogPost';
            $comment->user_id=$users->random()->id;
            $comment->save();
        });
        comments::factory()->count($CommentCount)->make()->each(function($comment) use($users){
            $comment->commentable_id=$users->random()->id;
            $comment->commentable_type='App/Models/User';
            $comment->user_id=$users->random()->id;
            $comment->save();
        });
    }
}
