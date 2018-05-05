@extends('layouts.app')

@section('content')
<thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="level">
                            <span class="flex">
                                <a href="{{ route('profiles.show', $thread->creator->name) }}">
                                    {{ $thread->creator->name }} posted:
                                </a>
                                {{ $thread->title }}
                            </span>
                            @can('delete',$thread)
                                <form action="/threads/{{ $thread->channel->slug }}/{{ $thread->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            @endcan
                        </div>
                    </div>

                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                    <br>
                    <replies 
                        :data="{{ $thread->replies }}" 
                        @removed="repliesCount--"
                        @added="repliesCount++">
                            
                    </replies>
                    {{-- @foreach($replies as $reply)
                        @include('threads.reply')
                    @endforeach

                    {{ $replies->links() }} --}}
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p>
                            This Thread was Published {{ $thread->created_at->diffForHumans() }} by
                            <a href="{{ route('profiles.show',$thread->creator) }}"> {{ $thread->creator->name }}</a>  and currently has <span v-text="repliesCount"></span> {{ str_plural('comment', $thread->replies_count) }}.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</thread-view>    

@endsection
