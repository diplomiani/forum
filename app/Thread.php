<?php

namespace App;

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
        $this->replies()->forceCreate($reply);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
