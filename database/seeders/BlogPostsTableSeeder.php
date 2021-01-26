<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Support\Facades\App;

class BlogPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $BlogCount=max((int)$this->command->ask('how many blog posts would you like?',50),1);

        $users=User::all();

      BlogPost::factory()->count($BlogCount)->make()->each(function ($post) use($users){
            $post->user_id=$users->random()->id;
             $post->save();
        }); 
    }
}
