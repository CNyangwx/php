<?php

namespace Tests\Feature;

use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->thread = factory('App\Thread')->create();
    }

    // use DatabaseMigrations;

    /** @test */
    public function a_user_can_browse_threads()
    {
        $response = $this->get('/threads');

        $response->assertSee($this->thread->title);
    }

    /**
     * @test
     */
    public function a_user_can_read_single_thread()
    {

        $response = $this->get('/threads/' . $this->thread->id);

        $response->assertSee($this->thread->title);

    }

    /** @test */
    public function a_user_can_read_replies_that_are_associated_with_a_thread()
    {

        // $thread = factory('App\Thread')->create();
        // 如果存在 Thread
        // 并且该 Thread 拥有回复
        $reply = factory('App\Reply')->create([
            'thread_id' => $this->thread->id,
        ]);

        // 那么当我们看该 Thread 时
        // 我们也要看到回复

        $this->get('/threads/' . $this->thread->id)->assertSee($reply->body);
    }

}
