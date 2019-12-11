<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    //
    protected $guarded=[];
    
    public function path()
    {
        return '/threads/'.$this->channel->slug.'/'.$this->id;
    }
    
    public function replies()
    {
        return $this->hasMany(Reply::class,'thread_id');
    }
    
    public function creator()
    {
        return $this->belongsTo(User::class,'user_id');
        
    }
    
    public function channel()
    {
        return $this->belongsTo(Channel::class,'channel_id');
    }
    
    public function addReply(array $reply)
    {
        $this->replies()->create($reply);
    }
}
