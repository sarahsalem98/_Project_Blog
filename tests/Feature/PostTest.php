<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\BlogPost;

class PostTest extends TestCase
{
   use RefreshDatabase;

    public function testNoBlogPostWhenNothingInDataBase()
    {
        $response = $this->get('/posts');
        $response->assertSeeText('No posts were found');

    }



    public function testSee1BlogPostWhenThereIs1(){

        //arrange
       $post=$this->CreateDummyPost();

        //act
        $response = $this->get('/posts');

        //assert
        $response->assertSeeText('validd');

       $this->assertDatabaseHas('blog_posts',[
           'title'=>'validd'
           
       ]);

 
    }




    public function testStoreValide(){
        $params=[
            'title'=>'validd',
            'content'=>'validd'
        ];
        $this->post('/posts',$params)
        ->assertStatus(302)
        ->assertSessionHas('status');
       $this->assertEquals(session('status'),'the blog was created!!!');
    }
    public function testStoreFail(){

        $params=[
            'title'=>'x',
            'content'=>'x'
        ];
        $this->post('/posts',$params)
        ->assertStatus(302)
        ->assertSessionHas('errors');

        $messages=session('errors')->getMessages();
        $this->assertEquals($messages['title'][0],'The title must be at least 5 characters.');
        $this->assertEquals($messages['content'][0],'The content must be at least 4 characters.');
        //d//d($messages->getMessages());
    }
    public function testUpdateValid(){
           $post=$this->CreateDummyPost();
        $this->assertDatabaseHas('blog_posts',
        ['title'=>'validd',
          'content'=>'validd'
        
        ]); 

        $params=[
            'title'=>'nnvalidd',
            'content'=>'nnvalidd'
        ];
        $this->put("/posts/{$post->id}",$params)
        ->assertStatus(302)
        ->assertSessionHas('status');
        $this->assertEquals(session('status'),'the post was updated !!');
        $this->assertDatabaseMissing('blog_posts',
        ['title'=>'validd',
          'content'=>'validd'
        
        ]); 
    }

public function testDelete(){
    $post=$this->CreateDummyPost();
    $this->assertDatabaseHas('blog_posts',
    ['title'=>'validd',
      'content'=>'validd'
    
    ]); 
    $this->delete("/posts/{$post->id}")
    ->assertStatus(302)
    ->assertSessionHas('status');
    $this->assertEquals(session('status'),'the post was deleted!!');
    
 
}



private function CreateDummyPost():BlogPost{
    $post= new BlogPost();
    $post->title='validd';
    $post->content='validd';
    $post->save();

    return $post;
}
}
