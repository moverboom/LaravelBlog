@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="pull-left" style="margin-left: 10px;">
                                <p class="lead">{{$user->name}}</p>
                                <p class="lead text-muted">Posts</p>
                            </div>
                            @if(Auth::check() && Auth::user()->id == $user->id)
                                <div class="pull-right" style="margin-right: 10px;">
                                    <a href="{{ url('/post/create') }}" class="btn btn-info">Create Post</a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="panel-body">
                        @if(!empty($user->getPaginatedPosts()))
                            @foreach($user->getPaginatedPosts()->all() as $post)
                                <ul class="list-group">
                                    <li class="list-group-item lead">
                                        <a href="/post/{{ $post->slug }}">{{ html_entity_decode($post->title) }}</a>
                                        @if(Auth::check() && $post->author_id == Auth::user()->id)
                                            <div class="pull-right" style="margin-right: 10px;">
                                                <a href="{{ url('/post/edit/'.$post->id) }}" class="btn btn-default btn-sm">Edit</a>
                                                <a href="{{ url('/post/destroy/'.$post->id) }}" class="btn btn-default btn-sm">Delete</a>
                                            </div>
                                        @endif
                                    </li>
                                    <li class="list-group-item">{!! Markdown::string(substr($post->content, 0, 200).(strlen($post->content) > 200 ? "..." : "")) !!}</li>
                                </ul>
                            @endforeach
                        @endif
                        <div class="pull-right">
                            {!! $user->getPaginatedPosts()->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
