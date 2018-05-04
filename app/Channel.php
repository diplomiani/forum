<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model {
	/**
	 * Get the route key for the model.
	 *
	 * @return string
	 */
	public function getRouteKeyName() {
		return 'slug';
	}

	/**
	 * A Channel May have Many threads,
	 *
	 * @return \Illuminate\Database\Eluqment\Relations\HasMany
	 **/
	public function threads() {
		return $this->hasMany(Thread::class);
	}

}
