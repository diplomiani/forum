<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ThreadSubscription extends Model
{
    protected $guarded = [];

    /**
     * A ThreadSubscription  Belongs to a user,
     *
     * @return \Illuminate\Database\Eluqment\Relations\BelongsTo
    **/
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
