@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<div class="row"> 
                		<div class="pull-left" style="margin-left: 10px;"> 
	                		<p class="lead">New Post</p>
	                	</div>
                	</div>
                </div>
                <div class="panel-body">
                    <form class="form" role="form" method="POST" action="{{ url('/post/create') }}">
                        {!! csrf_field() !!}					
						<div class="form-group">
						    <label for="title">Title</label>
						    <input type="text" class="form-control" name="title" id="title" placeholder="Title">
						</div>
						<div class="form-group">
						    <label for="content">Content</label>
						    <input type="text" class="form-control" name="content" id="content" placeholder="Write something beautiful!">
						</div> 
						<input type="submit" value="Post" class="btn btn-info"></input>                 
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection