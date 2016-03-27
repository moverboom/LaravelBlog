@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        @if(!empty($user))
                            <div class="pull-left" style="margin-left: 10px;">
                                <p class="lead">{{$user->name}}</p>
                            </div>
                            @if(Auth::check() && Auth::user()->id == $user->id)
                                <div class="pull-right" style="margin-right: 10px;">
                                    <a href="{{ url('/post/create') }}" class="btn btn-info">Create Post</a>
                                </div>
                            @endif
                        @else
                            <div class="pull-left" style="margin-left: 10px;">
                                <p class="lead">Dashboard</p>
                            </div>
                            @if(Auth::check())
                                <div class="pull-right" style="margin-right: 10px;">
                                    <a href="{{ url('/post/create') }}" class="btn btn-info">Create Post</a>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

                <div class="panel-body">
                    @if(!empty($posts))
                        @foreach($posts->all() as $post)
                            <ul class="list-group">
                                <li class="list-group-item lead">
                                    <a href="/post/{{ $post->slug }}">{{ $post->title }}</a>
                                    @if(Auth::check() && $post->author_id == Auth::user()->id)
                                        <div class="pull-right" style="margin-right: 10px;">
                                            <a href="{{ url('/post/edit/'.$post->id) }}" class="btn btn-default btn-sm">Edit</a>
                                            <a href="{{ url('/post/destroy/'.$post->id) }}" class="btn btn-default btn-sm">Delete</a>
                                        </div>
                                    @endif
                                </li>
                                <li class="list-group-item">{{ $post->content }}</li>
                            </ul>
                        @endforeach                        
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
