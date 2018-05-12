@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Threads</div>

                <div class="card-body">
                    @forelse($threads as $thread)
                        <div class="level">
                            <h4 class="flex">
                                <a href="/threads/{{ $thread->channel->slug }}/{{ $thread->id }}">
                                    
                                    @if(auth()->check() && $thread->hasUpdateFor(auth()->user()))
                                        <strong>
                                            {{ $thread->title }}
                                        </strong>
                                    @else
                                        {{ $thread->title }}
                                    @endif
                                </a>
                            </h4>
                            <a href="/threads/{{ $thread->channel->slug }}/{{ $thread->id }}">
                                {{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}
                            </a>
                        </div>

                        <div class="body">{{ $thread->body }}</div>
                        <hr>
                    @empty
                    <p>There are relevant results at this time.</p>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
