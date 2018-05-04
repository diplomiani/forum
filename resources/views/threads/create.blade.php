@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Thread</div>

                <div class="card-body">
                    <form method="Post" action="{{ route('threads.store') }}">
                        @csrf
                        <div class="form-group">
                            <select name="channel_id" class="form-control">
                                <option> choose one ...</option>
                                @foreach(App\Channel::all() as $channel)
                                    <option value="{{ $channel->id }}" {{ old('channel_id')==$channel->id ? 'selected' : ''  }}> {{ $channel->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" name="title" class="form-control" placeholder="title" value="{{ old('title') }}">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" rows="8" name="body" placeholder="your meesage..." value="{{ old('title') }}"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Publish</button>
                        </div>
                        @if(count($errors))
                            @foreach($errors->all() as $error)
                                <ul class="alert alert-danger">
                                    <li>{{ $error }}</li>
                                </ul>
                            @endforeach
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
