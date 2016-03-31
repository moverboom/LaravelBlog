@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<div class="row"> 
                		<div class="pull-left" style="margin-left: 10px;"> 
	                		<p class="lead">{{ $post->title }}</p>
	                	</div>
	                	@if(Auth::check() && $post->author_id == Auth::user()->id)
	                        <div class="pull-right" style="margin-right: 10px;">
	                            <a href="{{ url('/post/edit/'.$post->id) }}" class="btn btn-default btn-sm">Edit</a>
	                    	    <a href="{{ url('/post/destroy/'.$post->id) }}" class="btn btn-default btn-sm">Delete</a>
	                        </div>
	                    @endif
                	</div>
                </div>
                <div class="panel-body">
                    @if(!empty($errors))
                        <ul>
                            @foreach($errors->all() as $message)
                                <li style="color: darkred">{{ $message }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="lead">{{ $post->content }}</div>
                </div>
                <div class="panel-footer">
                	<div class="text-muted">
                    	Created at: {{$post->created_at->toDateString()}} | 
                    	Author: <a href="/user/{{$post->getAuthor->id}}">{{$post->getAuthor->name}}</a>
                    </div>
                </div>
            </div>
            <br>
            <div class="panel panel-default">
				<!-- Default panel contents -->
			  	<div class="panel-heading">Comments</div>
			  		@if(Auth::check())
				  		<div class="panel-body">
				  			{!! Form::open(array('route' => array('comment/create', $post), 'method' => 'POST', 'role' => 'form' )) !!}
				  				<div class="form-group">
				  					{!! Form::label('content', 'New Comment', array('for' => 'content')) !!}
	                            	{!! Form::text('content', '', array('class' => 'form-control', 
	                                                                            'id' => 'content', 'placeholder' => 'Great Post!')) !!}
	                            </div>
	                            {!! Form::submit('Post', array('class' => 'btn btn-info pull-right', 'type' => 'submit')) !!}
				  			{!! Form::close() !!}
				  		</div>
			  		@endif
			  		@if(!empty($post->getComments()))
					  	<!-- comments list group -->
					  	<ul class="list-group">
					  		@foreach($post->getComments->all() as $comment)
					    		<li class="list-group-item">
					    			<a href="/user/{{ $comment->getUser->userid }}" class="text-muted">{{ $comment->getUser->name }}</a>
					    			<br>
					    			{{ $comment->content }}
					    		</li>
					    	@endforeach
					  	</ul>
				  	@endif
				</div>
        </div>
    </div>
</div>
@endsection