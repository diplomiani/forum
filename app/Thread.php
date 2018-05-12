<?php

namespace App;

use App\Notifications\ThreadWasUpdate;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{

    use RecordsActivity;

    /**
     * Don't auto-apply mass assignment protection
     * @var array
     */
    protected $guarded = [];

    protected $with = ['creator', 'channel'];

    protected $appends = ['isSubscribedTo'];

    /**
     * Get a string path for the thread
     * @return string
     */
    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    /**
     * boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function ($builder) {
            $builder->withCount('replies');
        });

        static::deleting(function ($thread) {
            $thread->replies->each->delete();
        });
    }

    /**
     * A thread May have Many Replies,
     *
     * @return \Illuminate\Database\Eluqment\Relations\HasMany
     **/
    public function replies()
    {
        return $this->hasMany(Reply::class)
            ->withCount('favorites')
            ->with('owner');
    }

    /**
     * A thread Belongs to a creator,
     *
     * @return \Illuminate\Database\Eluqment\Relations\BelongsTo
     **/
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * A thread Belongs to a Channel,
     *
     * @return \Illuminate\Database\Eluqment\Relations\BelongsTo
     **/
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * Add a reply to the thread
     *
     * @param $reply
     **/
    public function addReply($reply)
    {
        $reply = $this->replies()->forceCreate($reply);

        foreach($this->subscriptions as $subscription){
            if($subscription->user_id != $reply->user_id){
                $subscription->user->notify(new ThreadWasUpdate($this, $reply));
            }
        }

        return $reply;
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }



    
    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ? : auth()->id()
        ]);

        return $this;
    }

    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
            ->where('user_id', $userId ?: auth()->id())
            ->delete();
    }

    /**
    * A ThreadSubscription May have Many Models,
    *
    * @return \Illuminate\Database\Eluqment\Relations\HasMany
    **/
    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function getIsSubscribedToAttribute(){
        return $this->subscriptions()
            ->where('user_id', auth()->id())
            ->exists();
    }


    public function hasUpdateFor(){
        $key = auth()->user()->visitedThreadCacheKey($this);
        return $this->updated_at > cache($key);
    }
    
}
