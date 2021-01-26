<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
 
    public function testHomePageIsWorkingCorrectly()
    {
        $response = $this->get('/');

        $response->assertSeeText('welcome to laravel');
        $response->assertSeeText('this is the content of the main page');
    }
     public function testContactPageIsWorkingCorrectly(){

     $response = $this->get('/contact');

      $response->assertSeeText('contact page');

    }
}
