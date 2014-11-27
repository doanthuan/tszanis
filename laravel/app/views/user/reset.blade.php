@extends('user.layouts.main')

@section('content')

{{ Form::open(array('class' => 'form-reset', 'url' => 'password/reset', 'id' => 'reset-form')) }}

<h3>Password Reset</h3>

<div class="form-group">
    {{ Form::label('email', 'Email') }}
    {{ Form::text('email', null, array('class' => 'form-control', 'required')) }}
</div>

<div class="form-group">
    {{ Form::label('password', 'Password') }}
    {{ Form::password('password', array('class' => 'form-control', 'required')) }}
</div>

<div class="form-group">
    {{ Form::label('password_confirmation', 'Password Confirmation') }}
    {{ Form::password('password_confirmation', array('class' => 'form-control', 'required')) }}
</div>

<div class="form-group">
    <input type="submit" class="btn btn-primary" value="Submit">
</div>

<input type="hidden" name="token" value="{{ $token }}">

{{ Form::close() }}

<script type="text/javascript">
    $(function () {
        $('#reset-form').validate({
            rules : {
                email:{
                    email: true
                },
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

@section('footer')
@parent
{{ HTML::script('js/jquery.validate.min.js') }}
@stop

@stop