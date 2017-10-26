@extends('admin.layouts.master')

@section('content')

<div class="row">
    <div class="col-sm-10 col-sm-offset-2">
        <h1>{{ trans('quickadmin::templates.templates-view_edit-edit') }}</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
                </ul>
        	</div>
        @endif
    </div>
</div>

{!! Form::model($post, array('files' => true, 'class' => 'form-horizontal', 'id' => 'form-with-validation', 'method' => 'PATCH', 'route' => array(config('quickadmin.route').'.post.update', $post->id))) !!}

<div class="form-group">
    {!! Form::label('title', 'Title*', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('title', old('title',$post->title), array('class'=>'form-control')) !!}

    </div>
</div><div class="form-group">
    {!! Form::label('content', 'Content*', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::textarea('content', old('content',$post->content), array('class'=>'form-control ckeditor')) !!}

    </div>
</div><div class="form-group">
    {!! Form::label('image', 'Image', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::file('image') !!}
        {!! Form::hidden('image_w', 4096) !!}
        {!! Form::hidden('image_h', 4096) !!}

    </div>
</div><div class="form-group">
    {!! Form::label('author', 'author', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('author', old('author',$post->author), array('class'=>'form-control')) !!}

    </div>
</div><div class="form-group">
    {!! Form::label('view_count', 'View Count', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::number('view_count', old('view_count',$post->view_count), array('class'=>'form-control')) !!}

    </div>
</div><div class="form-group">
    {!! Form::label('published', 'Published', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::select('published', $published, old('published',$post->published), array('class'=>'form-control')) !!}

    </div>
</div><div class="form-group">
    {!! Form::label('rate', 'Rate', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::number('rate', old('rate',$post->rate), array('class'=>'form-control')) !!}

    </div>
</div><div class="form-group">
    {!! Form::label('source', 'Source', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('source', old('source',$post->source), array('class'=>'form-control')) !!}

    </div>
</div><div class="form-group">
    {!! Form::label('series_id', 'Series', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::select('series_id', $series, old('series_id',$post->series_id), array('class'=>'form-control')) !!}

    </div>
</div><div class="form-group">
    {!! Form::label('user_id', 'User', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::select('user_id', $user, old('user_id',$post->user_id), array('class'=>'form-control')) !!}

    </div>
</div>

<div class="form-group">
    <div class="col-sm-10 col-sm-offset-2">
      {!! Form::submit(trans('quickadmin::templates.templates-view_edit-update'), array('class' => 'btn btn-primary')) !!}
      {!! link_to_route(config('quickadmin.route').'.post.index', trans('quickadmin::templates.templates-view_edit-cancel'), null, array('class' => 'btn btn-default')) !!}
    </div>
</div>

{!! Form::close() !!}

@endsection
