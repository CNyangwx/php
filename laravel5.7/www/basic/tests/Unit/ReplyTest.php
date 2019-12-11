<?php

namespace Tests\Unit;

use App\Reply;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReplyTest extends TestCase
{
    /**
     * @test
     */
    public function a_reply_has_an_owner()
    {
        $reply=$this->create(Reply::class);
        $this->assertInstanceOf(User::class,$reply->owner);
        
   }
}
