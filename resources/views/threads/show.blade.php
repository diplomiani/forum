@extends('layouts.app')

@section('content')
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
                @foreach($replies as $reply)
                    @include('threads.reply')
                @endforeach

                {{ $replies->links() }}

                @auth
                    <form method="Post" action="/threads/{{ $thread->channel->slug }}/{{ $thread->id }}/replies">
                        @csrf
                        <div class="form-group">
                            <textarea class="form-control" rows="5" name="body" placeholder="your meesage..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Post</button>
                    </form>
                @endauth
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p>
                        This Thread was Published {{ $thread->created_at->diffForHumans() }} by
                        <a href="{{ route('profiles.show',$thread->creator) }}"> {{ $thread->creator->name }}</a>  and currently has {{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count) }}.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- @push('script')
    <script type="text/javascript">
        Vue.component('reply', {});
        new Vue({
          el: '#app'
        });
    </script>
@endpush --}}