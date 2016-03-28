@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="pull-left" style="margin-left: 10px;">
							<p class="lead">{{ $user->name }} </p>
							<p>Personal Details</p>
						</div>
					</div>
				</div>
                <div class="panel-body">
					{!! Form::model($user, array('route' => array('user/update', $user), 'method' => 'POST', 'role' => 'form' )) !!}
						{!! csrf_field() !!}
						<div class="form-group">
							{!! Form::label('name', 'Name', array('for' => 'name')) !!}
							{!! Form::text('name', $user->name, $attributes = array('class' => 'form-control', 'placeholder' => 'Name')) !!}
						</div>
						<div class="form-group">
							{!! Form::label('email', 'Content', array('for' => 'email')) !!}
							{!! Form::email('email', $user->email, $attributes = array('class' => 'form-control', 'type' => 'email', 'placeholder' => 'you@mail.com')) !!}
						</div>
						{!! Form::submit('Update', array('class' => 'btn btn-info', 'type' => 'submit')) !!}
					{!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection