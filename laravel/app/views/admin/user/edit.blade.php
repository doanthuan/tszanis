@extends('admin.layouts.admin')

@section('content')
{{ Form::model($item, array('name' => 'adminForm', 'class' => 'form-horizontal', 'url' => 'admin/account/edit'))}}

<div class="form-group">
    {{ Form::label('username', 'User Name', array('class' => 'col-sm-2 control-label')) }}
    <div class="col-sm-6">
        {{ Form::text('username', null, array('class' => 'form-control', 'required')) }}
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