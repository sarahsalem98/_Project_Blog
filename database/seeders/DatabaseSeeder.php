<?php

namespace Database\Seeders;

use Carbon\Factory;
use Illuminate\Database\Seeder;
use  Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\BlogPost;
use App\Models\comments;
use App\Models\Tag;
use Illuminate\Support\Facades\Cache;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if($this->command->confirm('Do you want to refresh the database?')){
            $this->command->call('migrate:refresh');
            $this->command->info('DataBase was refreshed ');
        }
        Cache::tags(['blog-post'])->flush();     
           $this->call([UsersTableSeeder::class,BlogPostsTableSeeder::class
           ,CommentsTableSeeder::class,TagsTableSeeder::class,
            BlogPostTagTableSeeder::class
           ]);


        // \App\Models\User::factory(10)->create();
    //    $sara= DB::table('users')->insert( [
    //         'name' => 'sara salem',
    //         'email' => 'sasasalem44@gmail.com',
    //         'email_verified_at' => now(),
    //         'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
    //         'remember_token' => Str::random(10),
    //     ]);

    //    $else= User::factory()->count(20)->create(); 
    //    $users=$else->concat([$sara]);
       

    //    $posts=BlogPost::factory()->count(20)->make()->each(function ($post) use($users){
    //        $post->user_id=$users->random()->id;
    //         $post->save();
    //    }); 


    //    comments::factory()->count(20)->make()->each(function($comment) use($posts){
    //        $comment->blog_post_id=$posts->random()->id;
    //        $comment->save();
    //    });
    }
}
