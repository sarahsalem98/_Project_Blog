<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class BlogPostTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tagCount=Tag::all()->count();
        if (0===$tagCount){
            $this->command->info('no tags was found');
            return;

        }
        $howManyMin=(int)$this->command->ask('minimum tags on blog posts?',0);
        $howManyMax=min((int)$this->command->ask('maximum tags on blog posts?',$tagCount),$tagCount);
        BlogPost::all()->each(function(BlogPost $post) use($howManyMax,$howManyMin){
          $take= random_int($howManyMin,$howManyMax);
          $tags=Tag::inRandomOrder()->take($take)->get()->pluck('id');
          $post->tags()->sync($tags);    
        });
    }
}
