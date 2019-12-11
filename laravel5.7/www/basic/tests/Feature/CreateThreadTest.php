<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadTest extends TestCase
{
    /**
     * 已登录的用户能发表话题
     *
     * @test
     * @return void
     */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        // 一个登录的用户，可以发布话题
        $this->signIn();
        $thread=$this->make(Thread::class);
        $response=$this->post('/threads',$thread->toArray());
        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
    /**
     * 游客不能发表话题
     * @test
     * @return void
     */
    public function guests_may_not_create_threads()
    {
        // 一个登录的用户，可以发布话题
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $thread=$this->make(Thread::class);
        $this->post('/threads',$thread->toArray());
        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
    /**
     * 游客不能发表话题
     * @test
     * @return void
     */
    public function guests_may_not_see_the_create_threads_page()
    {
        // 一个登录的用户，可以发布话题
        $thread=$this->make(Thread::class);
        $this->withExceptionHandling()->get('/threads/create')->assertRedirect('/login');
    }
    
    /**
     * @test
     */
    public function a_thread_require_a_title()
    {
        $this->publishThread(['title'=>null])
            ->assertSessionHasErrors('title');
    }
    /**
     * @test
     */
    public function a_thread_require_a_body()
    {
        $this->publishThread(['body'=>null])
            ->assertSessionHasErrors('body');
    }
    
    /**
     * @test
     */
    public function a_thread_requires_a_valid_channel()
    {
        $this->publishThread(['channel_id'=>null])
            ->assertSessionHasErrors('channel_id');
        $this->publishThread(['channel_id'=>'kkk'])
            ->assertSessionHasErrors('channel_id');
    }
    
    
    public function publishThread($override)
    {
        $this->signIn();
        $thread=$this->make(Thread::class,$override);
        return $this->withExceptionHandling()
            ->post('/threads',$thread->toArray());
    }
}
