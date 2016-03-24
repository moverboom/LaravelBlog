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
                	<h3>Personal details</h3>
                	<ul class="list-group">
                		<label>Name</label>
                		<li class="list-group-item" id="name">{{$user->name}}</li>
                		<label for="email">Email</label>
					  	<li class="list-group-item" id="email">{{$user->email}}</li>
					</ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection