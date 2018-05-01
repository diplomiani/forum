<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }

    /**
     * A Model May have Many Models,
     *
     * @return \Illuminate\Database\Eluqment\Relations\HasMany
     **/
    public function threads()
    {
        return $this->hasMany(Thread::class)->latest();
    }

    /**
     * A User May have Many Activities,
     *
     * @return \Illuminate\Database\Eluqment\Relations\HasMany
     **/
    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

}
