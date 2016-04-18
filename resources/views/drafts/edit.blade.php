@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="pull-left" style="margin-left: 10px;">
                                <p class="lead">Edit Draft</p>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body" style="overflow: auto;">
                        @if(!empty($errors))
                            <ul>
                                @foreach($errors->all() as $message)
                                    <li style="color: darkred">{{ $message }}</li>
                                @endforeach
                            </ul>
                        @endif
                        {!! Form::model($draft, array('url' => array('draft/edit', $draft), 'method' => 'POST', 'role' => 'form' )) !!}
                        {!! csrf_field() !!}
                        <div class="form-group">
                            {!! Form::label('title', 'Title', array('for' => 'title')) !!}
                            {!! Form::text('title', $draft->title, $attributes = array('class' => 'form-control', 'placeholder' => 'Title')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('content', 'Content', array('for' => 'content')) !!}
                            {!! Form::textarea('content', $draft->content, $attributes = array('class' => 'form-control', 'rows' => '10', 'cols' => '5', 'placeholder' => 'Write something beautiful!')) !!}
                        </div>
                            {!! Form::submit('Publish', array('class' => 'btn btn-info', 'type' => 'submit', 'name' => 'action')) !!}
                            {!! Form::submit('Save', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'action')) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection