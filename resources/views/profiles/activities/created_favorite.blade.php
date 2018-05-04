@component('profiles.activities.activity')
	@slot('hading')
		<a href="{{ $activity->subject->favorited->path() }}">
			{{ $profileUser->name }} favorited to
		</a>
	@endslot

	@slot('body')
		{{ $activity->subject->favorited->body }}
	@endslot
@endcomponent
