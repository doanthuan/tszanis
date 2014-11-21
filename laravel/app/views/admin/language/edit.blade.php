@extends('admin.layouts.admin')

@section('content')
{{ Form::model($item, array('name' => 'adminForm', 'class' => 'form-horizontal', 'url' => 'admin/language/edit'))}}

<div class="form-group">
    {{ Form::label('lang_name', 'Language Name', array('class' => 'col-sm-2 control-label')) }}
    <div class="col-sm-6">
    {{ Form::text('lang_name', null, array('class' => 'form-control', 'required')) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('lang_code', 'Language Code', array('class' => 'col-sm-2 control-label')) }}
    <div class="col-sm-6">
    {{ Form::text('lang_code', null, array('class' => 'form-control', 'required')) }}
    </div>
</div>

{{Form::hidden('lang_id')}}

{{ Form::close()}}

@stop

@section('footer')
@parent
<script src="{{url('js/jquery.validate.min.js')}}"></script>
@stop