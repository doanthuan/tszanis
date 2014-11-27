@extends('admin.layouts.admin')

@section('content')
{{ Form::model($item, array('name' => 'adminForm', 'class' => 'form-horizontal', 'url' => 'admin/user/edit'))}}

<div class="form-group">
    {{ Form::label('first_name', 'First Name', array('class' => 'col-sm-2 control-label')) }}
    <div class="col-sm-6">
        {{ Form::text('first_name', null, array('class' => 'form-control', 'required')) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('last_name', 'Last Name', array('class' => 'col-sm-2 control-label')) }}
    <div class="col-sm-6">
        {{ Form::text('last_name', null, array('class' => 'form-control', 'required')) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('email', 'Email', array('class' => 'col-sm-2 control-label')) }}
    <div class="col-sm-6">
        {{ Form::text('email', null, array('class' => 'form-control email', 'required')) }}
    </div>
</div>

<?php
$pswRequired = isset($item->user_id)?'':'required';
?>

<div class="form-group">
    {{ Form::label('password', 'Password', array('class' => 'col-sm-2 control-label')) }}
    <div class="col-sm-6">
        {{ Form::password('password', array('class' => 'form-control ', $pswRequired)) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('password_confirmation', 'Password Confirmation', array('class' => 'col-sm-2 control-label')) }}
    <div class="col-sm-6">
        {{ Form::password('password_confirmation', array('class' => 'form-control ', $pswRequired)) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('phone', 'Phone', array('class' => 'col-sm-2 control-label')) }}
    <div class="col-sm-6">
        {{ Form::text('phone', null, array('class' => 'form-control', 'required')) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('timezone_id', 'TimeZone', array('class' => 'col-sm-2 control-label')) }}
    <div class="col-sm-6">
        {{Form::select('timezone_id', TimeZone::lists('value', 'timezone_id'), null, array('class' => 'form-control'))}}
    </div>
</div>

<div class="form-group">
    {{ Form::label('country_id', 'Country', array('class' => 'col-sm-2 control-label')) }}
    <div class="col-sm-6">
        {{Form::select('country_id', Country::lists('country_name', 'country_id'), null, array('class' => 'form-control'))}}
    </div>
</div>

<div class="form-group">
    {{ Form::label('languages', 'Languages', array('class' => 'col-sm-2 control-label')) }}
    <div class="col-sm-6">
        {{Form::select('languages[]', Language::lists('lang_name', 'lang_id'), $item->languages()->lists('lang_id'), array('class' => 'form-control', 'multiple' => 'multiple'))}}
    </div>
</div>

<div class="form-group">
    {{ Form::label('role_id', 'Role', array('class' => 'col-sm-2 control-label')) }}
    <div class="col-sm-6">
        {{Form::select('role_id', Role::lists('role_name', 'role_id'), null, array('class' => 'form-control'))}}
    </div>
</div>

<input type="hidden" name="status" value="2">

{{Form::hidden('user_id')}}

{{ Form::close()}}

@stop

@section('footer')
@parent
<script src="{{url('js/jquery.validate.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('form[name="adminForm"]').validate({
            rules : {
                password : {
                    minlength : 8
                },
                password_confirmation : {
                    minlength : 8,
                    equalTo : "#password"
                }
            }
        });
    });
</script>
@stop