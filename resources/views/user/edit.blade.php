@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<div class="row"> 
                		<div class="pull-left" style="margin-left: 10px;"> 
	                		<p class="lead">{{ $user->name }} </p>
	                	</div>
                	</div>
                </div>
                <div class="panel-body">
                	Personal details
                    <form class="form" role="form" method="POST" action="{{ url('/user/update/'.$user->id) }}">
                        {!! csrf_field() !!}					
						<div class="form-group">
						    <label for="name">Name</label>
						    <input type="text" class="form-control" name="name" id="name" placeholder="Jane Doe" value="{{$user->name}}">
						</div>
						<div class="form-group">
						    <label for="email">Email</label>
						    <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" value="{{$user->email}}">
						</div> 
						<input type="submit" value="Update" class="btn btn-info"></input>                 
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection