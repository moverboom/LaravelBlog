<?php

use App\Post;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostTest extends TestCase
{
    /**
     * Assert the overwritten create method for the Post class
     *
     * @return void
     */
    public function testPostCanCreate()
    {
        $this->withoutMiddleware();

        $post = Post::create([
            'title' => 'unittest',
            'content' => 'test content. Which made me realize, maybe validation should also be part of the model instead of the controller?',
            'author_id' => 'NjRlZjc3NzR'
        ]);
        $this->assertNotNull($post);
    }
}
