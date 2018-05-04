<div id ="app">
	<reply :attributes="{{ $reply }}" inline-template v-cloak>
		<div>	
			<div id="reply-{{ $reply->id }}" class="card-header">
				<div class="level">
					<h5 class="flex">
						<a href="{{ route('profiles.show',$reply->owner->name ) }}">
						    {{ $reply->owner->name }}
						</a>
						said {{ $reply->created_at->diffForHumans() }}...
					</h5>
					@auth
					    <div>
							<favorite :reply="{{ $reply }}"></favorite>
					    	{{-- <form method="POST" action="{{ route('favorite.store', $reply->id) }}">
					    		@csrf
					    		<button class="btn btn-default" {{ $reply->isFavorited() ? 'disabled' : '' }}>
					    			{{ $reply->favorites_count }} {{ str_plural('Favorite', $reply->favorites_count) }}
					    		</button>
					    	</form> --}}
					    </div>
					@endauth    
				</div>


			</div>
			<div class="card-body">
					<div v-if="editing">
						<div class="form-group">
							<textarea class="form-control" v-model="body">{{ $reply->body }}</textarea>
						</div>	
						<button class="btn btn-primary btn-xs" @click="update">Update</button>
						<button class="btn btn-link btn-xs" @click="editing = false">Cancel</button>
					</div>
				
				<div v-else v-text="body"></div>
			</div>

			@can('update', $reply)
				<div class="card-footer level">
					<button class="btn btn-info btn-xs mr-1" @click="editing = true">edit</button>
					<button class="btn btn-danger btn-xs mr-1" @click="destroy">Delete</button>
					{{-- <form method="POST" action="{{ route('replies.destroy', $reply->id) }}">
						@csrf
						@method('DELETE')
						<button type="submit" class="btn btn-danger btn-xs">delete</button>
					</form> --}}
				</div>
			@endcan
		</div>
	</reply>
</div>