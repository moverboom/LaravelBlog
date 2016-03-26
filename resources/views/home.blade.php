@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="pull-left" style="margin-left: 10px;"> 
                            <p class="lead">Dashboard</p>
                        </div>
                        <div class="pull-right" style="margin-right: 10px;">
                            <a href="{{ url('/post/create') }}" class="btn btn-info">Create Post</a>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    @if(!empty($posts))
                        @foreach($posts->all() as $post)
                            <ul class="list-group">
                                <li class="list-group-item lead">{{ $post->title }}</li>
                                <li class="list-group-item">{{ $post->body }}</li>
                            </ul>
                        @endforeach                        
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
