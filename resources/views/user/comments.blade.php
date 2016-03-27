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
                                <p>Comments</p>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="panel-body">
                    @foreach($user->getComments->all() as $comment)
                        <ul class="list-group">
                            <li class="list-group-item">
                                <a href="/post/{{ $comment->getPost->slug }}">{{ $comment->getPost->title }}</a>
                            </li>
                            <li class="list-group-item lead">
                                {{ $comment->content }}
                                @if(Auth::check() && $user->id == Auth::user()->id)
                                    <div class="pull-right" style="margin-right: 10px;">
                                        <a href="{{ url('/comment/edit/'.$comment->id) }}" class="btn btn-default btn-sm">Edit</a>
                                        <a href="{{ url('/comment/destroy/'.$comment->id) }}" class="btn btn-default btn-sm">Delete</a>
                                    </div>
                                @endif
                            </li>
                        </ul>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
