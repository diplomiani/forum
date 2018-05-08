<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    /**
     * show all replies 
     *
     * @param  $channelId
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    
    public function index($channelId , Thread $thread)
    {
        return $thread->replies()->paginate(1);      
    }

    /**
     * Store a newly created reply by thread in storage.
     *
     * @param  $channelId
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function store($channelId, Thread $thread)
    {
        $this->validate(request(), ['body' => 'required']);
        $reply = $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id(),
            'thread_id' => $thread->id,
        ]);

        if(request()->expectsJson()){
            return $reply->load('owner');
        }
        return back()->with('flash', 'your replied is left');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function show(Reply $reply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function edit(Reply $reply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reply $reply)
    {
        $this->authorize('update', $reply);
        $reply->update(request(['body']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->wantsJson()) {
            return response(['status' => 'deleted']);
        }

        return back();
    }
}
