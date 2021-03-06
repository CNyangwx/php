<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')
            ->except(['index','show']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        $threads= Thread::latest()->get();
        return view('threads.index',compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        return view('threads.create');
    }
    
    /**
     * store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'required',
            'body'=>'required',
            'channel_id'=>'required|exists:channels,id',
        ]);
        $thread=Thread::create([
            'title'=>$request->post('title'),
            'body'=>$request->post('body'),
            'user_id'=>auth()->id(),
            'channel_id'=>$request->post('channel_id'),
            ]
        );
        return redirect($thread->path());
    }
    
    /**
     * Display the specified resource.
     *
     * @param string $channelId
     * @param Thread $thread
     * @return Response
     */
    public function show(string $channelId,Thread $thread)
    {
        //
        return view('threads.show',compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Thread $thread
     * @return Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Thread $thread
     * @return Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Thread $thread
     * @return Response
     */
    public function destroy(Thread $thread)
    {
        //
    }
}
