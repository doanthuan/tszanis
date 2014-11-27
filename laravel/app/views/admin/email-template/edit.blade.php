@extends('admin.layouts.admin')

@section('content')
{{ Form::model($item, array('name' => 'adminForm', 'class' => 'form-horizontal', 'url' => 'admin/email-template/edit'))}}

<div class="form-group">
    {{ Form::label('subject', 'Subject', array('class' => 'col-sm-2 control-label')) }}
    <div class="col-sm-6">
    {{ Form::text('subject', null, array('class' => 'form-control', 'required')) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('content', 'Content', array('class' => 'col-sm-2 control-label')) }}
    <div class="col-sm-6">
    {{ Form::textarea('content', null, array('class' => 'form-control', 'required')) }}
    </div>
</div>


{{Form::hidden('email_id')}}

{{ Form::close()}}

@stop

@section('footer')
@parent
<script src="{{url('js/jquery.validate.min.js')}}"></script>
@stop