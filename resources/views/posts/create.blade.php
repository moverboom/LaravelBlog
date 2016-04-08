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
                    @if($errors->any())
                        <ul>
                            @foreach($errors->all() as $error)
                                <li style="color: darkred">{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                    {!! Form::open(array('url' => 'post/create', 'method' => 'POST', 'role' => 'form' )) !!}
                        {!! csrf_field() !!}					
						<div class="form-group">
						    {!! Form::label('title', 'Title', array('for' => 'title')) !!}
                            {!! Form::text('title', '', array('class' => 'form-control', 
                                                                            'id' => 'title', 'placeholder' => 'Title')) !!}
						</div>
						<div class="form-group">
						    {!! Form::label('content', 'Content', array('for' => 'content')) !!}
                            {!! Form::textarea('content', '', array('class' => 'form-control', 'id' => 'content', 'rows' => '4', 'cols' => '5', 'placeholder' => 'Write something beautiful!')) !!}
						</div> 
                        {!! Form::submit('Post', array('class' => 'btn btn-info', 'type' => 'submit')) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection