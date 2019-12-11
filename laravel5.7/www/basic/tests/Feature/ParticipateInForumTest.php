<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateInForumTest extends TestCase
{
    /**
     * 一个认证的用户能增加论坛的话题.
     *
     * @test
     * @return void
     */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        // Given we have a authenticated user
        // And an existing thread
        // When the user adds a reply to the thread
        // Then their reply should be visible on the page
        $this->signIn();
        $thread=$this->create(Thread::class);
        $reply=$this->make(Reply::class);
        $this->post($thread->path().'/replies',$reply->toArray());
        $this->get($thread->path())->assertSee($reply->body);
    }
    
    /**
     * @test
     */
    public function unauthenticated_user_may_no_add_replies()
    {
        $thread=$this->create(Thread::class);
        $reply=$this->make(Reply::class);
        $this->withExceptionHandling()
            ->post($thread->path().'/replies',$reply->toArray())
        ->assertRedirect('/login');
    }
    
    /**
     * @test
     */
    public function a_reply_require_body()
    {
        $this->signIn();
        $thread=$this->create(Thread::class);
        $reply=$this->make(Reply::class,['body'=>null]);
        $this->withExceptionHandling()
            ->post($thread->path().'/replies',$reply->toArray())
            ->assertSessionHasErrors('body');
            
        
    }
}
